<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Users\PembayaranProyekMail;
use App\Model\Pembayaran;
use App\Model\PembayaranLayanan;
use App\Model\Pengerjaan;
use App\Model\PengerjaanLayanan;
use App\Model\Topup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $amount = $cek == 'topup' ? $request->jumlah : $request->jumlah_pembayaran;

        if ($cek == 'project') {
            $pengerjaan = Pengerjaan::find($request->id);
            $name = $pengerjaan->get_project->judul;
        } elseif ($cek == 'service') {
            $pengerjaan = PengerjaanLayanan::find($request->id);
            $name = $pengerjaan->get_service->judul;
        } else{
            $topup = Topup::firstOrCreate([
                'user_id' => $request->user_id,
                'jumlah' => ceil(str_replace('.','',$amount)),
            ]);
            $name = 'TOPUP UNDAGI: Rp'.number_format($topup->jumlah,2,',','.');
        }
        $user = User::find($request->user_id);
        $split_name = explode(" ", $user->name);

        if(ceil(str_replace('.', '', $amount)) < 10000) {
            return response()->json([
                'error' => true,
                'message' => 'Maaf saat ini Anda tidak bisa melanjutkan proses checkout, karena total transaksi pembelian Anda masih kurang dari Rp' . number_format(10000, 2, ',', '.') . ' :('
            ], 200);
        } else {
            return response()->json([
                'error' => false,
                'data' => Snap::getSnapToken([
                    'enabled_payments' => $this->channels,
                    'transaction_details' => [
                        'order_id' => $cek == 'project' ?
                            strtoupper('PRO-' . $pengerjaan->proyek_id . '_' . now()->timestamp) :
                            ($cek == 'service' ? strtoupper('SER-' . $pengerjaan->id . '_' . now()->timestamp) :
                                strtoupper('TOP-' . $topup->id . '_' . now()->timestamp)),
                        'gross_amount' => $cek == 'topup' ? ceil($topup->jumlah) : ceil(str_replace('.', '', $amount)),
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
                                ($cek == 'service' ? strtoupper('SERVICE-' . str_pad($pengerjaan->id, 4, STR_PAD_LEFT)) :
                                    strtoupper('TOPUP-' . str_pad($topup->id, 4, STR_PAD_LEFT))),
                            'price' => $cek == 'topup' ? ceil($topup->jumlah) :
                                ceil(str_replace('.', '', $amount)),
                            'quantity' => 1,
                            'name' => $cek == 'topup' ? $name :
                                ($request->dp == 1 ? $name . ' (DP)' : $name . ' (FP)'),
                            'category' => $cek == 'topup' ? 'TOPUP Payment' : ($cek == 'project' ? 'Project Payment' : 'Service Payment')
                        )
                    ],
                    'custom_field1' => $user->id,
                    'custom_field2' => $cek == 'topup' ? null : $request->dp,
                ])
            ], 200);
        }
    }

    public function notificationCallback()
    {
        $notif = new Notification();
        $data_tr = collect(Transaction::status($notif->transaction_id))->toArray();
        if (strpos($notif->order_id, 'PRO') !== false) {
            $pengerjaan = Pengerjaan::where('proyek_id', substr(strtok($notif->order_id, '_'), 4))->first();
            $pembayaran = $pengerjaan->get_project->get_pembayaran;
            $name = 'Pembayaran proyek "' . $pengerjaan->get_project->judul . '"';
        } elseif (strpos($notif->order_id, 'SER') !== false) {
            $pengerjaan = PengerjaanLayanan::find(substr(strtok($notif->order_id, '_'), 4));
            $pembayaran = $pengerjaan->get_pembayaran;
            $name = 'Pembayaran layanan "' . $pengerjaan->get_service->judul . '"';
        } else {
            $pembayaran = Topup::find(substr(strtok($notif->order_id, '_'), 4));
            $name = 'Pembayaran TOPUP "UNDAGI"';
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
//                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                            ]);
                        } else {
                            $pembayaran = PembayaranLayanan::firstOrCreate([
                                'pengerjaan_layanan_id' => $pengerjaan->id,
                                'dp' => $data_tr['custom_field2'],
//                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                            ]);
                        }
                    } else {
                        $sisa_pembayaran = $data_tr['gross_amount'];
                        if (strpos($notif->order_id, 'PRO') !== false) {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
//                                'jumlah_pembayaran' => $pengerjaan->get_project->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
//                                'bukti_pembayaran' => null,
                            ]);
                        } elseif (strpos($notif->order_id, 'SER') !== false) {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
//                                'jumlah_pembayaran' => $pengerjaan->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
//                                'bukti_pembayaran' => null,
                            ]);
                        } else {
                            // TODO topup pending
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
                                'bukti_pembayaran' => $data_tr['custom_field2'] == 1 ?
                                    'DP Rp'.number_format($data_tr['gross_amount'],2,',','.').' - '.now()->format('j F Y') :
                                    'FP - '.now()->format('j F Y'),
//                                'selesai' => $data_tr['custom_field2'] == 1 ? false : true,
                                'selesai' => false,
                            ]);
                        } else {
                            $pembayaran = PembayaranLayanan::firstOrCreate([
                                'pengerjaan_layanan_id' => $pengerjaan->id,
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['gross_amount'],
                                'bukti_pembayaran' => $data_tr['custom_field2'] == 1 ?
                                    'DP Rp'.number_format($data_tr['gross_amount'],2,',','.').' - '.now()->format('j F Y') :
                                    'FP - '.now()->format('j F Y'),
//                                'selesai' => $data_tr['custom_field2'] == 1 ? false : true
                                'selesai' => false,
                            ]);
                        }
                    } else {
                        $sisa_pembayaran = $data_tr['gross_amount'];
                        if (strpos($notif->order_id, 'PRO') !== false) {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['custom_field2'] == 1 ?
//                                    $pengerjaan->get_project->get_pembayaran->jumlah_pembayaran :
                                    $data_tr['gross_amount'] :
                                    $pengerjaan->get_project->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                                'bukti_pembayaran' => $data_tr['custom_field2'] == 1 ?
                                    'DP Rp'.number_format($data_tr['gross_amount'],2,',','.').' - '.now()->format('j F Y') :
                                    'FP - '.now()->format('j F Y'),
//                                'selesai' => $data_tr['custom_field2'] == 1 ? false : true
                                'selesai' => false,
                            ]);
                        } elseif (strpos($notif->order_id, 'SER') !== false) {
                            $pembayaran->update([
                                'dp' => $data_tr['custom_field2'],
                                'jumlah_pembayaran' => $data_tr['custom_field2'] == 1 ?
//                                    $pengerjaan->get_pembayaran->jumlah_pembayaran :
                                    $data_tr['gross_amount'] :
                                    $pengerjaan->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                                'bukti_pembayaran' => $data_tr['custom_field2'] == 1 ?
                                    'DP Rp'.number_format($data_tr['gross_amount'],2,',','.').' - '.now()->format('j F Y') :
                                    'FP - '.now()->format('j F Y'),
//                                'selesai' => $data_tr['custom_field2'] == 1 ? false : true
                                'selesai' => false,
                            ]);
                        } else {
                            $pembayaran->update(['konfirmasi' => true]);
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
                    $this->invoiceMail('expired', $notif->order_id, $user, null, $data_tr, $pembayaran, 0);

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
            $account = $data_tr['biller_code'].' / '.$data_tr['bill_key'];
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

        Mail::to($user->email)->send(new PembayaranProyekMail($status, $code, $payment, $instruction, $pembayaran, $sisa_pembayaran));
    }
}
