<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Kategori;
use App\Model\Kematian;
use App\Model\StatusKematian;
use App\Model\SubKategori;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Whoops\Exception\ErrorException;

class KematianController extends Controller
{
    public function kematian()
    {
        $data = Kematian::all();

        return view('pages.admins.master.kematian',[
            'kematian' => $data,
        ]);
    }

    /**
     * TODO Store Data Kategori
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_kematian(Request $request)
    {
        if ($request->hasFile('surat_kematian')) {
            $this->validate($request, ['surat_kematian' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
            $surat_kematian = $request->file('surat_kematian')->getClientOriginalName();
//                $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", Auth::id()).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
            $request->file('surat_kematian')->storeAs('public/kematian/surat', $surat_kematian);
        } else {
            $surat_kematian = null;
        }
//        if ($request->hasFile('akte_kematian')) {
//            $this->validate($request, ['akte_kematian' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
//            $akte_kematian = $request->file('akte_kematian')->getClientOriginalName();
////                $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", Auth::id()).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
//            $request->file('akte_kematian')->storeAs('public/kematian/akte', $akte_kematian);
//        } else {
//            $akte_kematian = null;
//        }
        try {
            Kematian::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'meninggal' => $request->meninggal,
                'status_meninggal' => $request->status_meninggal,
                'dept' => $request->dept,
                'group' => $request->group,
                'surat_kematian' => $surat_kematian,
                'uang_duka' => $request->uang_duka,
//                'akte_kematian' => $akte_kematian,
            ]);
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

    /**
     * TODO Update data Kategori
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_kematian(Request $request)
    {
        $data = Kematian::find($request->id);
        if ($request->hasFile('surat_kematian')) {
            $this->validate($request, ['surat_kematian' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
            $surat_kematian = $request->file('surat_kematian')->getClientOriginalName();
//                $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", Auth::id()).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
            $request->file('surat_kematian')->storeAs('public/kematian/surat', $surat_kematian);
        } else {
            $surat_kematian = $data->surat_kematian;
        }
        try {
//            $data = Kematian::find($request->id);

            StatusKematian::create([
                'jenis_perubahan' => $request->jenis_perubahan,
                'kematian_id' => $data->id,
                'old_name' => $data->name,
                'old_nik' => $data->nik,
                'old_meninggal' => $data->meninggal,
                'old_status_meninggal' => $data->status_meninggal,
                'old_dept' => $data->dept,
                'old_group' => $data->group,
                'old_surat_kematian' => $data->surat_kematian,
                'old_uang_duka' => $data->uang_duka,
                'new_name' => $request->name,
                'new_nik' => $request->nik,
                'new_meninggal' => $request->meninggal,
                'new_status_meninggal' => $request->status_meninggal,
                'new_dept' => $request->dept,
                'new_group' => $request->group,
                'new_surat_kematian' => $surat_kematian,
                'new_uang_duka' => $request->uang_duka,
            ]);

            $data->update([
                'name' => $request->name,
                'nik' => $request->nik,
                'meninggal' => $request->meninggal,
                'status_meninggal' => $request->status_meninggal,
                'dept' => $request->dept,
                'group' => $request->group,
                'surat_kematian' => $surat_kematian,
                'uang_duka' => $request->uang_duka,

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

    public function delete_kematian(Request $request)
    {
        try {
            $data = Kematian::find($request->id);
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
