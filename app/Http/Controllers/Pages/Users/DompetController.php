<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\Model\Bahasa;
use App\Model\Dompet;
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
use Highlight\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DompetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $total_user = User::where('role', Role::OTHER)->count();

        $bahasa = Bahasa::where('user_id', $user->id)->orderByDesc('id')->get();
        $skill = Skill::where('user_id', $user->id)->orderByDesc('id')->get();
        $proyek = Project::where('user_id', $user->id)->orderByDesc('id')->get();
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
        $auth_proyek = Project::where('user_id', Auth::id())->where('pribadi', false)->doesntHave('get_pengerjaan')->get();

        $dompet = Dompet::where('user_id', $user->id)->orderByDesc('id')->get();

        return view('pages.main.users.dompet', compact('user', 'total_user', 'bahasa', 'skill',
            'proyek', 'layanan', 'portofolio', 'ulasan_klien', 'rating_klien', 'ulasan_pekerja', 'rating_pekerja',
            'kategori', 'auth_proyek','dompet'));
    }

    public function updatePengaturan(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($request->hasFile('foto')) {
            $this->validate($request, ['foto' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);

            $name = $request->file('foto')->getClientOriginalName();

            if ($user->get_bio->foto != '') {
                Storage::delete('public/users/foto/' . $user->get_bio->foto);
            }

            if ($request->file('foto')->isValid()) {
                $request->foto->storeAs('public/users/foto', $name);
                $user->get_bio->update(['foto' => $name]);
                return asset('storage/users/foto/' . $name);
            }

        } else {
            if ($request->has('username')) {
                $check = User::where('username', $request->username)->first();

                if (!$check || $request->username == Auth::user()->username) {
                    $user->update(['username' => $request->username]);
                    return $user->username;
                } else {
                    return 0;
                }

            } else {
                if (!Hash::check($request->password, $user->password)) {
                    return 0;
                } else {
                    if ($request->new_pin != $request->pin_confirmation) {
                        return 1;
                    } else {
                        $user->update(['pin' => bcrypt($request->new_pin)]);
                        return 2;
                    }
                }
            }
        }
    }

//    public function dompetUser()
//    {
//        $user = Auth::user();
//        $dompet = Dompet::where('user_id', $user->id)->orderByDesc('id')->get();
//
//        return view('pages.main.users.dompet', compact('user', 'dompet'));
//    }
}
