<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Negara;
use App\Model\Pembayaran;
use App\Model\PembayaranLayanan;
use App\Model\Project;
use App\Model\Services;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Whoops\Exception\ErrorException;

class PembayaranController extends Controller
{
    public function project()
    {
        $data = Pembayaran::all();
        return view('pages.admins.pembayaran.project', [
            'project' => $data
        ]);
    }

    public function project_done(Request $request)
    {
        try {
            $data = Pembayaran::find($request->id);
            $data->update([
                'selesai' => true
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Pembayaran Telah Diproses"
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


    public function service()
    {
        $data = PembayaranLayanan::all();
        return view('pages.admins.pembayaran.service', [
            'service' => $data
        ]);
    }

    public function service_done(Request $request)
    {
        try {
            $data = PembayaranLayanan::find($request->id);
            $data->update([
                'selesai' => true
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Pembayaran Telah Diproses"
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
