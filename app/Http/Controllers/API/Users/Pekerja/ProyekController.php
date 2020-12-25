<?php

namespace App\Http\Controllers\API\Users\Pekerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use App\Model\Bid;
use App\Model\Bio;
use App\Model\Kategori;
use App\Model\Project;
use App\Model\Review;
use App\Model\ReviewWorker;
use App\Model\Undangan;
use App\Model\SubKategori;
use App\Model\Pengerjaan;
use App\Model\PengerjaanProgress;
use App\Model\Pembayaran;
use App\User;


class ProyekController extends Controller
{
    public function dashboard(Request $request)
    {
        try{
            $user=auth('api')->user();

            $bid=Bid::query()
            ->join('project as p','bid.proyek_id','=','p.id')
            ->select(
                'bid.id',
                'bid.proyek_id',
                'p.judul',
                'p.harga',
                'p.thumbnail',
                'p.subkategori_id',
                'p.deskripsi',
                DB::raw("(select ifnull(count(b.id),0) from bid as b where b.proyek_id=bid.proyek_id) as jumlah_bid"),
                'p.waktu_pengerjaan',
                'bid.tolak',
                DB::raw('if(bid.tolak !=0,false,true) as deleteable'),


            )
            ->where('bid.user_id',$user->id)
            ->orderBy('bid.id','desc')
            ->get();

            $undangan=Undangan::query()
            ->join('project as p','undangan.proyek_id','=','p.id')
            ->select(
                'undangan.id',
                'undangan.proyek_id',
                'p.judul',
                'p.harga',
                'p.thumbnail',
                'p.subkategori_id',
                'p.deskripsi',
                DB::raw("(select ifnull(count(b.id),0) from bid as b where b.proyek_id=undangan.proyek_id) as jumlah_bid"),
                'p.waktu_pengerjaan',
                'undangan.terima',
                DB::raw('if(undangan.terima is not null,false,true) as approveable'),

            )
            ->where('undangan.user_id',$user->id)
            ->orderBy('undangan.id','desc')
            ->get();

            $pengerjaan=Pengerjaan::query()
            ->where('user_id',$user->id)
            ->get(['id','proyek_id','selesai','file_hasil','tautan','created_at','updated_at']);

            foreach ($pengerjaan as $dt) {
                $file = [];

                if ($dt->file_hasil) {
                    foreach ($dt->file_hasil as $d) {
                        $file[] = $d ? $this->imgCheck($d, null, 'storage/proyek/hasil/', 2) : [];
                    }


                  }

                $pembayaran=Pembayaran::where('proyek_id',$dt->proyek_id)->first();

                if($pembayaran){
                    if(is_numeric(strpos($pembayaran->bukti_pembayaran,'DP'))){
                       $dt->status= 'Pembayaran DP '.round($pembayaran->jumlah_pembayaran*100/$dt['harga']).'%';
                    }elseif((is_numeric(strpos($pembayaran->bukti_pembayaran,'FP')))){
                        $dt->status='Pembayaran Lunas';
                    }else{
                        $dt->status='Menunggu Pembayaran';
                    }
                }else{
                    $dt->status='Menunggu Pembayaran';
                }

                if($dt->selesai){
                    $dt->status='Proyek Selesai';

                }

                $dt->file_hasil = $file;
                $dt->proyek = collect($bid)->where('id', $dt->proyek_id)->first();
                
                unset($dt->selesai);
            }
            foreach($bid as $dt){
            $dt->status=$dt->tolak==null?($dt->tolak?'DITOLAK':'DITERIMA'):'MENUNGGU';
            $dt =  $this->imgCheck($dt, 'thumbnail', 'storage/proyek/thumbnail/', 1) ;

            $sub=SubKategori::where('id',$dt->subkategori_id)->first(['id','nama','kategori_id']);
            $kat=null;
            if($sub){
                $kat=Kategori::where('id',$sub->kategori_id)->first(['id','nama']);
            }
            $dt->subkategori=$sub;
            $dt->kategori=$kat;
            unset($dt->tolak);
            unset($dt->subkategori_id);
            unset($dt->subkategori->kategori_id);

            }

            foreach($undangan as $dt){
                $dt->status=$dt->terima==null?($dt->terima?'DITOLAK':'DITERIMA'):'MENUNGGU';
                $dt =  $this->imgCheck($dt, 'thumbnail', 'storage/proyek/thumbnail/', 1) ;
    
                $sub=SubKategori::where('id',$dt->subkategori_id)->first(['id','nama','kategori_id']);
                $kat=null;
                if($sub){
                    $kat=Kategori::where('id',$sub->kategori_id)->first(['id','nama']);
                }
                $dt->subkategori=$sub;
                $dt->kategori=$kat;
                unset($dt->terima);
                unset($dt->subkategori_id);
                unset($dt->subkategori->kategori_id);
    
                }



            return response()->json([
                'error' => false,
                'data'=>[
                    'user'=>$user,
                    'bid'=>$bid,
                    'undangan'=>$undangan,
                    'pengerjaan'=>$pengerjaan,
                    'count'=>[
                        'bid'=>collect($bid)->count(),
                        'undangan'=>collect($undangan)->count(),
                        'pengerjaan'=>collect($pengerjaan)->count(),
                    ]
                ]

            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function deleteBid(Request $request)
    {
        $id=$request->id;
        $user=auth('api')->user();
        try{
            $cek=Bid::query()
            ->where('id',$id)
            ->where('user_id',$user->id)
            ->where('tolak','!=',0)
            ->firstOrFail();

            $cek->delete();

            return response()->json([
                'error' => false,
                'data'=>[
                    
                    'message' => 'Berhasil dihapus!',
                ]
            ], 201);

            
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function inviteApproval(Request $request)
    {
        $id=$request->id;
        $terima=$request->terima;
        $user=auth('api')->user();
        try{
            $cek=Undangan::query()
            ->where('id',$id)
            ->where('user_id',$user->id)
            ->whereNull('terima')
            ->firstOrFail();

            $cek->update([
                'terima'=>$terima,
            ]);

            return response()->json([
                'error' => false,
                'data'=>[
                    
                    'message' => 'Berhasil dikonfirmasi!',
                ]
            ], 201);

            
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function pengerjaanData(Request $request)
    {
        $id=$request->id;
        $q=$request->q;
      
        $user=auth('api')->user();
        try{
            $cek=pengerjaan::query()
            ->where('id',$id)
            ->where('user_id',$user->id)
            ->firstOrFail();

            $progress=PengerjaanProgress::query()
            ->where('pengerjaan_id',$id)
            ->get();

        

            return response()->json([
                'error' => false,
                'data'=>[
                    
                    'list'=>$progress,
                    'count'=>collect($progress)->count()
                ]
            ], 201);

            
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function pengerjaanPost(Request $request)
    {
        $id=$request->id;
        $terima=$request->terima;
        $user=auth('api')->user();
        try{
            $cek=pengerjaanProgress::query()
            ->where('id',$id)
            ->where('user_id',$user->id)
            ->whereNull('terima')
            ->firstOrFail();

            if ($request->hasFile('bukti_gambar')) {

                $thumbnail =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $request->file('bukti_gambar')->getClientOriginalName();
                $request->file('bukti_gambar')->storeAs('public/proyek/progress', $thumbnail);
            } else {
                $thumbnail = null;
            }

            PengerjaanProgress::create([
                'bukti_gambar'=>$thumbnail,
                'deskripsi'=>$request->deskripsi,
            ]);

            return response()->json([
                'error' => false,
                'data'=>[
                    
                    'message' => 'Berhasil ditambahkan!',
                ]
            ], 201);

            
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

            asset('admins/img/avatar/avatar-1' . '.png'),
            asset('images/porto.jpg'),
            asset('images/undangan-' . rand(1, 2) . '.jpg'),

        ];
        $res = $data;

        if (is_array($data) && $column) {

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

        return $res ? $res : [];
    }

}
