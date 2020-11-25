<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
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

        return view('pages.main.users.dompet', compact('user', 'total_user', 'bahasa', 'skill',
            'proyek', 'layanan', 'portofolio', 'ulasan_klien', 'rating_klien', 'ulasan_pekerja', 'rating_pekerja',
            'kategori', 'auth_proyek'));
    }
}
