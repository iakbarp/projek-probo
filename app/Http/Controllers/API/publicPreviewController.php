<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Bid;
use App\Model\Bio;
use App\Model\Kategori;
use App\Model\PengerjaanLayanan;
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
                ->whereNull('bid.id')

                ->leftJoin('bid', function ($joins) {
                    $joins->on('bid.proyek_id', '=', 'project.id');
                    $joins->on('bid.tolak', '=', DB::raw('0'));
                })
                ->where('pribadi', false)
                ->where('project.user_id', $user->id)
                ->groupBy( 'project.id','bid.proyek_id')

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
                    DB::raw("format(ulasan_klien.bintang,1) as bintang"),
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

                    DB::raw("format(ulasan_pekerja.bintang,1) as bintang"),

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

                    DB::raw("format(ulasan_service.bintang,1) as bintang"),

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

                ->where('pribadi', false)
                ->where('project.user_id', $user->id)
                ->whereNull('bid.id')

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
                ->groupBy( 'project.id','bid.proyek_id')

                ->orderBy('project.updated_at', 'desc')
                ->get();


            if ($proyek) {
                $proyek = $this->get_kategori_img($proyek, 'storage/proyek/thumbnail/');

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

    public function getProyek(Request $request)
    {
        try {
            $id = $request->id;

            $proyek = Project::findOrFail($id);

            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $proyek->user_id && $id) {
                $its_me = false;
                $user = User::findOrFail($proyek->user_id);
            }

            $bio = $this->getBio($user);
            $proyek = Project::select('project.id')


                ->leftJoin('bid', function ($joins) {
                    $joins->on('bid.proyek_id', '=', 'project.id');
                    $joins->on('bid.tolak', '=', DB::raw('0'));
                })
                // ->whereRaw('')

                ->where(function ($query) use ($id) {
                    $query->where('pribadi', false);
                    $query->where('project.id', $id);
                    $query->whereNull('bid.id');
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
                    DB::raw("(SELECT ifnull(count(id),0) FROM bid where bid.proyek_id=project.id) total_bid"),
                    "thumbnail",
                    "lampiran",

                )
                ->orderBy('project.updated_at', 'desc')
                // ->groupBy('project.id','bid.proyek_id')
                ->firstOrFail();



            if ($proyek) {
                $proyek = $this->get_kategori_img_obj($proyek,'storage/proyek/thumbnail/');
            // $proyek = $proyek ? $this->imgCheck($proyek, 'thumbnail', 'storage/proyek/thumbnail/', 0) : [];



                $lamp = [];
                if ($proyek->lampiran) {
                    foreach ($proyek->lampiran as $row) {
                        $lamp[] = $this->imgCheck($row, null, 'storage/proyek/thumbnail/', 2);
                    }
                }
                $proyek->lampiran = $lamp;

                unset($proyek->subkategori_id,
                $proyek->subkategori_nama,
                $proyek->kategori_id,
                $proyek->kategori_nama,);
            }

            $bid = Bid::where('proyek_id', $proyek->id)
                ->join('users as u', function ($joins) {
                    $joins->on('bid.user_id', '=', 'u.id');
                })
                ->join('bio as b', function ($joins) {
                    $joins->on('bid.user_id', '=', 'b.id');
                })
                ->whereNotNull('u.id')
                ->orderBy('bid.id', 'desc')
                ->select(  'u.id', DB::raw("u.name as nama"), "b.foto", 'negoharga', 'negowaktu', 'task',
                DB::raw("format(AVG((total_bintang_pekerja+total_bintang_klien)/2),1) as bintang"),)
                ->get()->toArray();
                if($bid[0]['id']==null){
                    $bid=[];
                }
                
                $bid = $this->imgCheck($bid, 'foto', 'storage/users/foto/', 0);
                
            $proyek->bid = $bid;




            return response()->json([
                'error' => false,
                'data' => [

                    'user' => $bio,

                    'proyek' => $proyek,
                    'already_bid' => Bid::query()->where('user_id', $user->id)->where('proyek_id', $proyek->id)->first() ? true : false,
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

    public function getLayanan(Request $request)
    {
        try {
            $id = $request->id;



            $layanan = Project::findOrFail($id);

            $user = auth('api')->user();
            $its_me = true;

            if ($user->id != $layanan->user_id && $id) {
                $its_me = false;
                $user = User::findOrFail($layanan->user_id);
            }
            $bio = $this->getBio($user);
            $layanan = Services::query()
                ->select(
                    'service.*',
                    DB::raw('ifnull((select count(id) from pengerjaan_layanan where
            service.id=pengerjaan_layanan.service_id
            and pengerjaan_layanan.selesai=1
            ),0) as `jumlah_klien`

            ')

                )
                ->where('id', $id)
                // ->offset($offset ?? 0)
                ->orderBy('updated_at', 'desc')


                ->firstOrFail();


            $layanan = $this->get_kategori_img_obj($layanan,'storage/layanan/thumbnail/');

            $ulasan = PengerjaanLayanan::query()
                ->where('service_id', $layanan->id)
                ->where('selesai', true)
                ->join('ulasan_service as u', 'u.pengerjaan_layanan_id', '=', 'pengerjaan_layanan.id')
                ->join('users as s', 's.id', '=', 'u.user_id')
                ->join('bio as b', 's.id', '=', 'u.user_id')
                ->select('s.id',
                DB::raw('s.name as nama'),
                'b.foto',
                DB::raw('format(bintang,1) as bintang'),
                'u.deskripsi'
                )
                ->groupBy('u.id')
                ->get();
                $ulasan = $this->imgCheck($ulasan->toArray(), 'foto', 'storage/users/foto/', 0);

            $layanan->ulasan=$ulasan;



            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $bio,
                    'layanan' => $layanan,
                    'already_take' => PengerjaanLayanan::where('user_id', $user->id)
                        ->where('service_id', $layanan->id)
                        ->where('selesai', false)
                        ->get()->count() ? true : false,
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


            $layanan = $this->get_kategori_img($layanan, 'storage/layanan/thumbnail/');


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

    private function get_kategori_img($res,$loc)
    {
        foreach ($res as $dt) {
            $dt->subkategori = SubKategori::where('id', $dt->subkategori_id)->first(['id', 'nama', 'kategori_id']);
            if ($sub = $dt->subkategori) {
                $dt->kategori = Kategori::where('id', $sub->kategori_id)->first(['id', 'nama']);
            }
            $dt = $this->imgCheck($dt, 'thumbnail',$loc, 2);
            unset($dt->subkategori->kategori_id);
        }


        return $res;
    }

    private function get_kategori_img_obj($dt,$loc)
    {


        $dt->subkategori = SubKategori::where('id', $dt->subkategori_id)->first(['id', 'nama', 'kategori_id']);
        if ($sub = $dt->subkategori) {
            $dt->kategori = Kategori::where('id', $sub->kategori_id)->first(['id', 'nama']);
        }
        $dt = $this->imgCheck($dt, 'thumbnail', $loc, 2);
        unset($dt->subkategori->kategori_id);



        return $dt;
    }

    private function imgCheck($data, $column, $path, $ch = 0)
    {
        $dummy_photo = [

            asset('admins/img/avatar/avatar-' . rand(1, 2) . '.png'),
            asset('images/porto.jpg'),
            asset('images/undangan-' . rand(1, 2) . '.jpg'),

        ];
        $res = $data;

        if (is_array($data) &&$column) {

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
