<?php

namespace App\Http\Controllers\API\Users\klien;

use App\Http\Controllers\Controller;
use App\Model\Bio;
use App\Model\Pengerjaan;
use App\Model\Project;
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
                    DB::raw("(SELECT count(id) FROM bid where bid.proyek_id=project.id) total_bid"),
                    "thumbnail",
                    "lampiran",
                    DB::raw("if(bid.proyek_id is not null, true,false) as editable")
                )
                ->limit($limit_proyek ? $limit_proyek : 20)
                ->get();

            foreach ($proyek as $dt) {
                $lamp = [];

                foreach ($dt->lampiran as $row) {
                    $lamp[] = $this->imgCheck($row, null, 'storage/proyek/lampiran/', 2);
                }
                $dt->lampiran = $lamp;

                $dt->kategori = $dt->subkategori_id ? [
                    'id' => $dt->subkategori_id,
                    'nama' => $dt->subkategori_nama,
                ] : null;

                $dt->subkategori = $dt->kategori_id ? [
                    'id' => $dt->kategori_id,
                    'nama' => $dt->kategori_nama,
                ] : null;

                unset($dt->subkategori_id,
                $dt->subkategori_nama,
                $dt->kategori_id,
                $dt->kategori_nama,);
            }


            $proyek = $proyek ? $this->imgCheck($proyek->toArray(), 'thumbnail', 'storage/proyek/thumbnail/', 1) : [];


            // return response()->json($proyek);
            $bio = Bio::where('user_id', $user->id)->select(['status', 'foto'])->first();
            $bio->nama = $user->name;
            $bio = $this->imgCheck($bio, 'foto', 'storage/users/foto');


            $Pengerjaan =
                [];
            $i = 0;

            foreach ($proyek as $dt) {
                $d = DB::table('pengerjaan as a')
                ->select('a.*',
                DB::raw('(select ifnull(format(AVG(b.bintang),1),0.0) from ulasan_pekerja as b where a.id=b.pengerjaan_id) as bintang'))
                ->where('proyek_id', $dt['id'])
                // ->where('a.selesai',DB::raw('1'))
                // ->leftJoin('ulasan_pekerja as b','a.id','=','b.pengerjaan_id')
                // ->groupBy('a.id')
                // ->groupBy('b.pengerjaan_id')
                ->orderBy('id','desc')
                ->first();


                if ($d) {
                    // $query="SELECT a.*,ifnull(format(AVG(b.bintang),1),0.0) bintang FROM pengerjaan a left join ulasan_pekerja b on a.id=b.pengerjaan_id
                    // where selesai=1
                    // group by a.id,b.pengerjaan_id";

                    // $hasil=DB::raw($query)->first();

                    $pekerjas = DB::table('users')
                        ->where('users.id', $d->user_id)

                        ->leftJoin('bio', 'bio.user_id', '=', 'users.id')
                        ->select('users.id', 'users.name as nama', 'bio.foto','bio.status')
                        ->first();
                    $pekerjas->bintang=$d->bintang;
                    $pekerjas = $this->imgCheck($pekerjas, 'foto', 'storage/users/foto');

                    $ulasan_pekerja = DB::table('ulasan_pekerja')
                        ->where('user_id', $user->id)
                        ->where('pengerjaan_id',$d->id)
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
                    $pekerja->bintang = $ulasan_pekerja?$ulasan_pekerja->bintang:null;
                    $pekerja->deskripsi = $ulasan_pekerja?$ulasan_pekerja->deskripsi:null;

                    $Pengerjaan[$i] = $dt;
                    $Pengerjaan[$i]['pengerjaan'] = $d;
                    $Pengerjaan[$i]['pengerjaan']->pekerja=$pekerjas;
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
                    'Pengerjaan_count' => Pengerjaan::whereIn('proyek_id', collect($proyek)->pluck('id'))
                        ->when($search_pengerjaan, function ($q) use ($search_pengerjaan) {
                            $q->where('judul', 'like', "%$search_pengerjaan%");
                        })->get()->count(),
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

                    $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                    $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $thumbnail);
                } else {
                    $thumbnail = null;
                }

                if ($request->hasFile('lampiran')) {

                    $lampiran = [];
                    $i = 0;
                    foreach ($request->file('lampiran') as $file) {
                        $file->storeAs('public/proyek/lampiran', sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $file->getClientOriginalName());
                        $lampiran[$i] = $file->getClientOriginalName();
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
                    'data' => [
                        'message' =>  'Tugas/Proyek [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'
                    ]
                ], 400);
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

    public function updateProyek($proyek_id, Request $request)
    {


        $user = auth('api')->user();
        $judul = preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul));
        $before = Project::findOrFail($proyek_id);

        try {

            $cek = Project::where('user_id', $user->id)->where('permalink', $judul)
                ->where('permalink', '!=', $before->permalink)
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

                    $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                    $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $thumbnail);
                } else {
                    $thumbnail = null;
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
                    // 'lampiran' => $lampiran,
                    'pribadi' => $request->jenis == 'privat' ? 1 : 0,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' =>  'Tugas/Proyek [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'
                    ]
                ], 400);
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

    public function deleteProyek($proyek_id)
    {
        $user = auth('api')->user();

        try {
            $cek = Project::where('user_id', $user->id)
                ->where('id', $proyek_id)->first();

            if (!$cek) {


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
                    'data' => [
                        'message' =>  'Tugas/Proyek tidak ditemukan!'
                    ]
                ], 400);
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

    private function imgCheck($data, $column, $path, $ch = 0)
    {
        $dummy_photo = [

            asset('admins/img/avatar/avatar-' . rand(1, 2) . '.png'),
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
