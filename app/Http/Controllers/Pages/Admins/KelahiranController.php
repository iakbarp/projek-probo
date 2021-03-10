<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Kelahiran;
use App\Model\Pernikahan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Whoops\Exception\ErrorException;

class KelahiranController extends Controller
{
    public function kelahiran()
    {
        $data = Kelahiran::all();

        return view('pages.admins.master.kelahiran', [
            'kelahiran' => $data,
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
    public function update_kelahiran(Request $request)
    {
        $data = Kelahiran::find($request->id);
        if ($request->hasFile('foto')) {
            $this->validate($request, ['foto' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120']);
            $foto = $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/dokumen/foto/kelahiran/', $foto);
        } else {
            $foto = $data->foto;
        }
        try {
            $data->update([
                'pt' => $request->pt,
                'dept' => $request->dept,
                'tanggal_lahir' => $request->tanggal_lahir,
                'bank_id' => $request->bank_id,
                'rekening' => $request->rekening,
                'putra' => $request->putra,
                'kota_id' => $request->kota_id,
                'nama_anak' => $request->nama_anak,
                'foto' => $foto,

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
}
