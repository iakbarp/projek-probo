<?php

namespace App\Http\Controllers\API\Users\klien;

use App\Http\Controllers\Controller;
use App\Model\Bio;
use App\Model\Pengerjaan;
use App\Model\Project;
use App\Model\Pembayaran;
use App\Model\PengerjaanProgress;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class ProyekController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            $user = auth('api')->user();
            $limit_proyek = $request->limit_proyek;
            $search_proyek = $request->search_proyek;
            $limit_pengerjaan = $request->limit_pengerjaan;
            $search_pengerjaan = $request->search_pengerjaan;

            // dd($limit_proyek?$limit_proyek:20);

            $proyek = Project::where('project.user_id', $user->id)
                ->when($search_proyek, function ($q) use ($search_proyek) {
                    $q->where('judul', 'like', "%$search_proyek%");
                })
                ->leftJoin('bid', function ($joins) {
                    $joins->on('bid.proyek_id', '=', 'project.id');
                    $joins->on('bid.tolak', '=', DB::raw('0'));
                })
                ->join('subkategori as sub', 'sub.id', '=', 'project.subkategori_id')
                ->join('kategori as kat', 'kat.id', '=', 'sub.kategori_id')
                ->select(
                    "project.id",
                    'subkategori_id',
                    "sub.nama as subkategori_nama",
                    'kat.id as kategori_id',
                    'kat.nama as kategori_nama',
                    "judul",
                    "project.harga",
                    "permalink",
                    "deskripsi",
                    "waktu_pengerjaan",
                    DB::raw("if(pribadi=1,'privat','publik') as`jenis`"),
                    DB::raw("(SELECT count(id) FROM bid where bid.proyek_id=project.id) total_bid"),
                    "thumbnail",
                    "lampiran",
                    DB::raw("if(bid.proyek_id is null, true,false) as editable")
                )
                ->limit($limit_proyek ? $limit_proyek : 20)
                ->orderBy('project.updated_at', 'desc')
                ->get();

            foreach ($proyek as $dt) {
                $lamp = [];
                if (is_array($dt->lampiran)) {
                    foreach ($dt->lampiran as $row) {
                        $lamp[] = $this->imgCheck($row, null, 'proyek/lampiran/', 2);
                    }
                }
                $dt->lampiran = $lamp;

                $dt->subkategori = $dt->subkategori_id ? [
                    'id' => $dt->subkategori_id,
                    'nama' => $dt->subkategori_nama,
                ] : null;

                $dt->kategori = $dt->kategori_id ? [
                    'id' => $dt->kategori_id,
                    'nama' => $dt->kategori_nama,
                ] : null;

                unset($dt->subkategori_id,
                $dt->subkategori_nama,
                $dt->kategori_id,
                $dt->kategori_nama);
            }


            $proyek = $proyek ? $this->imgCheck($proyek->toArray(), 'thumbnail', 'proyek/thumbnail/', 1) : [];


            // return response()->json($proyek);
            $bio = Bio::where('user_id', $user->id)->select(['status', 'foto'])->first();
            $bio->nama = $user->name;
            $bio = $this->imgCheck($bio, 'foto', 'users/foto/');


            $Pengerjaan =
                [];
            $i = 0;
            //TODO:: GANTI KE ELOQUENT UNTUK DEETECT CAST
            foreach ($proyek as $dt) {
                $d = Pengerjaan::query()
                    ->select(
                        'pengerjaan.*',
                        DB::raw('(select ifnull(format(AVG((total_bintang_pekerja+total_bintang_klien)/2),1),0.0) from bio as b where pengerjaan.user_id=b.user_id) as bintang')

                    )
                    ->where('proyek_id', $dt['id'])
                    // ->where('a.selesai',DB::raw('1'))
                    // ->leftJoin('ulasan_pekerja as b','a.id','=','b.pengerjaan_id')
                    // ->groupBy('a.id')
                    // ->groupBy('b.pengerjaan_id')
                    ->orderBy('id', 'desc')
                    ->groupBy('pengerjaan.id')
                    ->first();

            
                
                    

                if ($d) {

                    if($d->file_hasil){
                        $lamp=[];
                        foreach($d->file_hasil as $r){
                            $lamp[] = $this->imgCheck($r, null, 'proyek/hasil/', 2);
                            
                        }
                        $d->file_hasil=$lamp;
                    }else{
                        $d->file_hasil=[];
                    }

                    $pembayaran = Pembayaran::where('proyek_id', $dt['id'])->first();

                    $gabung = true;
                    $lunas=0;

                    if ($pembayaran) {
                        if (is_numeric(strpos($pembayaran->bukti_pembayaran, 'DP'))) {
                            $d->status = ' (DP ' . round($pembayaran->jumlah_pembayaran * 100 / $dt['harga']) . '%)';
                        } elseif ((is_numeric(strpos($pembayaran->bukti_pembayaran, 'FP')))) {
                            $d->status = ' (Lunas)';
                            $lunas=1;

                        } else {
                        $gabung = false;
                            $d->status = 'Menunggu Pembayaran';
                        }
                    } else {
                        $gabung = false;
                        $d->status = 'Menunggu Pembayaran';
                    }
                    if ($gabung) {
                        if ($d->selesai) {
                            $d->status = 'Selesai' . $d->status;

                        } else {
                            $d->status = 'Pengerjaan' . $d->status;
                        }
                    }

                    $pekerjas = DB::table('users')
                        ->where('users.id', $d->user_id)

                        ->leftJoin('bio', 'bio.user_id', '=', 'users.id')
                        ->select('users.id', 'users.name as nama', 'bio.foto', 'bio.status')
                        ->first();
                    $pekerjas->bintang = $d->bintang;
                    $pekerjas = $this->imgCheck($pekerjas, 'foto', 'users/foto/');

                    $ulasan_pekerja = DB::table('ulasan_pekerja')
                        ->where('user_id', $user->id)
                        ->where('pengerjaan_id', $d->id)
                        ->select(DB::raw("format(bintang,1) as bintang,	deskripsi"))
                        ->orderBy('id', 'desc')->first();

                    $kliens = DB::table('ulasan_klien')
                        ->where('user_id', $d->user_id)
                        ->where('proyek_id', $d->proyek_id)
                        ->select(DB::raw("format(bintang,1) as bintang,	deskripsi"))
                        ->orderBy('id', 'desc')->first();


                    $klien = (object)[];
                    $klien->id = $pekerjas->id;
                    $klien->nama = $pekerjas->nama;
                    $klien->foto = $pekerjas->foto;
                    $klien->bintang = $kliens ? $kliens->bintang : null;
                    $klien->deskripsi = $kliens ? $kliens->deskripsi : null;

                    $pekerja = (object)[];
                    $pekerja->id = $user->id;
                    $pekerja->nama = $bio->nama;
                    $pekerja->foto = $bio->foto;
                    $pekerja->bintang = $ulasan_pekerja ? $ulasan_pekerja->bintang : null;
                    $pekerja->deskripsi = $ulasan_pekerja ? $ulasan_pekerja->deskripsi : null;

                    $Pengerjaan[$i] = $dt;
                    $Pengerjaan[$i]['ratingable']=count($d->file_hasil)?1:0;
                    $Pengerjaan[$i]['isLunas']=$lunas;
                    $Pengerjaan[$i]['pengerjaan'] = $d;
                    $Pengerjaan[$i]['pengerjaan']->pekerja = $pekerjas;
                    $ulasan = $Pengerjaan[$i]['pengerjaan']->ulasan = [];
                    $ulasan['ulasan_pekerja'] = $pekerja;
                    $ulasan['ulasan_klien'] = $klien;
                    $Pengerjaan[$i]['pengerjaan']->ulasan = $ulasan;
                    $i++;
                }
            }
            return response()->json([
                'error' => false,
                'data' => [
                    'bio' => $bio,
                    'proyek' => $proyek,
                    'Pengerjaan' => $Pengerjaan,
                    'proyek_count' => Project::where('project.user_id', $user->id)
                        ->when($search_proyek, function ($q) use ($search_proyek) {
                            $q->where('judul', 'like', "%$search_proyek%");
                        })->get()->count(),
                    'Pengerjaan_count' => $i,
                ]
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function tambahProyek(Request $request)
    {
        $user = auth('api')->user();
        $judul = preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul));

        try {

            $cek = Project::where('user_id', $user->id)->where('permalink', $judul)->first();


            if (!$cek) {

                $validator = Validator::make($request->all(), [
                    'judul' => 'required|string|max:100',
                    'jenis' => 'required|in:privat,publik',
                    'waktu_pengerjaan' => 'required|integer',
                    'harga' => 'required|integer',
                    'deskripsi' => 'required|string|max:250',
                    'kategori' => 'required|exists:subkategori,id',
                    'lampiran' => 'required|array',
                    'lampiran.*' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120',
                    'thumbnail' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
                ]);

                if ($validator->fails()) {

                    return response()->json([
                        'error' => true,
                        'data' => [
                            'message' => $validator->errors()
                        ]
                    ], 422);
                }

                if ($request->hasFile('thumbnail')) {

                    $thumbnail =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $request->file('thumbnail')->getClientOriginalName();
                    $request->file('thumbnail')->storeAs('public/proyek/thumbnail', $thumbnail);
                } else {
                    $thumbnail = null;
                }

                if ($request->hasFile('lampiran')) {

                    $lampiran = [];
                    $i = 0;
                    foreach ($request->file('lampiran') as $file) {
                        $lampiran[$i] =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $file->getClientOriginalName();

                        $file->storeAs('public/proyek/lampiran',  $lampiran[$i]);
                        $i = 1 + $i;
                    }
                } else {
                    $lampiran = null;
                }

                Project::create([
                    'user_id' => $user->id,
                    'subkategori_id' => $request->kategori,
                    'judul' => $request->judul,
                    'permalink' =>  $judul,
                    'deskripsi' => $request->deskripsi,
                    'waktu_pengerjaan' => $request->waktu_pengerjaan,
                    'harga' =>  $request->harga,
                    'thumbnail' => $thumbnail,
                    'lampiran' => $lampiran,
                    'pribadi' => $request->jenis == 'privat' ? 1 : 0,
                ]);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Tugas/Proyek [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function updateProyek(Request $request)
    {


        $user = auth('api')->user();
        $judul = preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul));

        try {
            $before = Project::query()->findOrFail($request->proyek_id);


            $cek = Project::where('user_id', $user->id)->where('permalink', $judul)
                ->where('permalink', '!=', $before->permalink)
                // ->where('')
                ->first();


            if (!$cek) {

                $validator = Validator::make($request->all(), [
                    'judul' => 'required|string|max:100',
                    'jenis' => 'required|in:privat,publik',
                    'waktu_pengerjaan' => 'required|integer',
                    'harga' => 'required|integer',
                    'deskripsi' => 'required|string|max:250',
                    'kategori' => 'required|exists:subkategori,id',
                    // 'lampiran' => 'required|array',
                    // 'lampiran.*' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120',
                    'thumbnail' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
                ]);

                if ($validator->fails()) {

                    return response()->json([
                        'error' => true,
                        'data' => [
                            'message' => $validator->errors()
                        ]
                    ], 422);
                }

                if ($request->hasFile('thumbnail')) {
                    Storage::delete('public/proyek/thumbnail/' . $before->thumbnail);

                    $thumbnail = sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $request->file('thumbnail')->getClientOriginalName();
                    $request->file('thumbnail')->storeAs('public/proyek/thumbnail', $thumbnail);
                } else {
                    $thumbnail = $before->thumbnail;
                }



                $before->update([
                    'user_id' => $user->id,
                    'subkategori_id' => $request->kategori,
                    'judul' => $request->judul,
                    'permalink' =>  $judul,
                    'deskripsi' => $request->deskripsi,
                    'waktu_pengerjaan' => $request->waktu_pengerjaan,
                    'harga' =>  $request->harga,
                    'thumbnail' => $thumbnail,
                    // 'lampiran' => $lampiran,
                    'pribadi' => $request->jenis == 'privat' ? 1 : 0,
                ]);
                return response()->json([
                    'error' => false,
                    "data" => ['message' => 'berhasil diubah!']

                ]);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Tugas/Proyek [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 500);
        }
    }

    public function deleteProyek($proyek_id)
    {
        $user = auth('api')->user();

        try {
            $cek = Project::where('user_id', $user->id)
                ->where('id', $proyek_id)->first();

            if ($cek) {


                if ($cek->thumbnail != "") {
                    Storage::delete('public/proyek/thumbnail/' . $cek->thumbnail);
                }

                if ($cek->lampiran != "") {
                    foreach ($cek->lampiran as $item) {
                        Storage::delete('public/proyek/lampiran/' . $item);
                    }
                }

                $name = $cek->judul;
                $cek->delete();

                return response()->json([
                    'error' => false,
                    'data' => [
                        'message' => "Proyek ['$name'] berhasil dihapus!"
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Tugas/Proyek tidak ditemukan!'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function tambahLampiran(Request $request)
    {
        $user = auth('api')->user();
        $proyek_id = $request->proyek_id;


        try {

            $validator = Validator::make($request->all(), [
                'lampiran' => 'required|array',
                'lampiran.*' => 'mimes:jpg,jpeg,gif,png,pdf,doc,docx,xls,xlsx,odt,ppt,pptx|max:5120',

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' => $validator->errors()
                    ]
                ], 422);
            }

            $cek = Project::query()->where('user_id', $user->id)
                ->where('id', $proyek_id)->first();

            if ($cek) {
                $lampiran = $cek->lampiran;
                $lampiran_length = is_array($lampiran) ? count($lampiran) : 0;

                if ($request->hasFile('lampiran')) {

                    $i = $lampiran_length;
                    foreach ($request->file('lampiran') as $file) {
                        $lampiran[$i] =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $file->getClientOriginalName();

                        $file->storeAs('public/proyek/lampiran',  $lampiran[$i]);
                        $i = 1 + $i;
                    }
                }

                if ($lampiran !== $i) {
                    $cek->update(['lampiran' => $lampiran]);
                }

                return response()->json([
                    'error' => false,

                    'message' =>  'Lampiran berhasil ditambah!'

                ]);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Tugas/Proyek tidak ditemukan!'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ]);
        }
    }

    public function deleteLampiran(Request $request)
    {
        $user = auth('api')->user();
        $proyek_id = $request->proyek_id;
        $nama = $request->nama_lampiran;



        try {
            $cek = Project::query()->where('user_id', $user->id)
                ->where('id', $proyek_id)->first();

            if ($cek) {
                $lampiran = [];

                $i = 0;
                if (is_array($cek->lampiran)) {
                    foreach ($cek->lampiran as $file) {
                        if (is_numeric(strpos($file, $nama))) {
                            Storage::delete('public/proyek/lampiran/' . $file);
                        } else {
                            $lampiran[] = $file;
                        }
                    }
                }


                if ($lampiran !== $i) {
                    $cek->update(['lampiran' => $lampiran]);
                }

                return response()->json([
                    'error' => false,
                    'data' => [
                        'message' =>  'Lampiran berhasil dihapus!',
                        'lampiran' => $lampiran
                    ]

                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 400);
        }
    }

    public function ratingPekerja(Request $request)
    {
        $user = auth('api')->user();
        $proyek_id = $request->proyek_id;
        

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
            ->where('project.user_id',$user->id)
            ->join('pengerjaan as p',function($query){
                $query->on('project.id','=','p.proyek_id');
                $query->whereNotNull('file_hasil');
                $query->where('selesai','!=',DB::raw('0'));
            })
            ->select('p.id','p.proyek_id','p.user_id','project.judul')
           ->firstOrFail();

           $bio=Bio::where('user_id',$pengerjaan->user_id)->first();

           $bintang_avg=($request->bintang+($bio->total_bintang_pekerja?$bio->total_bintang_pekerja:0))/2;


           \App\Model\ReviewWorker::create([
               'user_id'=>$user->id,
               'pengerjaan_id'=>$pengerjaan->id,
               'bintang'=>$request->bintang,
               'deskripsi'=>$request->deskripsi,
           ]);

           $bio->update([
            'total_bintang_pekerja'=>$bintang_avg
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
             ->where('project.user_id',$user->id)
             ->join('pengerjaan as p',function($query){
                 $query->on('project.id','=','p.proyek_id');
                 
             })
             ->select('p.id','p.proyek_id','p.user_id','project.judul')
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

    private function imgCheck($data, $column, $path, $ch = 0)
    {
        $dummy_photo = [

            asset('admins/img/avatar/avatar-1' . '.png'),
            asset('images/porto.jpg'),
            asset('images/undangan-2' . '.jpg'),
            asset('images/noimage' . '.jpg'),


        ];
        $res = $data;

        if (is_array($data)) {

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

        return $res;
    }
}
