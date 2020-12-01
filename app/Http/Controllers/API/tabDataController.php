<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Bid;
use App\Model\Kategori;
use App\Model\Project;
use App\Model\Services;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use JWTAuth;

class tabDataController extends Controller
{
    public function home(Request $request)
    {

        try {
            // $bid=collect(Bid::whereNull('tolak')->get())->pluk('proyek_id');
            $bid = Bid::whereNotNull('tolak')->get();
            $proyek = DB::table('project')->select('project.id')


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
                'message' => $e
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



            $bid = Bid::whereNotNull('tolak')->get();

            $proyek = DB::table('project')


                ->join('subkategori as sub', 'sub.id', '=', 'project.subkategori_id')
                ->join('kategori as kat', 'sub.kategori_id', '=', 'kat.id')

                ->select(
                    'project.*',
                    DB::raw('sub.nama as subkategori_nama'),
                    'sub.kategori_id',
                    DB::raw('kat.nama as kategori_nama'),

                    DB::raw('ifnull((select count(id) from bid where project.id=bid.proyek_id),0) as `jumlah_bid`')
                )
                ->whereNotIn('project.id', $bid->pluck('proyek_id'))

                ->when($q, function ($query) use ($q) {
                    $query->where('project.judul', 'like', "%$q%");
                })
                ->when($kat, function ($query) use ($kat) {
                    $query->whereIn('kat.id', json_decode($kat));
                })

                ->orderBy('project.id', 'desc')

                // ->offset($offset ?? 0)
                ->limit($limit ?? 8)
                ->get();

                // return $proyek;

            $proyek = $proyek ? $this->imgCheck($proyek, 'thumbnail', 'storage/proyek/thumbnail/', 0) : [];
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
                'message' => $e
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


            $layanan = $layanan ? $this->imgCheck($layanan, 'thumbnail', 'storage/layanan/thumbnail/', 0) : [];

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
                'message' => $e
            ], 500);
        }
    }

    public function frelencer(Request $request)
    {
        try {
            $offset = $request->offset;
            $limit = $request->limit;
            $q = $request->q;

            $sub = DB::table('users')
                ->leftJoin('service', 'users.id', '=', 'service.user_id')

                ->leftJoin('pengerjaan as pr', function ($join) {
                    $join->on('users.id', '=', 'pr.user_id');
                    $join->on('pr.selesai', '=', DB::raw('1'));
                })
                ->leftJoin('bid', function ($join) {
                    $join->on('users.id', '=', 'bid.proyek_id');
                    $join->on('bid.tolak', '=', DB::raw('0'));
                })
                ->when($q, function ($query) use ($q) {
                    $query->where('users.name', 'like', "%$q%");
                })
                ->where(function ($q) {
                    $q->whereNotNull('service.user_id');
                    $q->orWhereNotNull('bid.user_id');
                })
                ->select(
                    'users.*',

                    DB::raw('count(pr.id) as jumlah_proyek'),
                    // DB::raw('(select foto from bio where bio.user_id=users.id) as thumbnail'),

                )
                ->groupBy('users.id');

            $frelance = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                ->join('bio', 'bio.user_id', '=', 'sub.id')
                ->select(
                    'sub.*',
                    'bio.foto as thumbnail',
                    'bio.summary as deskripsi'
                )

                // ->offset($offset ?? 0)
                ->limit($limit ?? 8)
                ->get();


            $frelance = $frelance ? $this->imgCheck($frelance, 'thumbnail', 'storage/users/foto/', 1) : [];

            return response()->json([
                'error' => false,
                'data' => $frelance
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e
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


            $kategori = $kategori ? $this->imgCheck($kategori, 'img', 'images/category-icons/', 2, false) : [];

            return response()->json([
                'error' => false,
                'data' => $kategori
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e
            ], 500);
        }
    }

    private function imgCheck($data, $column, $path, $ch, $desk = true)
    {
        $res = [];
        $dummy_photo = [
            asset('images/slider/beranda-' . rand(1, 5) . '.jpg'),
            asset('admins/avatar/avatar-' . rand(1, 2) . '.jpg'),
            asset('images/notfound.png')
        ];

        foreach ($data as $i => $row) {
            $res[$i] = $row;

            $res[$i]->{$column} = $res[$i]->{$column} && File::exists($path . $res[$i]->{$column}) ?
                asset($path . $res[$i]->{$column}) :
                $dummy_photo[$ch];

            if ($desk) {
                $res[$i]->deskripsi = $res[$i]->deskripsi ?
                    strip_tags($res[$i]->deskripsi) : 'Belum diisi';
            }
        }

        return $res;
    }
}
