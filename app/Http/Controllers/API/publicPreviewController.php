<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Bio;
use App\Model\Kategori;
use App\Model\Portofolio;
use App\Model\Project;
use App\Model\Review;
use App\Model\ReviewWorker;
use App\Model\Services;
use App\Model\Skill;
use App\Model\SubKategori;
use App\Model\UlasanService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class publicPreviewController extends Controller
{
    public function get(Request $request)
    {
        try {
            $id = $request->id;
            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $id && $id) {
                $its_me = false;
                $user = User::findOrFail($id);
            }

            $bio = $this->getBio($user);
            $layanan = Services::where('user_id', $user->id)->get()->count();
            $proyek = Project::query()
                ->select('project.id')
                ->join('pengerjaan as p', function ($join) use ($user) {
                    $join->on('p.proyek_id', '=', 'project.id');
                    $join->on('p.user_id', '=', DB::raw($user->id));
                })
                ->where('pribadi', false)
                ->groupBy('project.id', 'p.proyek_id')
                ->get()->count();

            $port = Portofolio::where('user_id', $user->id)->get()->count();

            $ulasan_klien = Review::whereHas('get_project', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get()->count();
            $ulasan_pekerja = ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get()->count();
            $ulasan_service = UlasanService::query()

                ->join('pengerjaan_layanan as pl', function ($joins) {
                    $joins->on('ulasan_service.pengerjaan_layanan_id', '=', 'pl.id');
                })
                ->join('service as sc', function ($joins) use ($user) {
                    $joins->on('sc.id', '=', 'pl.service_id');
                    $joins->on('sc.user_id', '=', DB::raw($user->id));
                })
                ->select(
                    "ulasan_service.id",

                )
                ->get()->count();






            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $bio,
                    'jumlah_layanan' => $layanan,
                    'jumlah_proyek' => $proyek,
                    'jumlah_portfolio' => $port,
                    'jumlah_ulasan' => $ulasan_pekerja + $ulasan_klien + $ulasan_service,
                    'its_me' => $its_me,
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function ulasan(Request $request)
    {
        try {
            $id = $request->id;
            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $id && $id) {
                $its_me = false;
                $user = User::findOrFail($id);
            }

            $bio = $this->getBio($user);

            $ulasan_klien = Review::whereHas('get_project', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
                ->leftJoin('users as u', function ($joins) {
                    $joins->on('ulasan_klien.user_id', '=', 'u.id');
                })
                ->leftJoin('bio as b', function ($joins) {
                    $joins->on('ulasan_klien.user_id', '=', 'b.id');
                })
                ->select(
                    "ulasan_klien.id",
                    DB::raw("u.name as nama"),
                    DB::raw("'Klien' as ulasan"),

                    "b.foto",
                    "ulasan_klien.deskripsi",
                    "ulasan_klien.bintang",
                    "ulasan_klien.created_at",

                )
                ->get();

            $ulasan_klien = $this->imgCheck($ulasan_klien->toArray(), 'foto', 'storage/users/foto/');
            $ulasan_klien = collect($ulasan_klien);

            $ulasan_pekerja = ReviewWorker::whereHas('get_pengerjaan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
                ->leftJoin('users as u', function ($joins) {
                    $joins->on('ulasan_pekerja.user_id', '=', 'u.id');
                })
                ->leftJoin('bio as b', function ($joins) {
                    $joins->on('ulasan_pekerja.user_id', '=', 'b.id');
                })
                ->select(
                    "ulasan_pekerja.id",
                    DB::raw("u.name as nama"),
                    DB::raw("'Pekerja' as ulasan"),
                    "b.foto",
                    "ulasan_pekerja.deskripsi",
                    "ulasan_pekerja.bintang",
                    "ulasan_pekerja.created_at",

                )
                ->get();
            $ulasan_pekerja = $this->imgCheck($ulasan_pekerja->toArray(), 'foto', 'storage/users/foto/');
            $ulasan_pekerja = collect($ulasan_pekerja);
            $ulasan_service = UlasanService::query()
                ->leftJoin('users as u', function ($joins) {
                    $joins->on('ulasan_service.user_id', '=', 'u.id');
                })
                ->leftJoin('bio as b', function ($joins) {
                    $joins->on('ulasan_service.user_id', '=', 'b.id');
                })
                ->join('pengerjaan_layanan as pl', function ($joins) {
                    $joins->on('ulasan_service.pengerjaan_layanan_id', '=', 'pl.id');
                })
                ->join('service as sc', function ($joins) use ($user) {
                    $joins->on('sc.id', '=', 'pl.service_id');
                    $joins->on('sc.user_id', '=', DB::raw($user->id));
                })
                ->select(
                    "ulasan_service.id",
                    DB::raw("u.name as nama"),
                    DB::raw("'Layanan' as ulasan"),

                    "b.foto",
                    "ulasan_service.deskripsi",
                    "ulasan_service.bintang",
                    "ulasan_service.created_at",
                )
                ->get();
            $ulasan_service = $this->imgCheck($ulasan_service->toArray(), 'foto', 'storage/users/foto/');
            $ulasan_service = collect($ulasan_service);
            // dd($ulasan_service);

            $ulasan_pekerja->merge($ulasan_klien);
            $ulasan_pekerja = collect($ulasan_pekerja->all())->merge($ulasan_service);
            $ulasan_pekerja = collect($ulasan_pekerja->all())->sortByDesc('created_at');
            $data = [];
            foreach ($ulasan_pekerja->all() as $row) {
                $data[] = $row;
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $bio,
                    'ulasan' => $data,

                    'its_me' => $its_me,
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function portfolio(Request $request)
    {
        try {
            $id = $request->id;
            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $id && $id) {
                $its_me = false;
                $user = User::findOrFail($id);
            }

            $bio = $this->getBio($user);

            $port = portofolio::orderBy(
                'tahun',
                'desc'
            )->get()->makeHidden(['user_id']);
            // $port=$this->imgCheck($port->toArray(), 'foto', 'storage/users/portfolio/', 1);

            $port = $this->imgCheck($port->toArray(), 'foto', 'storage/users/portofolio/');



            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $bio,
                    'portfolio' => $port,
                    'its_me' => $its_me,
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function proyek(Request $request)
    {
        try {
            $id = $request->id;
            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $id && $id) {
                $its_me = false;
                $user = User::findOrFail($id);
            }

            $bio = $this->getBio($user);
            $proyek = Project::select('project.id')
                ->join('pengerjaan as p', function ($join) use ($user) {
                    $join->on('p.proyek_id', '=', 'project.id');
                    $join->on('p.user_id', '=', DB::raw($user->id));
                })
                ->where('pribadi', false)
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

                )
                ->orderBy('project.updated_at', 'desc')
                ->get();


            if ($proyek) {
                $proyek = $this->get_kategori_img($proyek);

                foreach ($proyek as $dt) {
                    $lamp = [];

                    if ($dt->lampiran) {
                        foreach ($dt->lampiran as $row) {
                            $lamp[] = $this->imgCheck($row, null, 'storage/proyek/lampiran/', 2);
                        }
                    }
                    $dt->lampiran = $lamp;

                    unset($dt->subkategori_id,
                    $dt->subkategori_nama,
                    $dt->kategori_id,
                    $dt->kategori_nama,);
                }
            }




            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $bio,

                    'proyek' => $proyek,
                    'its_me' => $its_me,
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function layanan(Request $request)
    {
        try {
            $id = $request->id;
            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $id && $id) {
                $its_me = false;
                $user = User::findOrFail($id);
            }

            $bio = $this->getBio($user);
            $layanan = DB::table('service')
                ->select(
                    'service.*',
                    DB::raw('ifnull((select count(id) from pengerjaan_layanan where
            service.id=pengerjaan_layanan.service_id
            and pengerjaan_layanan.selesai=1
            ),0) as `jumlah_klien`

            ')

                )
                ->where('user_id', $user->id)
                // ->offset($offset ?? 0)
                ->orderBy('updated_at', 'desc')


                ->get();


            $layanan = $this->get_kategori_img($layanan);


            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $bio,
                    'layanan' => $layanan,

                    'its_me' => $its_me,
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    private function getBio($user)
    {


        $bio = Bio::query()
            ->leftJoin('kota as kt', 'kt.id', '=', 'bio.kota_id')
            ->leftJoin('bank as b', 'b.id', '=', 'bio.bank')
            ->where('bio.user_id', $user->id)->select(

                'alamat',
                'foto',
                'tgl_lahir',
                'jenis_kelamin',
                'kewarganegaraan',
                'kt.nama as kota',
                'summary',
                'website',
                'rekening',
                DB::raw("ifnull(b.nama,'-') as bank"),
                DB::raw("format(AVG((total_bintang_pekerja+total_bintang_klien)/2),1) as bintang"),
                'bio.created_at',
                'bio.updated_at'
            )
            ->groupBy('bio.user_id',  'kt.id')
            ->first();
        $bio = $this->imgCheck($bio, 'foto', 'storage/users/foto/', 0);

        $bio->nama = $user->name;
        $bio->id = $user->id;
        $bio->email = $user->email;
        $bio->skill = Skill::where('user_id', $user->id)->get(['nama', 'tingkatan']);
        return $bio;
    }

    private function get_kategori_img($res)
    {
        if ($res) {
            foreach ($res as $dt) {
                $dt->subkategori = SubKategori::where('id', $dt->subkategori_id)->first(['id', 'nama', 'kategori_id']);
                if ($sub = $dt->subkategori) {
                    $dt->kategori = Kategori::where('id', $sub->kategori_id)->first(['id', 'nama']);
                }
                $dt = $this->imgCheck($dt, 'thumbnail', 'storage/layanan/thumbnail/', 2);
                unset($dt->subkategori->kategori_id);
            }
        }

        return $res;
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

        return $res ? $res : [];
    }
}
