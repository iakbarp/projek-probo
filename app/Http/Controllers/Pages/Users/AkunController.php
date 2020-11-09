<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\Model\Bahasa;
use App\Model\Negara;
use App\Model\Portofolio;
use App\Model\Provinsi;
use App\Model\Skill;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AkunController extends Controller
{
    public function profil()
    {
        $user = Auth::user();
        $negara = Negara::all();
        $provinsi = Provinsi::all();
        $bahasa = Bahasa::where('user_id', Auth::id())->orderByDesc('id')->get();
        $skill = Skill::where('user_id', Auth::id())->orderByDesc('id')->get();
        $portofolio = Portofolio::where('user_id', Auth::id())->orderByDesc('tahun')->get();

        return view('pages.main.users.sunting-profil', compact('user', 'negara', 'provinsi',
            'bahasa', 'skill', 'portofolio'));
    }

    public function updateProfil(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($request->hasFile('latar_belakang')) {
            $this->validate($request, [
                'latar_belakang' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            ]);

            $name = $request->file('latar_belakang')->getClientOriginalName();

            if ($user->get_bio->latar_belakang != '') {
                Storage::delete('public/users/latar_belakang/' . $user->get_bio->latar_belakang);
            }

            if ($request->file('latar_belakang')->isValid()) {
                $request->latar_belakang->storeAs('public/users/latar_belakang', $name);
                $user->get_bio->update(['latar_belakang' => $name]);
                return $name;
            }

        } else {
            if ($request->check_form == 'kontak') {
                $user->get_bio->update([
                    'hp' => $request->hp,
                    'alamat' => $request->alamat,
                    'kode_pos' => $request->kode_pos,
                    'kota_id' => $request->kota_id,
                ]);

            } elseif ($request->check_form == 'personal') {
                $user->update(['name' => $request->name]);
                $user->get_bio->update([
                    'status' => $request->status,
                    'tgl_lahir' => $request->tgl_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'kewarganegaraan' => $request->kewarganegaraan,
                    'website' => $request->website,
                    'hp' => $request->hp,
                    'alamat' => $request->alamat,
                    'kode_pos' => $request->kode_pos,
                    'kota_id' => $request->kota_id,
                ]);

            } elseif ($request->check_form == 'summary') {
                $user->get_bio->update(['summary' => $request->summary]);

            } elseif ($request->check_form == 'status') {
                $user->get_bio->update(['status' => $request->status]);
                return $user->get_bio->status;
            }
        }

        return back()->with('update', 'Data ' . $request->check_form . ' Anda berhasil diperbarui!');
    }

    public function tambahPortofolio(Request $request)
    {
        $this->validate($request, ['foto' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
        $foto = $request->file('foto')->getClientOriginalName();
        $request->file('foto')->storeAs('public/users/portofolio', $foto);

        Portofolio::create([
            'user_id' => Auth::id(),
            'foto' => $foto,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'tautan' => $request->tautan,
        ]);

        return back()->with('create', 'Portofolio [' . $request->judul . ' - ' . $request->tahun . '] Anda berhasil ditambahkan!');
    }

    public function updatePortofolio(Request $request)
    {
        $portofolio = Portofolio::find($request->id);

        if ($request->hasFile('foto')) {
            $this->validate($request, ['foto' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
            $foto = $request->file('foto')->getClientOriginalName();
            Storage::delete('public/users/portofolio/' . $portofolio->foto);
            $request->file('foto')->storeAs('public/users/portofolio', $foto);
        } else {
            $foto = $portofolio->foto;
        }

        $portofolio->update([
            'foto' => $foto,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'tautan' => $request->tautan,
        ]);

        return back()->with('update', 'Portofolio [' . $portofolio->judul . ' - ' . $portofolio->tahun . '] Anda berhasil diperbarui!');
    }

    public function hapusPortofolio($id)
    {
        $portofolio = Portofolio::find(decrypt($id));
        Storage::delete('public/users/portofolio/' . $portofolio->foto);
        $portofolio->delete();

        return back()->with('delete', 'Portofolio [' . $portofolio->judul . ' - ' . $portofolio->tahun . '] Anda berhasil dihapus!');
    }

    public function tambahBahasa(Request $request)
    {
        Bahasa::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'tingkatan' => $request->tingkatan,
        ]);

        return back()->with('create', 'Kemampuan berbahasa [' . $request->nama . '] berhasil ditambahkan!');
    }

    public function updateBahasa(Request $request)
    {
        $bahasa = Bahasa::find($request->id);
        $bahasa->update([
            'nama' => $request->nama,
            'tingkatan' => $request->tingkatan,
        ]);

        return back()->with('update', 'Kemampuan berbahasa [' . $bahasa->nama . '] Anda berhasil diperbarui!');
    }

    public function hapusBahasa($id)
    {
        $bahasa = Bahasa::find(decrypt($id));
        $bahasa->delete();

        return back()->with('delete', 'Kemampuan berbahasa [' . $bahasa->nama . '] Anda berhasil dihapus!');
    }

    public function tambahSkill(Request $request)
    {
        Skill::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'tingkatan' => $request->tingkatan,
        ]);

        return back()->with('create', 'Skill [' . $request->nama . '] berhasil ditambahkan!');
    }

    public function updateSkill(Request $request)
    {
        $skill = Skill::find($request->id);
        $skill->update([
            'nama' => $request->nama,
            'tingkatan' => $request->tingkatan,
        ]);

        return back()->with('update', 'Skill [' . $skill->nama . '] Anda berhasil diperbarui!');
    }

    public function hapusSkill($id)
    {
        $skill = Skill::find(decrypt($id));
        $skill->delete();

        return back()->with('delete', 'Skill [' . $skill->nama . '] Anda berhasil dihapus!');
    }

    public function pengaturan()
    {
        $user = Auth::user();

        return view('pages.main.users.pengaturan-akun', compact('user'));
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
                    if ($request->new_password != $request->password_confirmation) {
                        return 1;
                    } else {
                        $user->update(['password' => bcrypt($request->new_password)]);
                        return 2;
                    }
                }
            }
        }
    }
}
