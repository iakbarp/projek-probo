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
use Illuminate\Support\Facades\Storage;

class ProyekController extends Controller
{
    public function dashboard(Request $request)
    {
        try{
            $search=$request->q;
            $user=auth('api')->user();
            $id=$user->id;
            $user=Bio::find($user->id,['status','foto']);
            $user =  $this->imgCheck($user, 'foto', 'users/foto/', 0) ;



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
                DB::raw('if(bid.tolak =0,false,true) as deleteable')


            )
            ->where('bid.user_id',$id)
            ->orderBy('bid.id','desc')
            ->when($search,function($q)use($search){
                $q->where('p.judul','like',"%$search%");
            })
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
                DB::raw('if(undangan.terima = 1,false,true) as approveable')

            )
            ->when($search,function($q)use($search){

                $q->where('p.judul','like',"%$search%");

            })
            ->where('undangan.user_id',$id)
            ->orderBy('undangan.id','desc')
            ->get();

            $pengerjaan=Pengerjaan::query()
            ->join('project as p','pengerjaan.proyek_id','=','p.id')

            ->where('pengerjaan.user_id',$id)
            ->when($search,function($q)use($search){
                $q->where('p.judul','like',"%$search%");
            })
            ->orderBy('id','desc')
            ->get([DB::raw('p.user_id as user_proyek'),'pengerjaan.id','proyek_id','selesai','file_hasil','tautan','pengerjaan.created_at','pengerjaan.updated_at']);


