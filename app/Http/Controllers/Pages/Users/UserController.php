<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\Mail\Users\PembayaranProyekMail;
use App\Mail\Users\ProyekMail;
use App\Model\Bahasa;
use App\Model\Kategori;
use App\Model\Portofolio;
use App\Model\Project;
use App\Model\Review;
use App\Model\ReviewWorker;
use App\Model\Services;
use App\Model\Skill;
use App\Model\UlasanService;
use App\Model\Undangan;
use App\Support\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function profilUser($username)
    {
        $user = User::where('username', $username)->first();
        $total_user = User::where('role', Role::OTHER)->count();

        $bahasa = Bahasa::where('user_id', $user->id)->orderByDesc('id')->get();
        $skill = Skill::where('user_id', $user->id)->orderByDesc('id')->get();
        $proyek = Project::where('user_id', $user->id)
//            ->whereHas('get_bid',function ($query){
//                $query->whereNull('tolak');
//            })
            ->where('pribadi', false)->orderByDesc('id')->get();
        $layanan = Services::where('user_id', $user->id)->orderByDesc('id')->get();
        $portofolio = Portofolio::where('user_id', $user->id)->orderByDesc('tahun')->get();

        $ulasan_klien = Review::whereHas('get_project', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
        $rating_klien = count($ulasan_klien) > 0 ? $user->get_bio->total_bintang_klien / count($ulasan_klien) : 0;

        $ulasan_pekerja = ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

//        dd($proyek);

        $ulasan_layanan = UlasanService::whereHas('get_pengerjaan', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        $rating_pekerja = count($ulasan_pekerja) + $ulasan_layanan > 0 ?
            $user->get_bio->total_bintang_pekerja / (count($ulasan_pekerja) + $ulasan_layanan) : 0;

        $kategori = Kategori::orderBy('nama')->get();
        $auth_proyek = Project::where('user_id', Auth::id())->doesntHave('get_pengerjaan')->get();

        return view('pages.main.users.profil-publik', compact('user', 'total_user', 'bahasa', 'skill',
            'proyek', 'layanan', 'portofolio', 'ulasan_klien', 'rating_klien', 'ulasan_pekerja', 'rating_pekerja',
            'kategori', 'auth_proyek'));
    }

    public function userHireMe(Request $request)
    {
        if ($request->hasFile('thumbnail')) {
            $this->validate($request, ['thumbnail' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
            $thumbnail = $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->storeAs('public/proyek/thumbnail', $thumbnail);
        } else {
            $thumbnail = null;
        }

        if ($request->hasFile('lampiran')) {
            $this->validate($request, [
                'lampiran' => 'required|array',
                'lampiran.*' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120'
            ]);

            $lampiran = [];
            $i = 0;
            foreach ($request->file('lampiran') as $file) {
                $file->storeAs('public/proyek/lampiran', $file->getClientOriginalName());
                $lampiran[$i] = $file->getClientOriginalName();
                $i = 1 + $i;
            }
        } else {
            $lampiran = null;
        }

        $proyek = Project::create([
            'user_id' => Auth::id(),
            'subkategori_id' => $request->subkategori_id,
            'judul' => $request->judul,
            'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul)),
            'deskripsi' => $request->deskripsi,
            'waktu_pengerjaan' => $request->waktu_pengerjaan,
            'harga' => str_replace('.', '', $request->harga),
            'thumbnail' => $thumbnail,
            'lampiran' => $lampiran,
            'pribadi' => true,
        ]);

        $undangan = Undangan::create([
            'user_id' => $request->user_id,
            'proyek_id' => $proyek->id,
        ]);

        return back()->with('hire_me', 'Permintaan Anda berhasil dikirimkan! Silahkan tunggu tanggapan dari ' .
            $undangan->get_user->name . ', terimakasih.');
    }

    public function userInviteToBid(Request $request)
    {
        $user = User::find($request->user_id);
        $proyek = Project::find($request->proyek_id);
        $undangan = Undangan::create([
            'user_id' => $request->user_id,
            'proyek_id' => $request->proyek_id,
        ]);
        Mail::to($user->email)
            ->send(new ProyekMail($user->name, $proyek->judul, $proyek->deskripsi, $proyek->waktu_pengerjaan, $proyek->harga));

        return back()->with('invite_to_bid', 'Undangan lelang berhasil dikirim');
    }
}
