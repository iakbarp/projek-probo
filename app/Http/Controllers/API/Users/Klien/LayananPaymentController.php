<?php

namespace App\Http\Controllers\API\Users\Klien;

use App\Http\Controllers\Controller;

use App\Model\PembayaranLayanan;
use App\Model\PengerjaanLayanan;
use App\Model\Services;
use App\Model\Bio;
use App\Model\DompetHistory;
use App\Model\Saldo;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LayananPaymentController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengerjaan_id' => 'required|exists:pengerjaan_layanan,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                    'message' =>'Harap memasukkan [pengerjaan_id] dengan benar...'
                
            ], 400);
        }

        try {
            $pengerjaan_id=$request->pengerjaan_id;
            $u=auth('api')->user();
            $user=Bio::where('user_id',$u->id)->firstOrFail(['foto']);

            $pembayaran=PengerjaanLayanan::where('pengerjaan_layanan.id',$pengerjaan_id)
            ->leftJoin('pembayaran_layanan as pl',function($rel)use($u){
                $rel->on('pengerjaan_layanan.id','=','pl.pengerjaan_layanan_id');
                
            })
            ->select('pengerjaan_layanan.*','pl.jumlah_pembayaran','pl.bukti_pembayaran')
            ->first();
            $service=Services::find($pembayaran->service_id);
            
            $is_dp=false;

            if($pembayaran->bukti_pembayaran){

                $is_dp=is_numeric(strpos($pembayaran->bukti_pembayaran,'DP'));

                if(is_numeric(strpos($pembayaran->bukti_pembayaran,'FP'))){
                    return response()->json([
                        'error' => true,
                            'message' =>'Pembayaran Layanan '.$service->judul.' sudah lunas!',
                        
                    ], 400);
                }
            }
            
            
            $user->nama=$u->name;
            $user->id=$u->id;

            $bill=$service->harga-($is_dp?$pembayaran->jumlah_pembayaran:0);

            $user = $this->imgCheck($user, 'foto', 'storage/users/foto/');

            $saldo=Saldo::where('id',$user->id)->firstOrFail();
            
            return response()->json([
                'error' => false,
                'data' => [
                'user'=>$user,
                'saldo'=>$saldo->saldo,
                'gross_bill'=>$service->harga,
                'bill'=>$bill,
                'is_dp'=>$is_dp
                ]
            ]);

        } catch (\Exception $exception) {
        
            return response()->json([
                'error' => true,



                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function viewMidtrans(Request $request)
    {

        try{
            $pengerjaan_layanan=Project::findOrFail($request->pengerjaan_layanan_id);
            $pengerjaan_layanan_id=$pengerjaan_layanan->id;
            
            $id=auth('api')->user()->id;

            $jumlah_pembayaran=is_numeric($request->jumlah)?$request->jumlah:10000;

            return view('mobile-payment.pembayaran',compact('id','jumlah_pembayaran','pengerjaan_layanan_id'));
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
            'pengerjaan_id' => 'required|exists:pengerjaan_layanan,id',
            'bayar'=>'required|numeric',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
           
                    'message' =>'Harap memasukkan [pengerjaan_id] dengan benar...'
                
            ], 400);
        }

        try {
            $pengerjaan_id=$request->pengerjaan_id;
            $user=auth('api')->user();

            $pembayaran=PengerjaanLayanan::where('pengerjaan_layanan.id',$pengerjaan_id)
            ->leftJoin('pembayaran_layanan as pl',function($rel){
                $rel->on('pengerjaan_layanan.id','=','pl.pengerjaan_layanan_id');
                
            })
            ->select('pengerjaan_layanan.*','pl.jumlah_pembayaran','pl.bukti_pembayaran')
            ->first();
            $service=Services::find($pembayaran->service_id);
            
            $is_dp=false;
            $bayar=$request->bayar;

            if($pembayaran->bukti_pembayaran){
                $harus_bayar=$service->harga-$pembayaran->jumlah_pembayaran;
                $harus_bayar=$harus_bayar?$harus_bayar:0;

                $pembayaran=PembayaranLayanan::where('pengerjaan_layanan_id',$pengerjaan_id)
                ->join('pengerjaan_layanan as pl',function($rel)use($user){
                    $rel->on('pl.id','=','pembayaran_layanan.pengerjaan_layanan_id');
                    $rel->on('pl.user_id','=',DB::raw($user->id));
                })
                ->select('pembayaran_layanan.*')
                ->firstOrFail();

                $pemb=$pembayaran->update([
                    'jumlah_pembayaran'=>$pembayaran->jumlah_pembayaran+$harus_bayar,
                    'bayar_pakai_dompet'=>$pembayaran->bayar_pakai_dompet+$harus_bayar,
                    'isDompet'=>1,
                    'bukti_pembayaran'=>'FP - '.now()->format('j F Y'),
                ]);
            }else{
                $bayar_=$service->harga<$bayar?$service->harga:(($service->harga*30/100)>$bayar?($service->harga*30/100):$bayar);
                $pemb=PembayaranLayanan::create([
                    'pengerjaan_layanan_id'=>$pengerjaan_id,
                    'jumlah_pembayaran'=>$bayar_,
                    'bayar_pakai_dompet'=>$bayar_,
                    'isDompet'=>1,
                    'bukti_pembayaran'=>($service->harga<=$bayar?'FP':'DP'). '- '.now()->format('j F Y'),

                ]);
            }

            DompetHistory::create([
                'jumlah'=>$bayar,
                'pembayaran_layanan_id'=>$pemb->id,
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                'message'=>($service->harga<=$bayar?'Pelunasan':'Pembayaran').' proyek ['.$service->judul.'] berhasil',
                
        
                ]
            ]);

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

        if (is_array($data)) {

            $res = [];

            foreach ($data as $i => $row) {
                $res[$i] = $row;

                $res[$i][$column] = $res[$i][$column] && File::exists($path . $res[$i][$column]) ?
                    asset($path . $res[$i][$column]) :
                    $dummy_photo[$ch];
            }
        } elseif (is_object($data)) {


            $res->{$column} = $res->{$column} && File::exists($path . $res->{$column}) ?
                asset($path . $res->{$column}) :
                $dummy_photo[$ch];
        } else {


            $res = File::exists($path . $res) ?
                asset($path . $res) : $dummy_photo[$ch];
        }

        return $res;
    }
}
