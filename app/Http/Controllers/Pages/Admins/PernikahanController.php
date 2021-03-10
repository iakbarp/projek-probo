<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Pernikahan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Whoops\Exception\ErrorException;

class PernikahanController extends Controller
{
    public function pernikahan()
    {
        $data = Pernikahan::all();

        return view('pages.admins.master.pernikahan', [
            'pernikahan' => $data,
        ]);
    }

    /**
     * TODO Store Data Kategori
     *
     * @param Request $request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * /**
     * TODO Update data Kategori
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_pernikahan(Request $request)
    {
        $data = Pernikahan::find($request->id);

        try {
            $data->update([
                'pt' => $request->pt,
                'dept' => $request->dept,
                'tanggal_menikah' => $request->tanggal_menikah,
                'bank_id' => $request->bank_id,
                'rekening' => $request->rekening,
                'kota_id' => $request->kota_id,
                'nama_istri' => $request->nama_istri,

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

    public function delete_pernikahan(Request $request)
    {
        try {
            $data = Pernikahan::find($request->id);
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
