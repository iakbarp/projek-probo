<?php

namespace App\Http\Controllers\Pages\Users;

use App\Http\Controllers\Controller;
use App\Model\Bahasa;
use App\Model\Dokumen;
use App\Model\Kategori;
use App\Model\Kelahiran;
use App\Model\Kematian;
use App\Model\Negara;
use App\Model\Pengerjaan;
use App\Model\Pernikahan;
use App\Model\Portofolio;
use App\Model\Project;
use App\Model\Provinsi;
use App\Model\Skill;
use App\Model\Bank;
use App\Model\StatusPerubahan;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Whoops\Exception\ErrorException;

class AkunController extends Controller
{
    public function profil(Request $request)
    {
        $user = Auth::user();
        $negara = Negara::all();
        $bank = Bank::all();
        $provinsi = Provinsi::all();
        $kategori = Kategori::orderBy('nama')->get();
        $dokumen = Dokumen::where('user_id', $user->id)->orderBy('name')->get();
        $req_id = $request->id;
        $req_invoice = $request->invoice;
        $req_url = $request->url;
        $req_data_url = $request->data_url;
        $req_harga = $request->harga;
        $req_judul = $request->judul;

        return view('pages.main.users.sunting-profil', compact('user', 'negara', 'provinsi',
            'bank', 'kategori', 'dokumen'));
    }

    public function store_dokumen(Request $request)
    {
        if ($request->hasFile('berkas')) {
            $this->validate($request, ['berkas' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
            $berkas = $request->file('berkas')->getClientOriginalName();
//                $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", Auth::id()).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
            $request->file('berkas')->storeAs('public/dokumen/', $berkas);
        } else {
            $berkas = null;
        }
//        if ($request->hasFile('akte')) {
//            $this->validate($request, ['akte' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
//            $akte = $request->file('akte')->getClientOriginalName();
//            $request->file('akte')->storeAs('public/dokumen/akte', $akte);
//        } else {
//            $akte = null;
//        }
//        if ($request->hasFile('kk')) {
//            $this->validate($request, ['kk' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
//            $kk = $request->file('kk')->getClientOriginalName();
//            $request->file('kk')->storeAs('public/dokumen/kk', $kk);
//        } else {
//            $kk = null;
//        }
//        if ($request->hasFile('surat_kematian')) {
//            $this->validate($request, ['surat_kematian' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
//            $surat_kematian = $request->file('surat_kematian')->getClientOriginalName();
//            $request->file('surat_kematian')->storeAs('public/dokumen/meninggal', $surat_kematian);
//        } else {
//            $surat_kematian = null;
//        }
        try {
            $data = Dokumen::create([
                'nik' => $request->nik,
                'user_id' => Auth::id(),
                'name' => $request->name,
                'kategori_id' => $request->kategori_id,
                'r2' => $request->r2,
                'nominal' => $request->nominal,
                'terbilang' => $request->terbilang,
                'keterangan' => $request->keterangan,
                'berkas' => $berkas,
//                'akte' => $akte,
//                'kk' => $kk,
//                'surat_kematian' => $surat_kematian,
            ]);
            if ($request->kategori_id == '1') {
//                $data = Dokumen::find($request->id);
                Pernikahan::create([
                    'dokumen_id' => $data->id,
                ]);
            } elseif ($request->kategori_id == '2') {
                Kelahiran::create([
                    'dokumen_id' => $data->id,
                ]);
            } elseif ($request->kategori_id == '3') {
                Kematian::create([
                    'dokumen_id' => $data->id,
                ]);
            } elseif ($request->kategori_id == '4') {
                StatusPerubahan::create([
                    'dokumen_id' => $data->id,
                ]);
            }
            return response()->json([
                'status' => 201,
                'message' => "Data Behasil Tambahkan"
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 401,
                'message' => $exception
            ]);
        } catch (ErrorException $error) {
            return response()->json([
                'status' => 401,
                'message' => $error
            ]);
        }
    }

    public function update_dokumen(Request $request)
    {
        $data = Dokumen::find($request->id);
        if ($request->hasFile('berkas')) {
            $this->validate($request, ['berkas' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
            $berkas = $request->file('berkas')->getClientOriginalName();
//                $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", Auth::id()).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
            $request->file('berkas')->storeAs('public/dokumen/', $berkas);
        } else {
            $berkas = $data->berkas;
        }
        if ($request->kategori_id == Null){
            $kategori = $data->kategori_id;
        } else {
            $kategori = $request->kategori_id;
        }
        if ($request->selesai == Null){
            $selesai = $data->selesai;
        } else {
            $selesai = $request->selesai;
        }
        try {
//            $data = Kematian::find($request->id);

//            StatusKematian::create([
//                'jenis_perubahan' => $request->jenis_perubahan,
//                'kematian_id' => $data->id,
//                'old_name' => $data->name,
//                'old_nik' => $data->nik,
//                'old_meninggal' => $data->meninggal,
//                'old_status_meninggal' => $data->status_meninggal,
//                'old_dept' => $data->dept,
//                'old_group' => $data->group,
//                'old_surat_kematian' => $data->surat_kematian,
//                'old_uang_duka' => $data->uang_duka,
//                'new_name' => $request->name,
//                'new_nik' => $request->nik,
//                'new_meninggal' => $request->meninggal,
//                'new_status_meninggal' => $request->status_meninggal,
//                'new_dept' => $request->dept,
//                'new_group' => $request->group,
//                'new_surat_kematian' => $surat_kematian,
//                'new_uang_duka' => $request->uang_duka,
//            ]);

            $data->update([
                'user_id' => Auth::id(),
                'nik' => $request->nik,
                'name' => $request->name,
                'kategori_id' => $kategori,
                'r2' => $request->r2,
                'nominal' => $request->nominal,
                'terbilang' => $request->terbilang,
                'keterangan' => $request->keterangan,
                'berkas' => $berkas,
                'selesai' => $selesai
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Data Behasil Diperbarui"
            ]);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 401,
                'message' => $exception
            ]);
        } catch (ErrorException $error) {
            return response()->json([
                'status' => 401,
                'message' => $error
            ]);
        }
    }

    public function delete_dokumen(Request $request)
    {
        try {
            $data = Dokumen::find($request->id);
            $data->delete();

            return response()->json([
                'status' => 200,
                'message' => "Data berhasil dihapus"
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 401,
                'message' => $exception
            ]);
        } catch (ErrorException $error) {
            return response()->json([
                'status' => 401,
                'message' => $error
            ]);
        }
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
                    'bank' => $request->bank,
                    'an' => $request->an,
                    'rekening' => $request->rekening,
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
