<?php

namespace App\Mail\Users;

use App\Model\Pengerjaan;
use App\Model\PengerjaanLayanan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembayaranProyekMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code, $payment, $instruction, $pembayaran, $sisa_pembayaran;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $payment, $instruction, $pembayaran, $sisa_pembayaran)
    {
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
        $payment = $this->payment;
        $code = $this->code;
        $pembayaran = $this->pembayaran;
        $sisa = $this->sisa_pembayaran;

        if (strpos($code, 'PRO') !== false) {
            $data = Pengerjaan::where('proyek_id', substr(strtok($code, '_'), 4))->first();
            $data2 = $data->get_project;
            $invoice = '#INV/' . Carbon::parse($pembayaran->created_at)->format('Ymd') . '/' . $pembayaran->id;
            $name = 'Proyek';
        } else {
            $data = PengerjaanLayanan::find(substr(strtok($code, '_'), 4));
            $data2 = $data->get_service;
            $invoice = '#INV/' . Carbon::parse($pembayaran->created_at)->format('Ymd') . '/' . $pembayaran->id;
            $name = 'Layanan';
        }

        if ($pembayaran->selesai == false && $pembayaran->bukti_pembayaran == null) {
            $subject = 'Menunggu Pembayaran ' .$name. ' ' . strtoupper(str_replace('_', ' ', $payment['type'])) .
                ' #' . $code;
        } else {
            $subject = 'Checkout Pesanan dengan ID Pembayaran '.$name.' #' . $code . ' Berhasil Dikonfirmasi pada ' .
                Carbon::parse($pembayaran->created_at)->formatLocalized('%d %B %Y – %H:%M');
        }

       /* if (!is_null($this->instruction)) {
            $this->attach(public_path('storage/users/invoice/' . $data->user_id . '/' . $this->instruction));
        }*/

        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))->subject($subject)
            ->view('emails.users.invoice', compact('code', 'data', 'data2', 'pembayaran', 'payment', 'sisa', 'invoice', 'name'));
    }
}
