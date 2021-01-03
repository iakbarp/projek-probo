<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Bid;
use App\Model\Kategori;
use App\Model\Project;
use App\Model\Services;
use App\Model\SubKategori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use JWTAuth;

class tabDataController extends Controller
{
    public function home(Request $request)
    {

        try {
            $user=auth('api')->user();
            // $bid=collect(Bid::whereNull('tolak')->get())->pluk('proyek_id');
            $bid = Bid::whereNotNull('tolak')
            ->groupBy('proyek_id')
            ->get();
            $proyek = DB::table('project')->select('project.id')
                ->where('user_id','!=',$user->id)

                ->whereNotIn('project.id', $bid->pluck('proyek_id'))


                ->get()->count();


            $layanan = Services::select('id')
                ->get()
                ->count();


            $userWithService = DB::table('users')
                ->select('users.id')
                ->leftJoin('service', 'users.id', '=', 'service.user_id')
                ->leftJoin('bid', function ($join) {
                    $join->on('users.id', '=', 'bid.proyek_id');
                    $join->on('bid.tolak', '=', DB::raw('0'));
                })
                ->whereNotNull('service.user_id')
                ->orWhereNotNull('bid.user_id')
                ->groupBy('users.id')
                ->get()
                ->count();



            return response()->json([
                'error' => false,
                'data' => [
                    'proyek' => $proyek,
                    'layanan' => $layanan,
                    'frelancer' => $userWithService,
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function proyek(Request $request)
    {
        try {
            // $offset = $request->offset;
            $limit = $request->limit;
            $q = $request->q;
            $kat = $request->kat;
            $user=auth('api')->user();




            $bid = Bid::whereNotNull('tolak')->get();

            $proyek = DB::table('project')


                ->join('subkategori as sub', 'sub.id', '=', 'project.subkategori_id')
                ->join('kategori as kat', 'sub.kategori_id', '=', 'kat.id')
                ->leftJoin('bid', function($rel){
                    $rel->on('bid.proyek_id', '=', 'project.id');
                    $rel->on('bid.tolak', '=',DB::raw(0));
                })
                ->where('project.user_id','!=',$user->id)


                ->select(
                    'project.*',
                    DB::raw('sub.nama as subkategori_nama'),
                    'sub.kategori_id',
                    DB::raw('kat.nama as kategori_nama'),

                    DB::raw('ifnull((select count(id) from bid where project.id=bid.proyek_id),0) as `jumlah_bid`')
                )
                ->whereNotIn('project.id', $bid->pluck('proyek_id'))
                ->whereNull('bid.id')
                ->where('pribadi', false)

                ->when($q, function ($query) use ($q) {
                    $query->where('project.judul', 'like', "%$q%");
                })
                ->when($kat, function ($query) use ($kat) {
                    $query->whereIn('kat.id', json_decode($kat));
                })
                ->groupBy( 'project.id','bid.proyek_id')
                ->orderBy('project.id', 'desc')

                // ->offset($offset ?? 0)
                ->limit($limit ?? 8)
                ->get();

                // return $proyek;

            $proyek = $proyek ? $this->imgCheck($proyek, 'thumbnail', 'proyek/thumbnail/', 0) : [];
            if($kat){
            $kat=Kategori::whereIn('id',json_decode($kat))->select('nama')->orderBy('nama')->get();
            }else{
                $kat=[];
            }

            return response()->json([
                'error' => false,
                'data' => ['list'=>$proyek,'kategori'=>count($kat)?$kat->pluck('nama'):[]]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function layanan(Request $request)
    {
        try {
            $offset = $request->offset;
            $limit = $request->limit;
            $q = $request->q;
            $kat = $request->kat;

            $layanan = DB::table('service')
                ->join('subkategori as sub', 'sub.id', '=', 'service.subkategori_id')
                ->join('kategori as kat', 'sub.kategori_id', '=', 'kat.id')
                ->select(
                    'service.*',
                    DB::raw('sub.nama as subkategori_nama'),
                    'sub.kategori_id',
                    DB::raw('kat.nama as kategori_nama'),
                    DB::raw('ifnull((select count(id) from pengerjaan_layanan where
                service.id=pengerjaan_layanan.service_id
                and pengerjaan_layanan.selesai=1
                ),0) as `jumlah_klien`

                ')

                )
                ->when($q, function ($query) use ($q) {
                    $query->where('service.judul', 'like', "%$q%");
                })

                ->when($kat, function ($query) use ($kat) {
                    $query->whereIn('kat.id', json_decode($kat));

                })

                // ->offset($offset ?? 0)
                ->limit($limit ?? 8)

                ->get();;


            $layanan = $layanan ? $this->imgCheck($layanan, 'thumbnail', 'layanan/thumbnail/', 0) : [];

            if($kat){
                $kat=Kategori::whereIn('id',json_decode($kat))->select('nama')->orderBy('nama')->get();
                }else{
                    $kat=[];
                }
            return response()->json([
                'error' => false,
                'data' => ['list'=>$layanan,'kategori'=>count($kat)?
                $kat->pluck('nama'):[]]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function frelencer(Request $request)
    {
        try {
            $user=auth('api')->user();
            $offset = $request->offset;
            $limit = $request->limit;
            $q = $request->q;

            $sub = DB::table('users')
                ->leftJoin('service', 'users.id', '=', 'service.user_id')

                // ->leftJoin('project as pr', function ($join) {
                //     $join->on('users.id', '=', 'pr.user_id');
                //     $join->join('bid as pe',function($rel){
                //         $rel->on('pe.proyek_id','=','pr.id');
                //         $rel->on('pe.tolak',DB::raw('null'));
                //     });
                //     // $join->on('pr.selesai', '=', DB::raw('1'));
                // })
                ->leftJoin('bid', function ($join) {
                    $join->on('users.id', '=', 'bid.user_id');
                    // $join->on('bid.tolak', '=', DB::raw('0'));
                })

                ->where(function ($qury) {
                    $qury->whereNotNull('service.user_id');
                    // $qury->orWhereNotNull('bid.user_id');
                })

                ->select(
                    'users.id',
                    'users.name',

                    DB::raw('ifnull((select count(pr.id) from `project` as `pr` join `bid` as `pe` on
                    `pe`.`proyek_id` = `pr`.`id` and `pe`.`tolak` is null
                     where  `users`.`id` = `pr`.`user_id` group by `pr`.`user_id`),0) as jumlah_proyek')
                    // DB::raw('(select foto from bio where bio.user_id=users.id) as thumbnail'),

                )
                ->groupBy('users.id','service.user_id');

            // dd($sub->toSql());

            $frelance = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                ->join('bio', 'bio.user_id', '=', 'sub.id')
                ->leftJoin('kota', 'kota.id', '=', 'bio.kota_id')
                ->leftJoin('provinsi as pr', 'kota.provinsi_id', '=', 'pr.id')
                // ->leftJoin('testimoni as ts', 'ts.user_id', '=', 'sub.id')
                ->select(
                    'sub.*',
                    'bio.foto',
                    'bio.summary as deskripsi',
                    DB::raw("if(bio.alamat is null,null,CONcat(if(kota.nama is null,'',kota.nama),if(pr.nama is null,'',concat(', ',pr.nama)))) alamat"),
                    // DB::raw("if(bio.alamat is null,null,CONcat(bio.alamat,if(kota.nama is null,'',concat(', ',kota.nama)),if(pr.nama is null,'',concat(', ',pr.nama)))) alamat"),
                    DB::raw('(SELECT format(AVG(bintang),1)  FROM `testimoni` where user_id=sub.id) as bintang'),
                    DB::raw('(SELECT count(bintang)  FROM `testimoni` where user_id=sub.id) as ulasan'),
                    // DB::raw('(SELECT count(id)  FROM `bid` where user_id=sub.id and tolak=0) as proyek'),
                    DB::raw('sub.jumlah_proyek as proyek'),
                    'bio.created_at',
                    'bio.updated_at'

                )

                ->when($q, function ($query) use ($q) {
                    $query->where('sub.name', 'like', "%$q%");
                })
                ->where('sub.id','!=',$user->id)

                // ->offset($offset ?? 0)
                ->limit($limit ?? 20)
                ->get();


            $frelance = $frelance ? $this->imgCheck($frelance, 'foto', 'users/foto/', 1) : [];

            $frelance=collect($frelance)->chunk(2);
            return response()->json([
                'error' => false,
                'data' => ["list"=>$frelance->all()]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function kategori(Request $request)
    {
        try {
            $q = $request->q;


            $kategori = DB::table('kategori')
                ->select(
                    'id',
                    'nama',
                    'img'
                )
                ->when($q, function ($query) use ($q) {
                    $query->where('nama', 'like', "%$q%");
                })
                ->orderBy(
                    'nama'
                )
                ->get();


            // $kategori = $kategori ? $this->imgCheck($kategori, 'img', 'images/category-icons/', 2, false) : [];

            foreach($kategori as $dt){
                $dt->img=asset('images/category-icons/'.$dt->img);
            }

            return response()->json([
                'error' => false,
                'data' => $kategori
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function grupKategori(Request $r)
    {
        $id = $r->id;
        $q = $r->q;

        try {
            $kategori = Kategori::select('id', 'nama') ->orderBy('nama')->get()->toArray();
            $kategori = collect($kategori);


            $keyed = $kategori->map(function ($item, $i) use ($id, $q) {
                $kota = SubKategori::select(
                    'id',
                    'nama',
                    DB::raw("if(id='$id',true,false) as selected")
                )->where('kategori_id', $item['id'])
                    ->when($q, function ($query) use ($q) {
                        $query->where('nama', 'like', "%$q%");
                    })
                    ->orderBy('nama')
                    ->get();


                return  [
                    'id' => $item['id'],
                    'nama' => $item['nama'],
                    'sub' => $kota->count() ? $kota : null,
                ];
            });
            $kota = [];
            foreach ($keyed->whereNotNull('sub')->all() as $row) {
                $kota[] = $row;
            }





            return response()->json(
                [
                    'error' => false,
                    'data' => $kota,
                ]
            );
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 400);
        }
    }


    private function imgCheck($data, $column, $path, $ch, $desk = true)
    {
        $res = [];
        $dummy_photo = [
            asset('images/undangan-' . rand(1, 2) . '.jpg'),

            asset('admins/img/avatar/avatar-' . rand(1, 2) . '.png'),
            asset('images/notfound.png')
        ];

        foreach ($data as $i => $row) {
            $res[$i] = $row;

            $res[$i]->{$column} = $res[$i]->{$column} && Storage::disk('public')->exists($path . $res[$i]->{$column}) ?
                asset('storage/'.$path . $res[$i]->{$column}) :
                $dummy_photo[$ch];

            if ($desk) {
                $res[$i]->deskripsi = $res[$i]->deskripsi ?
                    strip_tags($res[$i]->deskripsi) : 'Belum diisi';
            }
        }

        return $res;
    }
}
