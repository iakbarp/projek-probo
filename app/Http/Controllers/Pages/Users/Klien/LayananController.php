<?php

namespace App\Http\Controllers\Pages\Users\Klien;

use App\Http\Controllers\Controller;
use App\Mail\Users\PembayaranLayananMail;
use App\Model\PembayaranLayanan;
use App\Model\PengerjaanLayanan;
use App\Model\UlasanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.bio')->except('dashboard');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $pesanan = PengerjaanLayanan::where('user_id', $user->id)->get();
        $req_id = $request->id;
        $req_invoice = $request->invoice;
        $req_url = $request->url;
        $req_data_url = $request->data_url;
        $req_harga = $request->harga;
        if ($request->has('pesanan_id')) {
            $find = PengerjaanLayanan::find($request->pesanan_id);
        } else {
            $find = null;
        }

        return view('pages.main.users.klien.layanan', compact('user', 'pesanan',
            'req_id', 'req_invoice', 'req_url', 'req_data_url', 'req_harga', 'find'));
    }

    public function batalkanPesanan($id)
    {
        $pesanan = PengerjaanLayanan::find($id);
        $pesanan->delete();

        return back()->with('delete', 'Pesanan layanan [' . $pesanan->get_service->judul . '] berhasil dibatalkan!');
    }

    public function updatePembayaran(Request $request)
    {
        $pesanan = PengerjaanLayanan::find($request->id);

        if ($request->hasFile('bukti_pembayaran')) {
            $name = $request->file('bukti_pembayaran')->getClientOriginalName();
            if ($pesanan->get_pembayaran->bukti_pembayaran != '') {
                Storage::delete('public/users/pembayaran/layanan/' . $pesanan->get_pembayaran->bukti_pembayaran);
            }
            $request->bukti_pembayaran->storeAs('public/users/pembayaran/layanan', $name);
            $pesanan->get_pembayaran->update(['bukti_pembayaran' => $name]);

            return $name;

        } else {
            if (is_null($pesanan->get_pembayaran)) {
                $sisa_pembayaran = 0;
                $pembayaran = PembayaranLayanan::create([
                    'pengerjaan_layanan_id' => $pesanan->id,
                    'dp' => $request->dp,
                    'jumlah_pembayaran' => str_replace('.', '', $request->jumlah_pembayaran),
                ]);
            } else {
                $pembayaran = PembayaranLayanan::where('pengerjaan_layanan_id', $pesanan->id)->first();
                $sisa_pembayaran = str_replace('.', '', $request->jumlah_pembayaran);
                $pembayaran->update([
                    'dp' => $request->dp,
                    'jumlah_pembayaran' => $pesanan->get_pembayaran->jumlah_pembayaran + $sisa_pembayaran,
                    'bukti_pembayaran' => null,
                ]);
            }

            Mail::to($pembayaran->get_pengerjaan_layanan->get_user->email)
                ->send(new PembayaranLayananMail($pembayaran, $sisa_pembayaran, $request->metode_pembayaran, $request->rekening));

            return back()->with('update', 'Silahkan cek email Anda dan selesaikan pembayaran Anda sebelum batas waktu yang ditentukan! Terimakasih :)');
        }
    }

    public function dataPembayaran(Request $request)
    {
        return PembayaranLayanan::find($request->id);
    }

    public function ulasPengerjaanLayanan(Request $request)
    {
        $pengerjaan = PengerjaanLayanan::find($request->id);
        $pengerjaan->update(['selesai' => $request->has('selesai') ? $request->selesai : false]);
        UlasanService::create([
            'user_id' => $pengerjaan->user_id,
            'pengerjaan_layanan_id' => $pengerjaan->id,
            'deskripsi' => $request->deskripsi,
            'bintang' => $request->rating,
        ]);

        if ($pengerjaan->selesai == true) {
            $message = 'Pesanan layanan [' . $pengerjaan->get_service->judul . '] Anda telah selesai!';
        } else {
            $message = 'Pesanan layanan [' . $pengerjaan->get_service->judul . '] Anda sedang direvisi!';
        }

        return back()->with('create', $message);
    }

    public function dataUlasanLayanan(Request $request)
    {
        return UlasanService::where('pengerjaan_layanan_id', $request->id)->first();
    }
}
