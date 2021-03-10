<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Pernikahan;
use App\Model\StatusPerubahan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Whoops\Exception\ErrorException;

class PerubahanController extends Controller
{
    public function perubahan()
    {
        $data = StatusPerubahan::all();

        return view('pages.admins.master.status_perubahan', [
            'perubahan' => $data,
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
    public function update_perubahan(Request $request)
    {
        $data = StatusPerubahan::find($request->id);

        try {
            $data->update([
                'perubahan' => $request->perubahan,
                'sebelum' => $request->sebelum,
                'sesudah' => $request->sesudah,

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

    public function delete_perubahan(Request $request)
    {
        try {
            $data = StatusPerubahan::find($request->id);
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
