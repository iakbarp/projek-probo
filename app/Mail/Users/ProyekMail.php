<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProyekMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $judul, $deskripsi, $waktu_pengerjaan, $harga)
    {
        $this->name = $name;
        $this->judul = $judul;
        $this->deskripsi = $deskripsi;
        $this->waktu_pengerjaan = $waktu_pengerjaan;
        $this->harga = $harga;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->name;
        $judul = $this->judul;
        $deskripsi = $this->deskripsi;
        $waktu_pengerjaan = $this->waktu_pengerjaan;
        $harga = $this->harga;
        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))->subject('Undangan Proyek dari UNDAGI')
            ->view('emails.users.invoice-proyek', compact('judul', 'deskripsi', 'waktu_pengerjaan', 'harga', 'name'));
    }
}
