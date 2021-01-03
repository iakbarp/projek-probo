<?php

namespace App\Http\Controllers\API\Users\Klien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Topup;
use App\Model\DompetHistory;

use App\Model\Saldo;
use App\Model\Bio;
use App\Model\Pembayaran;
use App\Model\Project;
use App\Model\Pengerjaan;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class ProyekPaymentController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proyek_id' => 'required|exists:project,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,

                    'message' =>'Harap memasukkan [proyek_id] dengan benar...'

            ], 400);
        }

        try {
            $proyek_id=$request->proyek_id;
            $u=auth('api')->user();
            $user=Bio::where('user_id',$u->id)->firstOrFail(['foto']);
            $pembayaran=Pembayaran::where('proyek_id',$proyek_id)->first();
            $proyek=Project::find($proyek_id);
            $pengerjaan=Pengerjaan::where('proyek_id',$proyek_id)->first();
            $is_dp=false;

        if($pembayaran){
            $is_dp=is_numeric(strpos($pembayaran->bukti_pembayaran,'DP'));


            if(is_numeric(strpos($pembayaran->bukti_pembayaran,'FP'))){
                return response()->json([
                    'error' => true,

                        'message' =>'Proyek ['.$proyek->judul.'] sudah lunas!',

                ], 400);
            }
        }


        $user->nama=$u->name;
        $user->id=$u->id;

        $bill=$proyek->harga-($is_dp?$pembayaran->jumlah_pembayaran:0);

        $user = $this->imgCheck($user, 'foto', 'users/foto/');

        $saldo=Saldo::where('id',$user->id)->firstOrFail();
            return response()->json([
                'error' => false,
                'data' => [
                   'user'=>$user,
                   'saldo'=>$saldo->saldo,
                   'gross_bill'=>$proyek->harga,
                   'bill'=>$bill,
                   'is_dp'=>$is_dp,
                   'pengerjaan_id'=>$pengerjaan->id
                   ]
            ]);

        } catch (\Exception $exception) {

            return response()->json([
                'error' => true,



                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function viaDompet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'proyek_id' => 'required|exists:project,id',
            'bayar'=>'required|numeric',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,

                    'message' =>'Harap memasukkan [proyek_id] dengan benar...'

            ], 400);
        }
        DB::beginTransaction();


        try {
            $proyek_id=$request->proyek_id;
            $user=auth('api')->user();
            $pembayaran=Pembayaran::where('proyek_id',$proyek_id)->first();
            $proyek=Project::find($proyek_id);
            $is_dp=false;
            $bayar=$request->bayar;

            if($pembayaran){
                $harus_bayar=$proyek->harga-$pembayaran->jumlah_pembayaran;
                $harus_bayar=$harus_bayar?$harus_bayar:0;

            $pemb= $pembayaran->update([
                    'jumlah_pembayaran'=>$pembayaran->jumlah_pembayaran+$harus_bayar,
                    'bayar_pakai_dompet'=>$pembayaran->bayar_pakai_dompet+$harus_bayar,
                    'isDompet'=>1,
                    'bukti_pembayaran'=>'FP - '.now()->format('j F Y'),
                ]);
            }else{
                $bayar_=$proyek->harga<$bayar?$proyek->harga:(($proyek->harga*30/100)>$bayar?($proyek->harga*30/100):$bayar);
                $pemb= Pembayaran::create([
                    'proyek_id'=>$proyek_id,
                    'jumlah_pembayaran'=>$bayar_,
                    'bayar_pakai_dompet'=>$bayar_,
                    'isDompet'=>1,
                    'bukti_pembayaran'=>($proyek->harga<=$bayar?'FP':'DP'). '- '.now()->format('j F Y'),

                ]);
            }

                DompetHistory::create([
                    'jumlah'=>$bayar,
                    'pembayaran_id'=>$pemb->id,
                    'user_id'=>auth('api')->user()->id
                ]);
                DB::commit();
                return response()->json([
                    'error' => false,
                    'data' => [
                    'message'=>($proyek->harga<=$bayar?'Pelunasan':'Pembayaran').' proyek ['.$proyek->judul.'] berhasil',


                ]
                ]);

        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => true,



                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function viewMidtrans(Request $request)
    {

        try{
            $proyek=Project::findOrFail($request->proyek_id);
            $proyek_id=$proyek->id;
            
            $id=auth('api')->user()->id;
            $dp=$request->dp;

            $jumlah_pembayaran=is_numeric($request->jumlah_pembayaran)?$request->jumlah_pembayaran:10000;

            return view('mobile-payment.pembayaran',compact('id','jumlah_pembayaran','proyek_id','dp'));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    private function imgCheck($data, $column, $path, $ch = 0)
    {
        $dummy_photo = [

            asset('admins/img/avatar/avatar-1'  . '.png'),
            asset('images/porto.jpg'),
            asset('images/undangan-' . rand(1, 2) . '.jpg'),

        ];
        $res = $data;

        if (is_array($data) && $column) {

            $res = [];

            foreach ($data as $i => $row) {
                $res[$i] = $row;

                $res[$i][$column] = $res[$i][$column] && Storage::disk('public')->exists($path . $res[$i][$column]) ?
                    asset('storage/'.$path . $res[$i][$column]) :
                    $dummy_photo[$ch];
            }
        } elseif (is_object($data)) {
            $res->{$column} = $res->{$column} && Storage::disk('public')->exists($path . $res->{$column}) ?
                asset('storage/'.$path . $res->{$column}) :
                $dummy_photo[$ch];
        } else {

            $res = Storage::disk('public')->exists($path . $res) ?
                asset('storage/'.$path . $res) : $dummy_photo[$ch];
        }

        return $res ? $res : [];
    }
}
