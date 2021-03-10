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
//        if ($request->hasFile('surat_kematian')) {
//            $this->validate($request, ['surat_kematian' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
//            $surat_kematian = $request->file('surat_kematian')->getClientOriginalName();
//            $request->file('surat_kematian')->storeAs('public/kematian/surat', $surat_kematian);
//        } else {
//            $surat_kematian = null;
//        }
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
                'pt' => $request->pt,
                'dept' => $request->dept,
                'meninggal' => $request->meninggal,
                'tanggal_meninggal' => $request->tanggal_meninggal,
                'bank' => $request->bank,
                'rekening' => $request->rekening,
                'status_meninggal' => $request->status_meninggal,
                'kota_id' => $request->kota_id,
                'alm' => $request->alm,
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

        try {
            $data->update([
                'pt' => $request->pt,
                'dept' => $request->dept,
                'meninggal' => $request->meninggal,
                'tanggal_meninggal' => $request->tanggal_meninggal,
                'bank_id' => $request->bank_id,
                'rekening' => $request->rekening,
                'status_meninggal' => $request->status_meninggal,
                'kota_id' => $request->kota_id,
                'alm' => $request->alm,

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
