<?php

namespace App\Mail\Users;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PembayaranProyekMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code, $data, $payment, $filename, $instruction, $pembayaran, $sisa_pembayaran;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $data, $payment, $instruction, $pembayaran, $sisa_pembayaran)
    {
        $this->code = $code;
        $this->data = $data;
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
        $data = $this->data;
        $payment = $this->payment;
        $code = $this->code;
        $pembayaran = $this->pembayaran;
        $sisa_pembayaran = $this->sisa_pembayaran;
        $invoice = '#INV/' . Carbon::parse($this->data->created_at)->format('Ymd') . '/' . $this->data->id;
        if ($data->selesai == false && $data->bukti_pembayaran == null) {
            $subject = 'Menunggu Pembayaran ' . strtoupper(str_replace('_', ' ', $payment['type'])) .
                ' #' . $code;
        } else {
            $subject = 'Checkout Pesanan dengan ID Pembayaran #' . $code . ' Berhasil Dikonfirmasi pada ' .
                Carbon::parse($data->created_at)->formatLocalized('%d %B %Y – %H:%M');
        }

        if (!is_null($this->instruction)) {
            $this->attach(public_path('storage/users/invoice/' . $data->user_id . '/' . $this->instruction));
        }

        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))->subject($subject)
            ->view('emails.users.invoice', compact('code', 'data', 'payment', 'pembayaran', 'sisa_pembayaran', 'invoice'));
    }
}