            foreach($bid as $dt){
                $dt->status=is_numeric($dt->tolak)?($dt->tolak?'DITOLAK':'DITERIMA'):'MENUNGGU';
                $dt =  $this->imgCheck($dt, 'thumbnail', 'proyek/thumbnail/', 2) ;

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


            foreach ($pengerjaan as $dt) {
                $file = [];

                if ($dt->file_hasil) {
                    foreach ($dt->file_hasil as $d) {
                        $file[] = $d ? $this->imgCheck($d, null, 'proyek/hasil/', 2) : [];
                    }


                  }
                  
                 $pr=collect($bid)->where('proyek_id', $dt->proyek_id)->first();

               
                  $pembayaran=Pembayaran::where('proyek_id',$dt->proyek_id)->first();
                  $gabung=true;
                  $dt->progressable=0;
                  
                  
                if($pembayaran){
                    if(is_numeric(strpos($pembayaran->bukti_pembayaran,'DP'))){
                       $dt->status= ' (DP'.round($pembayaran->jumlah_pembayaran*100/$pr['harga']).'%)';
                    }elseif((is_numeric(strpos($pembayaran->bukti_pembayaran,'FP')))){
                        $dt->status=' (Lunas)';
                    }else{
                        $gabung = false;

                        $dt->status='Menunggu Pembayaran';
                    }
                    
                }else{
                    $gabung = false;

                    $dt->status='Menunggu Pembayaran';
                }

                if($gabung){
                    if($dt->selesai){
                     $dt->status='Selesai';

                    }else{
                        $dt->progressable=1;

                        $dt->status='Pengerjaan'.$dt->status;
                    }
                }
                
                

                $dt->file_hasil = $file;
                $dt->proyek = $pr;
                $u=auth('api')->user();
                $pekerja=Bio::query()
                ->where('user_id',$id)
                ->select(
                    DB::raw('user_id as id'),
                    'summary',
                DB::raw('ifnull(format(AVG((total_bintang_pekerja+total_bintang_klien)/2),1),0.0) as bintang'))
                ->first();

                $owner = DB::table('users')
                        ->where('users.id', $dt->user_proyek)

                        ->leftJoin('bio', 'bio.user_id', '=', 'users.id')
                        ->select('users.id', 'users.name as nama', 'bio.foto', 'bio.status')
                        ->first();
                $owner =  $this->imgCheck($owner, 'foto', 'users/foto/', 0) ;

                if($pekerja){
                    $pekerja->id=$id;
                    $pekerja->nama=$u->name;
                    $pekerja->status=$user->status;
                    $pekerja->foto=$user->foto;
                }

                $ratingable=1;

                $ulasan_pekerja = DB::table('ulasan_pekerja')
                        ->where('user_id', $dt->user_proyek)
                        ->where('pengerjaan_id', $dt->id)
                        ->select(DB::raw("format(bintang,1) as bintang,	deskripsi"))
                        ->orderBy('id', 'desc')->first();
                if(!$ulasan_pekerja){
                    $ratingable=0;
                    
                    $ulasan_pekerja=(object)[];
                }
                    $dt->ratingable=$ratingable;
                    $ulasan_pekerja->foto=$owner->foto;
                    $ulasan_pekerja->nama=$owner->nama;
                    $ulasan_pekerja->id=$owner->id;

                $kliens = DB::table('ulasan_klien')
                    ->where('user_id', $id)
                    ->where('proyek_id', $dt->proyek_id)
                    ->select(DB::raw("format(bintang,1) as bintang,	deskripsi"))
                    ->orderBy('id', 'desc')->first();

                if(!$kliens){
                    $kliens=(object)[];
                }
                    $kliens->foto=$pekerja->foto;
                    $kliens->nama=$pekerja->nama;
                    $kliens->id=$pekerja->id;



                $ulasan=(Object)[];
                $ulasan->ulasan_pekerja=$ulasan_pekerja;
                $ulasan->ulasan_klien=$kliens;
                $dt->ulasan=$ulasan;

                $dt->pekerja=$pekerja;
                unset($dt->selesai);
                unset($dt->user_proyek);

            }

            foreach($undangan as $dt){
                $dt->status=is_numeric($dt->terima)?($dt->terima?'DITERIMA':'DITOLAK'):'MENUNGGU';
                $dt =  $this->imgCheck($dt, 'thumbnail', 'proyek/thumbnail/', 2) ;

                $sub=SubKategori::where('id',$dt->subkategori_id)->first(['id','nama','kategori_id']);
                $kat=null;
                if($sub){
                    $kat=Kategori::where('id',$sub->kategori_id)->first(['id','nama']);
                }
                $dt->subkategori=$sub;
                $dt->kategori=$kat;
                // unset($dt->terima);
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

                    'bid_count'=>collect($bid)->count(),
                    'undangan_count'=>collect($undangan)->count(),
                    'pengerjaan_count'=>collect($pengerjaan)->count(),

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
        DB::beginTransaction();

        try{
            $cek=Bid::query()
            ->where('id',$id)
            ->where('user_id',$user->id)
            ->where(function($query){
                $query->whereNull('tolak');
                $query->orWhere('tolak','0');
            })
            ->firstOrFail();

            $proyek_id=$cek->proyek_id;

            $cek->delete();

           $undangan= Undangan::query()
            ->where('proyek_id',$proyek_id)
            ->where('user_id',$user->id)->first();

            if($undangan){
                $undangan->delete();
            }
            DB::commit();

            return response()->json([
                'error' => false,
                'data'=>[

                    'message' => 'Berhasil dihapus!',
                ]
            ], 201);


        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function inviteApproval(Request $request)
    {
        DB::beginTransaction();

        $id=$request->id;
        $terima=$request->terima;
        $user=auth('api')->user();
        try{
            $cek=Undangan::query()
            ->where('id',$id)
            ->where('user_id',$user->id)
            ->where(function($q){
                $q->whereNull('terima');
                $q->orWhere('terima',0);
            })
            ->firstOrFail();

            $proyek=Project::find($cek->proyek_id);

            $cek->update([
                'terima'=>$terima,
            ]);

            Bid::create([
                'user_id'=>$user->id,
                'proyek_id'=>$proyek->id,
                'negoharga'=>$proyek->harga,
                'negowaktu'=>$proyek->waktu_pengerjaan,
            ]);
            DB::commit();

            return response()->json([
                'error' => false,
                'data'=>[

                    'message' => 'Berhasil dikonfirmasi!',
                ]
            ], 201);


        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    // public function pengerjaanData(Request $request)
    // {
    //     $id=$request->id;
    //     $q=$request->q;

    //     $user=auth('api')->user();
    //     try{
    //         $cek=pengerjaan::query()
    //         ->where('id',$id)
    //         ->where('user_id',$user->id)
    //         ->firstOrFail();

    //         $progress=PengerjaanProgress::query()
    //         ->where('pengerjaan_id',$id)
    //         ->get();



    //         return response()->json([
    //             'error' => false,
    //             'data'=>[

    //                 'list'=>$progress,
    //                 'count'=>collect($progress)->count()
    //             ]
    //         ], 201);


    //     } catch (\Exception $exception) {
    //         return response()->json([
    //             'error' => true,

    //             'message' => $exception->getMessage()

    //         ], 400);
    //     }
    // }

    // public function pengerjaanPost(Request $request)
    // {
    //     $id=$request->id;
    //     $terima=$request->terima;
    //     $user=auth('api')->user();
    //     try{
    //         $cek=pengerjaanProgress::query()
    //         ->where('id',$id)
    //         ->where('user_id',$user->id)
    //         ->whereNull('terima')
    //         ->firstOrFail();

    //         if ($request->hasFile('bukti_gambar')) {

    //             $thumbnail =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $request->file('bukti_gambar')->getClientOriginalName();
    //             $request->file('bukti_gambar')->storeAs('public/proyek/progress', $thumbnail);
    //         } else {
    //             $thumbnail = null;
    //         }

    //         PengerjaanProgress::create([
    //             'bukti_gambar'=>$thumbnail,
    //             'deskripsi'=>$request->deskripsi,
    //         ]);

    //         return response()->json([
    //             'error' => false,
    //             'data'=>[

    //                 'message' => 'Berhasil ditambahkan!',
    //             ]
    //         ], 201);


    //     } catch (\Exception $exception) {
    //         return response()->json([
    //             'error' => true,

    //             'message' => $exception->getMessage()

    //         ], 400);
    //     }
    // }

    public function ratingKlien($proyek_id,Request $request)
    {
        $user = auth('api')->user();
        
        

        $validator = Validator::make($request->all(), [
            'bintang' => 'required|numeric|max:5|min:0',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $validator->errors()
                ]
            ], 422);
        }

        DB::beginTransaction();


        try {
           $pengerjaan=Project::query()
           ->where('project.id',$proyek_id)
            
            ->join('pengerjaan as p',function($query)use($user){
                $query->on('project.id','=','p.proyek_id');
                $query->where('p.user_id',$user->id);
            })
            ->select('p.id','p.proyek_id','project.user_id','project.judul')
           ->firstOrFail();

           $bio=Bio::where('user_id',$pengerjaan->user_id)->first();

           $bintang_avg=($request->bintang+($bio->total_bintang_klien?$bio->total_bintang_klien:0))/2;

           \App\Model\Review::create([
               'user_id'=>$user->id,
               'proyek_id'=>$pengerjaan->proyek_id,
               'bintang'=>$request->bintang,
               'deskripsi'=>$request->deskripsi,
           ]);

           $bio->update([
            'total_bintang_klien'=>$bintang_avg
           ]);
                       DB::commit();
                       return response()->json([
                           'error'=>false,
                           'data'=>[
                            'message' => 'Komen untuk Proyek ['.$pengerjaan->judul.'] berhasil ditambahkan!'
                           ]
                       ], 201);
           

        } catch (\Exception $exception) {
                        DB::rollback();
            return response()->json([
                'error' => true,
                
                    'message' => $exception->getMessage()
                
            ], 400);
        }
    }

    public function progressProyek(Request $request)
    {
        $user = auth('api')->user();
        $proyek_id = $request->proyek_id;   
        $search=$request->q;

        try {

            $pengerjaan=Project::query()
            ->where('project.id',$proyek_id)
             
             ->join('pengerjaan as p',function($query)use($user){
                 $query->on('project.id','=','p.proyek_id');
                $query->where('p.user_id',$user->id);
                 
             })
             ->select('p.id','p.proyek_id','project.user_id','project.judul')
            ->firstOrFail();

           $progress= PengerjaanProgress::where('pengerjaan_id',$pengerjaan->id)
            ->get();

             foreach($progress as $i=>$dt){
                 $dt->urutan=$i+1;
                $dt = $this->imgCheck($dt, 'bukti_gambar', 'proyek/progress/',3);
                 
             }

             $progress=collect($progress)->reverse()->all();

             $res=[];

             foreach($progress as $dt){
                 $kond=$search?(is_numeric(strpos($dt['created_at'],$search)) 
                 || is_numeric(strpos($dt['deskripsi'],$search))):true;
                 if($kond){
                    $res[]=$dt;
                 }
             }

            return response()->json([
                'error' => false,
                'data' => [
                    'proses'=>$res,
                ]
            ], 200);
          
           

        } catch (\Exception $exception) {
                        
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 400);
        }
    }

    public function tambahProgress(Request $request)
    {
        $user = auth('api')->user();
        $proyek_id = $request->proyek_id;
        

        $validator = Validator::make($request->all(), [
            'bukti_gambar' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $validator->errors()
                ]
            ], 422);
        }

        DB::beginTransaction();

        try {
           $pengerjaan=Project::query()
           ->where('project.id',$proyek_id)
            
            ->join('pengerjaan as p',function($query)use($user){
                $query->on('project.id','=','p.proyek_id');
                $query->where('p.user_id',$user->id);
            })
            ->select('p.id','p.proyek_id','project.user_id','project.judul')
           ->firstOrFail();

           if ($request->hasFile('bukti_gambar')) {
                // Storage::delete('public/proyek/progress/' . $before->thumbnail);

                $bukti_gambar = sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . 
                $request->file('bukti_gambar')->getClientOriginalName();
                $request->file('bukti_gambar')->storeAs('public/proyek/progress', $bukti_gambar);
            }

           \App\Model\PengerjaanProgress::create([
                'pengerjaan_id'=>$pengerjaan->id,
                'proyek_id'=>$pengerjaan->proyek_id,
                'user_id'=>$user->id,
               'bukti_gambar'=>isset($bukti_gambar)?$bukti_gambar:null,
               'deskripsi'=>$request->deskripsi,
           ]);

         
            DB::commit();
            return response()->json([
                'error'=>false,
                'data'=>[
                'message' => 'Progress untuk Proyek ['.$pengerjaan->judul.'] berhasil ditambahkan!'
                ]
            ], 201);
           

        } catch (\Exception $exception) {
                        DB::rollback();
            return response()->json([
                'error' => true,
                
                    'message' => $exception->getMessage()
                
            ], 400);
        }
    }

