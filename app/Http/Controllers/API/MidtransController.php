<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Users\PembayaranProyekMail;
use App\Model\Pembayaran;
use App\Model\PembayaranLayanan;
use App\Model\Pengerjaan;
use App\Model\PengerjaanLayanan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransController extends Controller
{
    public $channels;

    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); // Set your Merchant Server Key
        Config::$isProduction = false; // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isSanitized = true; // Set sanitization on (default)
        Config::$is3ds = true; // Set 3DS transaction for credit card to true

        // Uncomment for append and override notification URL
        // Config::$appendNotifUrl = "https://example.com";
        // Config::$overrideNotifUrl = "https://example.com";

        // Optional, remove this to display all available payment methods
        $this->channels = ["credit_card", "bca_va", "echannel", "bni_va", "permata_va", "other_va"];
    }

    public function snap(Request $request)
    {
        app()->setLocale('id');
        $cek = $request->cek;

        if ($cek == 'project') {
            $pengerjaan = Pengerjaan::find($request->id);
            $name = $pengerjaan->get_project->judul;
        } else {
            $pengerjaan = PengerjaanLayanan::find($request->id);
            $name = $pengerjaan->get_service->judul;
        }
        $user = User::find($request->user_id);
        $split_name = explode(" ", $user->name);

        return Snap::getSnapToken([
            'enabled_payments' => $this->channels,
            'transaction_details' => [
                'order_id' => $cek == 'project' ?
                    strtoupper('PRO-' . $pengerjaan->proyek_id.'_'.now()->timestamp) : strtoupper('SER-' . $pengerjaan->id.'_'.now()->timestamp),
                'gross_amount' => ceil(str_replace('.', '', $request->jumlah_pembayaran)),
            ],
            'customer_details' => [
                'first_name' => array_shift($split_name),
                'last_name' => implode(" ", $split_name),
                'phone' => $user->get_bio->hp,
                'email' => $user->email,
                'address' => $user->get_bio->alamat,
                'billing_address' => [
                    'first_name' => array_shift($split_name),
                    'last_name' => implode(" ", $split_name),
                    'address' => $user->get_bio->alamat,
                    'city' => $user->get_bio->get_kota->get_provinsi->nama . ', ' . $user->get_bio->get_kota->nama,
                    'postal_code' => $user->get_bio->kode_pos,
                    'phone' => $user->get_bio->hp,
                    'country_code' => 'IDN'
                ],
                'shipping_address' => [
                    'first_name' => array_shift($split_name),
                    'last_name' => implode(" ", $split_name),
                    'address' => $user->get_bio->alamat,
                    'city' => $user->get_bio->get_kota->get_provinsi->nama . ', ' . $user->get_bio->get_kota->nama,
                    'postal_code' => $user->get_bio->kode_pos,
                    'phone' => $user->get_bio->hp,
                    'country_code' => 'IDN'
                ],
            ],
            'item_details' => [
                array(
                    'id' => $cek == 'project' ?
                        strtoupper('PROJECT-' . str_pad($pengerjaan->proyek_id, 4, STR_PAD_LEFT)) :
                        strtoupper('SERVICE-' . str_pad($pengerjaan->id, 4, STR_PAD_LEFT)),
                    'price' => ceil(str_replace('.', '', $request->jumlah_pembayaran)),
                    'quantity' => 1,
                    'name' => $request->dp == 1 ? $name . ' (DP)' : $name . ' (FP)',
                    'category' => $cek == 'project' ? 'Project Payment' : 'Service Payment'
                )
            ],
            'custom_field1' => $user->id,
            'custom_field2' => $request->dp,
        ]);
    }

    public function notificationCallback()
    {
        $notif = new Notification();
        $data_tr = collect(Transaction::status($notif->transaction_id))->toArray();
        if (strpos($notif->order_id, 'PRO') !== false) {
            $pengerjaan = Pengerjaan::where('proyek_id', substr(strtok($notif->order_id, '_'), 4))->first();
            $pembayaran = $pengerjaan->get_project->get_pembayaran;
            $name = 'Pembayaran proyek "' . $pengerjaan->get_project->judul . '"';
        } else {
            $pengerjaan = PengerjaanLayanan::find(substr(strtok($notif->order_id, '_'), 4));
            $pembayaran = $pengerjaan->get_pembayaran;
            $name = 'Pembayaran layanan "' . $pengerjaan->get_service->judul . '"';
        }
        $user = User::find($data_tr['custom_field1']);

        try {
            if (
                !array_key_exists('fraud_status', $data_tr) ||
                (array_key_exists('fraud_status', $data_tr) && $data_tr['fraud_status'] == 'accept')
            ) {

                if ($data_tr['transaction_status'] == 'pending') {
                    DB::beginTransaction();

                    if (is_null($pembayaran)) {
                        $sisa_pembayaran = 0;
                        if (strpos($notif->order_id, 'PRO') !== false) {
                            $pembayaran = Pembayaran::firstOrCreate([
                                'proyek_id' => $pengerjaan->proyek_id,
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                            ]);
                        } else {
                            $pembayaran = PembayaranLayanan::firstOrCreate([
                                'pengerjaan_layanan_id' => $pengerjaan->id,
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                            ]);
                        }
                    } else {
                        $sisa_pembayaran = $data_tr['gross_amount'];
                        if (strpos($notif->order_id, 'PRO') !== false) {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $pengerjaan->get_project->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                                'bukti_pembayaran' => null,
                            ]);
                        } else {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $pengerjaan->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                                'bukti_pembayaran' => null,
                            ]);
                        }
                    }

                    $this->invoiceMail('unfinish', $notif->order_id, $user, null, $data_tr, $pembayaran, $sisa_pembayaran);

                    DB::commit();
                    return $name . ' dengan ID #' . $notif->order_id . ' berhasil di checkout!';

                } elseif ($data_tr['transaction_status'] == 'capture' || $data_tr['transaction_status'] == 'settlement') {
                    DB::beginTransaction();

                    if (is_null($pembayaran)) {
                        $sisa_pembayaran = 0;
                        if (strpos($notif->order_id, 'PRO') !== false) {
                            $pembayaran = Pembayaran::firstOrCreate([
                                'proyek_id' => $pengerjaan->proyek_id,
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                                'bukti_pembayaran' => $data_tr['custom_field2'] == 1 ? 'dp.jpg' : 'lunas.jpg',
                                'selesai' => $data_tr['custom_field2'] == 1 ? false : true
                            ]);
                        } else {
                            $pembayaran = PembayaranLayanan::firstOrCreate([
                                'pengerjaan_layanan_id' => $pengerjaan->id,
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                                'bukti_pembayaran' => $data_tr['custom_field2'] == 1 ? 'dp.jpg' : 'lunas.jpg',
                                'selesai' => $data_tr['custom_field2'] == 1 ? false : true
                            ]);
                        }
                    } else {
                        $sisa_pembayaran = $data_tr['gross_amount'];
                        if (strpos($notif->order_id, 'PRO') !== false) {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $pengerjaan->get_project->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                                'bukti_pembayaran' => 'lunas.jpg',
                                'selesai' => true
                            ]);
                        } else {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $pengerjaan->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                                'bukti_pembayaran' => 'lunas.jpg',
                                'selesai' => true
                            ]);
                        }
                    }
                    $this->invoiceMail('finish', $notif->order_id, $user, null, $data_tr, $pembayaran, $sisa_pembayaran);

                    DB::commit();
                    return $name . ' dengan ID #' . $notif->order_id . ' berhasil dikonfirmasi!';

                } elseif ($data_tr['transaction_status'] == 'expired') {
                    DB::beginTransaction();

                    if (!is_null($pembayaran)) {
                        $pembayaran->delete();
                    }

                    DB::commit();

                    return $name . ' dengan ID #' . $notif->order_id . ' telah dibatalkan!';
                }
            }
        } catch (\Exception $exception) {
            return response()->json($exception, 500);
        }
    }

    private function invoiceMail($status, $code, $user, $pdf_url, $data_tr, $pembayaran, $sisa_pembayaran)
    {
        $data = Pesanan::where('uni_code', $code)->first();

        if ($data_tr['payment_type'] == 'credit_card') {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['card_type'];
            $account = $data_tr['masked_card'];
        } else if ($data_tr['payment_type'] == 'bank_transfer') {
            $type = $data_tr['payment_type'];

            if (array_key_exists('permata_va_number', $data_tr)) {
                $bank = 'permata';
                $account = $data_tr['permata_va_number'];
            } else {
                $bank = implode((array)$data_tr['va_numbers'][0]->bank);
                $account = implode((array)$data_tr['va_numbers'][0]->va_number);
            }
        } else if ($data_tr['payment_type'] == 'echannel') {
            $type = 'bank_transfer';
            $bank = 'mandiri';
            $account = $data_tr['bill_key'];
        } else if ($data_tr['payment_type'] == 'cstore') {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['store'];
            $account = $data_tr['payment_code'];
        } else {
            $type = $data_tr['payment_type'];
            $bank = $data_tr['payment_type'];
            $account = null;
        }

        $payment = [
            'type' => $type,
            'bank' => $bank,
            'account' => $account,
        ];

        if (!is_null($pdf_url)) {
            $instruction = $code . '-instruction.pdf';
            Storage::put('public/users/invoice/' . $user->id . '/' . $instruction, file_get_contents($pdf_url));
        } else {
            $instruction = null;
        }

        Mail::to($user->email)
            ->send(new PembayaranProyekMail($code, $data, $payment, $instruction, $pembayaran, $sisa_pembayaran));
    }
}
