<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Dokumen;
use App\Model\Kategori;
use App\Model\Kelahiran;
use App\Model\Kematian;
use App\Model\Pernikahan;
use App\Model\StatusKematian;
use App\Model\StatusPerubahan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Whoops\Exception\ErrorException;

class DokumenController extends Controller
{
    public function index()
    {
        $data = Dokumen::all();
        $kategori = Kategori::orderBy('nama')->get();
        return view('pages.admins.master.status_dokumen',[
            'index' => $data,
            'kategori' => $kategori,
        ]);
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
}
