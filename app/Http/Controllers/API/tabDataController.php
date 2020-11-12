<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Model\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use JWTAuth;

class tabDataController extends Controller
{
    public function home(Request $request)
    {

        $proyek = DB::table('project')->select('project.id')

            ->join('bid', function ($join) {
                $join->on('project.id', '=', 'bid.proyek_id')
                    ->whereNull('bid.tolak');
            })
            ->groupBy('project.id')
            ->orderBy('project.id')
            ->get()

            ->count();


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
    }

    public function proyek(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $q = $request->q;

        $proyek = DB::table('project')

            ->leftJoin('bid as b1', function ($join) {
                $join->on('project.id', '=', 'b1.proyek_id')
                    ->whereNotNull('b1.tolak');
            })
            ->join('subkategori as sub', 'sub.id', '=', 'project.subkategori_id')
            ->join('kategori as kat', 'sub.kategori_id', '=', 'kat.id')

            ->select(
                'project.*',
                'project.subkategori_id',
                DB::raw('sub.nama as subkategori_nama'),
                'sub.kategori_id',
                DB::raw('kat.nama as kategori_nama'),

                DB::raw('ifnull((select count(id) from bid where project.id=bid.proyek_id),0) as `jumlah_bid`')
            )
            ->whereNull('b1.tolak')
            ->when($q, function ($query) use ($q) {
                $query->where('project.judul', 'like', "%$q%");
            })
            ->groupBy('project.id')
            ->orderBy('project.id')

            // ->offset($offset ?? 0)
            ->limit($limit ?? 8)
            ->get();

        $proyek = $proyek ? $this->imgCheck($proyek, 'thumbnail', 'public/proyek/thumbnail/', 0) : [];

        return response()->json([
            'error' => false,
            'data' => $proyek
        ]);
    }

    public function layanan(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;
        $q = $request->q;

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

            // ->offset($offset ?? 0)
            ->limit($limit ?? 8)

            ->get();;

        $layanan = $layanan ? $this->imgCheck($layanan, 'thumbnail', 'public/proyek/thumbnail/', 0) : [];

        return response()->json([
            'error' => false,
            'data' => $layanan
        ]);
    }

    public function frelencer(Request $request)
    {
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


        $frelance = $frelance ? $this->imgCheck($frelance, 'thumbnail', 'public/proyek/thumbnail/', 1) : [];

        return response()->json([
            'error' => false,
            'data' => $frelance
        ]);
    }

    private function imgCheck($data, $column, $path, $ch)
    {
        $res = [];
        $dummy_photo = [
            asset('images/slider/beranda-' . rand(1, 5) . '.jpg'),
            asset('admins/avatar/avatar-' . rand(1, 2) . '.jpg')
        ];

        foreach ($data as $i => $row) {
            $res[$i] = $row;

            $res[$i]->{$column} = File::exists(asset($path . $res[$i]->{$column})) ?
                asset($path . $res[$i]->{$column}) :
                $dummy_photo[$ch];
            $res[$i]->deskripsi = $res[$i]->deskripsi ?
                strip_tags($res[$i]->deskripsi) : 'Belum diisi';
        }

        return $res;
    }
}