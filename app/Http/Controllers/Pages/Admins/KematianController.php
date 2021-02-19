<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Kategori;
use App\Model\Kematian;
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

        return view('pages.admins.master.project',[
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
        if ($request->hasFile('lampiran')) {
            $this->validate($request, ['lampiran' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
            $lampiran = $request->file('lampiran')->getClientOriginalName();
//                $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", Auth::id()).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
            $request->file('lampiran')->storeAs('public/proyek/thumbnail', $lampiran);
        } else {
//            $lampiran = null;
        }
        try {
            Kematian::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'lampiran' => $lampiran
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
        try {
            $data = Kematian::find($request->id);
            $data->update([
                'nama' => $request->nama
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
