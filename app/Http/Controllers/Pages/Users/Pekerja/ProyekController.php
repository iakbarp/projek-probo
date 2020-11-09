<?php

namespace App\Http\Controllers\Pages\Users\Pekerja;

use App\Http\Controllers\Controller;
use App\Model\Bid;
use App\Model\Pengerjaan;
use App\Model\Review;
use App\Model\Undangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.bio')->except('dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $bid = Bid::where('user_id', $user->id)->get();
        $undangan = Undangan::where('user_id', $user->id)->get();
        $pengerjaan = Pengerjaan::where('user_id', $user->id)->get();

        return view('pages.main.users.pekerja.proyek', compact('user', 'bid', 'undangan', 'pengerjaan'));
    }

    public function batalkanBid($id)
    {
        $bid = Bid::find($id);
        $bid->delete();

        return back()->with('bid', 'Bid tugas/proyek [' . $bid->get_project->judul . '] berhasil dibatalkan!');
    }

    public function terimaUndangan($id)
    {
        $undangan = Undangan::find($id);
        $undangan->update(['terima' => true]);

        if ($undangan->get_project->pribadi == true) {
            Pengerjaan::create([
                'user_id' => $undangan->user_id,
                'proyek_id' => $undangan->proyek_id,
            ]);
            $jenis = 'privat';

        } else {
            Bid::create([
                'user_id' => $undangan->user_id,
                'proyek_id' => $undangan->proyek_id,
            ]);
            $jenis = 'publik';
        }

        return back()->with('undangan', 'Undangan tugas/proyek ' . $jenis . ' [' . $undangan->get_project->judul . '] berhasil diterima!');
    }

    public function tolakUndangan($id)
    {
        $undangan = Undangan::find($id);
        $undangan->update(['terima' => false]);
        $jenis = $undangan->get_project->pribadi == true ? 'privat' : 'publik';

        return back()->with('undangan', 'Undangan tugas/proyek ' . $jenis . ' [' . $undangan->get_project->judul . '] berhasil ditolak!');
    }

    public function lampiranProyek(Request $request)
    {
        $pengerjaan = Pengerjaan::find($request->id);
        $data = $pengerjaan->get_project->lampiran;

        if (!is_null($data)) {
            $i = 0;
            foreach ($data as $lampiran) {
                $arr = [
                    'file' => $lampiran,
                    'ext' => strtolower(pathinfo($lampiran, PATHINFO_EXTENSION)),
                ];

                $data[$i] = $arr;
                $i = $i + 1;
            }
        }

        return $data;
    }

    public function updatePengerjaanProyek(Request $request)
    {
        $pengerjaan = Pengerjaan::find($request->id);

        if ($request->hasFile('file_hasil')) {
            $this->validate($request, [
                'file_hasil' => 'required|array',
                'file_hasil.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
            ]);

            $file_hasil = [];
            $i = 0;
            foreach ($request->file('file_hasil') as $file) {
                $file->storeAs('public/proyek/hasil', $file->getClientOriginalName());
                $file_hasil[$i] = $file->getClientOriginalName();
                $i = 1 + $i;
            }
        } else {
            $file_hasil = null;
        }

        $pengerjaan->update([
            'file_hasil' => $file_hasil,
            'tautan' => $request->tautan,
        ]);

        return back()->with('pengerjaan', 'Hasil pengerjaan tugas/proyek [' . $pengerjaan->get_project->judul . '] berhasil diperbarui!');
    }

    public function ulasPengerjaanProyek(Request $request)
    {
        $pengerjaan = Pengerjaan::find($request->id);
        Review::create([
            'user_id' => $pengerjaan->user_id,
            'proyek_id' => $pengerjaan->proyek_id,
            'deskripsi' => $request->deskripsi,
            'bintang' => $request->rating,
        ]);

        return back()->with('pengerjaan', 'Tugas/proyek [' . $pengerjaan->get_project->judul . '] telah selesai dan berhasil diulas!');
    }

    public function dataUlasanProyek(Request $request)
    {
        return Review::where('proyek_id', $request->id)->first();
    }
}