    public function fileFinal(Request $request)
    {
        $user = auth('api')->user();
        $proyek_id = $request->proyek_id;
        

        $validator = Validator::make($request->all(), [
            'tautan' => 'required|string',
            'file_hasil' => 'required|array',
            'file_hasil.*' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $validator->errors()
                ]
            ], 422);
        }

        DB::beginTransaction();
        try {
           $pengerjaan=Project::query()
           ->where('project.id',$proyek_id)
            
            ->join('pengerjaan as p',function($query)use($user){
                $query->on('project.id','=','p.proyek_id');
                $query->where('p.user_id',$user->id);
            })
            ->select('p.id','p.proyek_id','project.user_id','project.judul')

           ->firstOrFail();

           if ($request->hasFile('file_hasil')) {

                $file_hasil = [];
                $i = 0;
                foreach ($request->file('file_hasil') as $file) {
                    $file_hasil[$i] =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . 
                    $file->getClientOriginalName();

                    $file->storeAs('public/proyek/hasil',  $file_hasil[$i]);
                    $i = 1 + $i;
                }
            } else {
                $file_hasil = null;
            }

           Pengerjaan::find($pengerjaan->id)->update([
               'tautan'=>$request->tautan,
               'file_hasil'=>$file_hasil,
           ]);

         
            DB::commit();
            return response()->json([
                'error'=>false,
                'data'=>[
                'message' => 'file hasil untuk Proyek ['.$pengerjaan->judul.'] berhasil ditambahkan!'
                ]
            ], 201);
           

        } catch (\Exception $exception) {
                        DB::rollback();
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
            asset('images/undangan-2'  . '.jpg'),
            asset('images/noimage' . '.jpg'),


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
