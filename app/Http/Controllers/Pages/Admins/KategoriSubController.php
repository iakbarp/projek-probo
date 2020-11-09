<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Kategori;
use App\Model\Negara;
use App\Model\SubKategori;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Whoops\Exception\ErrorException;

class KategoriSubController extends Controller
{
    public function index()
    {
        $data = Kategori::all();
        $dataSub = SubKategori::all();

        return view('pages.admins.kategori.index',[
            'kategori' => $data,
            'sub' => $dataSub
        ]);
    }

    /**
     * TODO Store Data Kategori
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_kategori(Request $request)
    {
        try {
            Kategori::create([
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
     * TODO Update data Kategori
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_kategori(Request $request)
    {
        try {
            $data = Kategori::find($request->id);
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

    public function delete_kategori(Request $request)
    {
        try {
            $data = Kategori::find($request->id);
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
     * TODO Store Data Kategori
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store_subkategori(Request $request)
    {
        try {
            SubKategori::create([
                'nama' => $request->name,
                'kategori_id' => $request->kategori_id
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
    public function update_subkategori(Request $request)
    {
        try {
            $data = Kategori::find($request->id);
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

    public function delete_subkategori(Request $request)
    {
        try {
            $data = SubKategori::find($request->id);
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
