<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Negara;
use App\Model\Pembayaran;
use App\Model\PembayaranLayanan;
use App\Model\PengerjaanLayanan;
use App\Model\Project;
use App\Model\Services;
use App\Model\Topup;
use App\Model\Withdraw;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $get_user = Project::query()->whereHas('get_pengerjaan')->first();
            $topup=$data->jumlah_pembayaran;

            $data->update([
                'selesai' => true
            ]);
            Topup::create([
                'user_id'=>$get_user->user_id,
                'jumlah'=>$topup,
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

//            $get_user=PengerjaanLayanan::where('id',$data->pengerjaan_layanan_id)->first();
            $get_user = Services::query()->whereHas('get_pengerjaan_layanan',function ($q) use($data){
                $q->where('id',$data->pengerjaan_layanan_id);
            })->first();

//            dd($data);
            $topup=$data->jumlah_pembayaran;
//
//dd($get_user->get_service);
            $data->update([
                'selesai' => true
            ]);

            Topup::create([
               'user_id'=>$get_user->user_id,
                'jumlah'=>$topup,
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

    public function withdraw()
    {
        $data = Withdraw::all();
        return view('pages.admins.pembayaran.withdraw', [
            'withdraw' => $data
        ]);
    }

    public function withdraw_done(Request $request)
    {
        try {
            $data = Withdraw::find($request->id);
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
