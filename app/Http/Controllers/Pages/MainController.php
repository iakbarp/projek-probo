<?php

namespace App\Http\Controllers\Pages;

use App\Model\Bid;
use App\Model\Bio;
use App\Model\PengerjaanLayanan;
use App\Model\Project;
use App\Model\Review;
use App\Model\ReviewWorker;
use App\Model\Services;
use App\Model\Testimoni;
use App\Model\UlasanService;
use App\Support\Role;
use App\User;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {
        $proyek = Project::where('pribadi', false)->doesntHave('get_pengerjaan')->orderByDesc('id')->take(8)->get();
        $layanan = Services::orderByDesc('id')->take(8)->get();
        $pekerja = Bio::whereHas('get_user', function ($q) {
            $q->where('role', Role::OTHER);
        })->where('total_bintang_pekerja', '>', 0)->orderByDesc('total_bintang_pekerja')->take(8)->get();

        $testimoni = Testimoni::where('bintang', '>', 3)->orderByDesc('id')->take(12)->get();
        if (Auth::check()) {
            $cek = Testimoni::where('user_id', Auth::id())->first();
        } else {
            $cek = null;
        }

        return view('pages.main.beranda', compact('proyek', 'layanan', 'pekerja', 'testimoni', 'cek'));
    }

    public function detailProyek(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $total_user = User::where('role', Role::OTHER)->count();
        $ulasan_klien = Review::whereHas('get_project', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
        $rating_klien = count($ulasan_klien) > 0 ? $user->get_bio->total_bintang_klien / count($ulasan_klien) : 0;

        $proyek = Project::where('user_id', $user->id)->where('permalink', $request->judul)->first();
        $cek = Bid::where('user_id', Auth::id())->where('proyek_id', $proyek->id)->count();

        return view('pages.main.detail-proyek', compact('user', 'total_user',
            'ulasan_klien', 'rating_klien', 'proyek', 'cek'));
    }

    public function bidProyek(Request $request)
    {
        try {

        $proyek = Project::where('permalink', $request->judul)->whereHas('get_user', function ($q) use ($request) {
            $q->where('username', $request->username);
        })->first();

        Bid::create([
            'user_id' => Auth::id(),
            'proyek_id' => $proyek->id,
            'negoharga' => str_replace('.', '',$request->negoharga),
            'negowaktu' => $request->negowaktu,
            'task' => $request->task,

        ]);

        return back()->with('bid', 'Bid tugas/proyek [' . $proyek->judul . '] berhasil diajukan!');
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function detailLayanan(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        $total_user = User::where('role', Role::OTHER)->count();
        $ulasan_pekerja = ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
        $ulasan_layanan = UlasanService::whereHas('get_pengerjaan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        $rating_pekerja = count($ulasan_pekerja) + $ulasan_layanan > 0 ?
            $user->get_bio->total_bintang_pekerja / (count($ulasan_pekerja) + $ulasan_layanan) : 0;

        $layanan = Services::where('user_id', $user->id)->where('permalink', $request->judul)->first();
        $hasil = PengerjaanLayanan::where('service_id', $layanan->id)->wherenotnull('file_hasil')->first();
        $ulasan = UlasanService::whereHas('get_pengerjaan', function ($q) use ($layanan) {
            $q->where('service_id', $layanan->id);
        })->get();

        $cek = PengerjaanLayanan::where('user_id', Auth::id())->where('service_id', $layanan->id)->where('selesai', false)->count();

        return view('pages.main.detail-layanan', compact('user', 'total_user',
            'ulasan_pekerja', 'ulasan_layanan', 'rating_pekerja', 'layanan', 'hasil', 'ulasan', 'cek'));
    }

    public function pesanLayanan(Request $request)
    {
        $layanan = Services::where('permalink', $request->judul)->whereHas('get_user', function ($q) use ($request) {
            $q->where('username', $request->username);
        })->first();

        $pengerjaan = PengerjaanLayanan::create([
            'user_id' => Auth::id(),
            'service_id' => $layanan->id,
            'selesai' => false
        ]);

        return back()->with('pesanan', [
            'message' => 'Pesanan layanan [' . $layanan->judul . '] berhasil dibuat!',
            'data' => $pengerjaan->id
        ]);
    }

    public function tentang()
    {
        $testimoni = Testimoni::where('bintang', '>', 3)->orderByDesc('id')->take(12)->get();
        if (Auth::check()) {
            $cek = Testimoni::where('user_id', Auth::id())->first();
        } else {
            $cek = null;
        }

        return view('pages.info.tentang', compact('testimoni', 'cek'));
    }

    public function caraKerja()
    {
        return view('pages.info.cara-kerja');
    }

    public function ketentuanLayanan()
    {
        return view('pages.info.ketentuan-layanan');
    }

    public function kebijakanPrivasi()
    {
        return view('pages.info.kebijakan-privasi');
    }

    public function kirimTestimoni(Request $request)
    {
        if ($request->check_form == 'create') {
            Testimoni::create([
                'user_id' => Auth::id(),
                'bintang' => $request->rating,
                'deskripsi' => $request->comment,
            ]);

            return back()->with('testimoni', 'Terima kasih ' . Auth::user()->name . ' atas ulasannya! ' .
                'Dengan begitu kami dapat berpotensi menjadi agensi yang lebih baik lagi.');

        } else {
            Testimoni::find($request->check_form)->update([
                'rate' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('testimoni', 'Ulasan Anda berhasil diperbarui!');
        }
    }

    public function hapusTestimoni($id)
    {
        Testimoni::destroy(decrypt($id));

        return back()->with('testimoni', 'Ulasan Anda berhasil dihapus!');
    }

    public function kontak()
    {
        return view('pages.info.kontak');
    }

    public function kirimKontak(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'string|min:3',
            'message' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'bodymessage' => $request->message
        );
        Mail::send('emails.kontak', $data, function ($message) use ($data) {
            $message->from($data['email']);
            $message->to(env('MAIL_USERNAME'));
            $message->subject($data['subject']);
        });

        return back()->with('kontak', 'Terima kasih telah meninggalkan kami pesan! Karena setiap komentar atau kritik yang Anda berikan, akan membuat kami menjadi perusahaan yang lebih baik.');
    }

    public function suratKontrak(Request $request)
    {
        return view('pages.main.users.surat-kontrak');
    }
}
