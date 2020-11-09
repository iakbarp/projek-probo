<?php

namespace App\Http\Controllers\Pages\Users\Pekerja;

use App\Http\Controllers\Controller;
use App\Model\Kategori;
use App\Model\PengerjaanLayanan;
use App\Model\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.bio')->except('dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $kategori = Kategori::orderBy('nama')->get();
        $layanan = Services::where('user_id', $user->id)->get();
        $pengerjaan = PengerjaanLayanan::whereIn('service_id', $layanan->pluck('id'))->get();

        return view('pages.main.users.pekerja.layanan', compact('user', 'kategori', 'layanan', 'pengerjaan'));
    }

    public function tambahLayanan(Request $request)
    {
        $cek = Services::where('user_id', Auth::id())->where('permalink', $request->judul)->first();
        if (!$cek) {
            if ($request->hasFile('thumbnail')) {
                $this->validate($request, ['thumbnail' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
                $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/layanan/thumbnail', $thumbnail);
            } else {
                $thumbnail = null;
            }

            Services::create([
                'user_id' => Auth::id(),
                'subkategori_id' => $request->subkategori_id,
                'judul' => $request->judul,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul)),
                'deskripsi' => $request->deskripsi,
                'hari_pengerjaan' => $request->hari_pengerjaan,
                'harga' => str_replace('.', '', $request->harga),
                'thumbnail' => $thumbnail,
            ]);
        } else {
            return back()->with('gagal', 'Layanan [' . $request->judul . '] Anda telah tersedia! Silahkan buat layanan Anda dengan judul yang berbeda, terimakasih.');
        }

        return back()->with('create', 'Layanan [' . $request->judul . '] Anda berhasil ditambahkan!');
    }

    public function suntingLayanan(Request $request)
    {
        return Services::find($request->id);
    }

    public function updateLayanan(Request $request)
    {
        $layanan = Services::find($request->id);

        $cek = Services::where('user_id', Auth::id())->where('id', '!=', $request->id)->where('permalink', $request->judul)->first();
        if (!$cek) {
            if ($request->hasFile('thumbnail')) {
                $this->validate($request, ['thumbnail' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
                $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                if ($layanan->thumbnail != "") {
                    Storage::delete('public/layanan/thumbnail/' . $layanan->thumbnail);
                }
                $request->file('thumbnail')->storeAs('public/layanan/thumbnail', $thumbnail);
            } else {
                $thumbnail = $layanan->thumbnail;
            }

            $layanan->update([
                'user_id' => Auth::id(),
                'subkategori_id' => $request->subkategori_id,
                'judul' => $request->judul,
                'permalink' => preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul)),
                'deskripsi' => $request->deskripsi,
                'hari_pengerjaan' => $request->hari_pengerjaan,
                'harga' => str_replace('.', '', $request->harga),
                'thumbnail' => $thumbnail,
            ]);
        } else {
            return back()->with('gagal', 'Layanan [' . $request->judul . '] Anda telah tersedia! Silahkan ubah layanan Anda dengan judul yang berbeda, terimakasih.');
        }

        return back()->with('update', 'Layanan [' . $layanan->judul . '] Anda berhasil diperbarui!');
    }

    public function hapusLayanan($id)
    {
        $layanan = Services::find($id);
        if ($layanan->thumbnail != "") {
            Storage::delete('public/layanan/thumbnail/' . $layanan->thumbnail);
        }
        $layanan->delete();

        return back()->with('delete', 'Layanan [' . $layanan->judul . '] Anda berhasil dihapus!');
    }

    public function updatePengerjaanLayanan(Request $request)
    {
        $pengerjaan = PengerjaanLayanan::find($request->id);

        if ($request->hasFile('file_hasil')) {
            $this->validate($request, [
                'file_hasil' => 'required|array',
                'file_hasil.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
            ]);

            $file_hasil = [];
            $i = 0;
            foreach ($request->file('file_hasil') as $file) {
                $file->storeAs('public/layanan/hasil', $file->getClientOriginalName());
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

        return back()->with('pengerjaan', 'Hasil pengerjaan layanan [' . $pengerjaan->get_service->judul . '] berhasil diperbarui!');
    }
}
