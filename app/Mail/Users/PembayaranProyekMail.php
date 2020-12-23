<?php

namespace App\Mail\Users;

use App\Model\Pengerjaan;
use App\Model\PengerjaanLayanan;
use App\Model\Topup;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembayaranProyekMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status, $code, $payment, $instruction, $pembayaran, $sisa_pembayaran;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status, $code, $payment, $instruction, $pembayaran, $sisa_pembayaran)
    {
        $this->status = $status;
        $this->code = $code;
        $this->payment = $payment;
        $this->instruction = $instruction;
        $this->pembayaran = $pembayaran;
        $this->sisa_pembayaran = $sisa_pembayaran;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $status = $this->status;
        $payment = $this->payment;
        $code = $this->code;
        $pembayaran = $this->pembayaran;
        $sisa = $this->sisa_pembayaran;
        $invoice = '#INV/' . Carbon::parse($pembayaran->created_at)->format('Ymd') . '/' . $pembayaran->id;

        if (strpos($code, 'PRO') !== false) {
            $data = Pengerjaan::where('proyek_id', substr(strtok($code, '_'), 4))->first();
            $data2 = $data->get_project;
            $name = 'Proyek';
        } elseif (strpos($code, 'SER') !== false) {
            $data = PengerjaanLayanan::find(substr(strtok($code, '_'), 4));
            $data2 = $data->get_service;
            $name = 'Layanan';
        } else {
            $data = Topup::find(substr(strtok($code, '_'), 4));
            $data2 = 'TOPUP UNDAGI';
            $name = 'TOPUP';
        }

        if ($status == 'expired') {
            $subject = 'Pembayaran '.$name.' dengan ID #' . $code . ' Telah Dibatalkan';
        } else {
            if ($pembayaran->selesai == false && $pembayaran->bukti_pembayaran == null) {
                $subject = 'Menunggu Pembayaran ' . $name . ' ' . strtoupper(str_replace('_', ' ', $payment['type'])) .
                    ' #' . $code;
            } else {
                $subject = 'Checkout Pesanan dengan ID Pembayaran ' . $name . ' #' . $code . ' Berhasil Dikonfirmasi pada ' .
                    Carbon::parse($pembayaran->created_at)->formatLocalized('%d %B %Y – %H:%M');
            }
        }
        /* if (!is_null($this->instruction)) {
             $this->attach(public_path('storage/users/invoice/' . $data->user_id . '/' . $this->instruction));
         }*/

        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))->subject($subject)
            ->view('emails.users.invoice', compact('status', 'code', 'data', 'data2', 'pembayaran', 'payment', 'sisa', 'invoice', 'name'));
    }
}
