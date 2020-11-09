<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Negara;
use App\Model\Provinsi;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Whoops\Exception\ErrorException;

class LokasiController extends Controller
{
    /**
     * TODO Showing Pagee Negara With Data
     *
     */
    public function negara()
    {
        $data = Negara::all();
        $data_provinsi = Provinsi::all();
        return view('pages.admins.lokasi.negara', [
            'negara' => $data,
            'provinsi' => $data_provinsi
        ]);
    }

    /**
     * TODO Store Data Negara
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_negara(Request $request)
    {
        try {
            Negara::create([
                'nama' => $request->name
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
     * TODO Update data Negara
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_negara(Request $request)
    {
        try {
            $data = Negara::find($request->id);
            $data->update([
                'nama' => $request->name
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

    public function negaradelete(Request $request)
    {
        try {
            $data = Negara::find($request->id);
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

    /**
     * TODO Showing Provinsi With Data
     *
     */
    public function provinsi()
    {
        $data = Provinsi::all();
        return view('pages.admins.lokasi.provinsi', [
            'provinsi' => $data
        ]);
    }

    public function store_provinsi(Request $request)
    {
        try {
            Provinsi::create([
                'nama' => $request->name
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
     * TODO Store data Provinsi
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_provinsi(Request $request)
    {
        try {
            $data = Provinsi::find($request->id);
            $data->update([
                'nama' => $request->name
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Data Behasil Diperbarui"
            ],200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 401,
                'message' => $exception
            ],401);
        } catch (ErrorException $error) {
            return response()->json([
                'status' => 401,
                'message' => $error
            ],401);
        }
    }

    public function provinsidelete(Request $request)
    {
        try {
            $data = Provinsi::find($request->id);
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
