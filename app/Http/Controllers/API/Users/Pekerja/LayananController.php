<?php

namespace App\Http\Controllers\API\Users\Pekerja;


use App\Http\Controllers\Controller;
use App\Model\Bio;
use App\Model\Kategori;
use App\Model\PembayaranLayanan;
use App\Model\PengerjaanLayanan;
use App\Model\Services;
use App\Model\SubKategori;
use App\Model\UlasanService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    public function dashboard(Request $request)
    {

        try {
            $offset = $request->offset;
            $limit = $request->limit;
            $q = $request->q;
            $user = auth('api')->user();


            $layanan = Services::query()
                ->where('service.user_id', $user->id)
                ->join('subkategori as sub', 'sub.id', '=', 'service.subkategori_id')
                // ->join('kategori as kat', 'sub.kategori_id', '=', 'kat.id')
                ->leftJoin('pengerjaan_layanan as pl', function ($rel) {
                    $rel->on('pl.service_id', '=', 'service.id');
                    $rel->on('pl.selesai', '!=', DB::raw(1));
                })
                ->select(
                    'service.*',
                    // DB::raw('sub.nama as subkategori_nama'),
                    // 'sub.kategori_id',
                    // DB::raw('kat.nama as kategori_nama'),
                    DB::raw('if(pl.id is null, true,false) can_delete'),
                    DB::raw('ifnull((select count(id) from pengerjaan_layanan where
                service.id=pengerjaan_layanan.service_id
                and pengerjaan_layanan.selesai=1
                ),0) as `jumlah_klien`
                ')

                )
                ->when($q, function ($query) use ($q) {
                    $query->where('service.judul', 'like', "%$q%");
                })
                ->orderBy('service.id', 'desc')


                ->groupBy('service.id', 'pl.service_id')

                // ->offset($offset ?? 0)
                ->limit($limit ?? 8)

                ->get();

            $pengerjaan = PengerjaanLayanan::query()
                ->join('service as s', function ($rel) use ($user) {
                    $rel->on('s.id', '=', 'pengerjaan_layanan.service_id');
                    $rel->on('s.user_id', '=', DB::raw($user->id));
                })
                ->join('users as u', 'u.id', '=', 'pengerjaan_layanan.user_id')
                ->select('pengerjaan_layanan.*')
                ->orderBy('pengerjaan_layanan.id', 'desc')

                ->limit($limit ?? 8)
                ->get();
            foreach ($layanan as $dt) {
                $sub = SubKategori::where('id', $dt->subkategori_id)->first(['nama', 'id', 'kategori_id']);
                if ($sub) {
                    $kat = Kategori::where('id', $sub->kategori_id)->first(['nama', 'id']);
                    unset($sub->kategori_id);

                    $dt->kategori = $kat;
                    $dt->subkategori = $sub;
                }
                $dt = $dt ? $this->imgCheck($dt, 'thumbnail', 'layanan/thumbnail/', 2) : [];

                unset($dt->subkategori_id);
            }

            foreach ($pengerjaan as $dt) {
                $file = [];

                if ($dt->file_hasil) {
                    foreach ($dt->file_hasil as $d) {
                        $file[] = $d ? $this->imgCheck($d, null, 'layanan/hasil/', 2) : [];
                    }
                }


                $ulasan = UlasanService::query()
                    ->where('pengerjaan_layanan_id', $dt->id)
                    ->where('ulasan_service.user_id', $dt->user_id)
                    ->leftJoin('bio', 'bio.user_id', '=', 'ulasan_service.user_id')
                    ->leftJoin('users as u', 'u.id', '=', 'ulasan_service.user_id')
                    ->select(
                        'u.id',
                        DB::raw('u.name as nama'),
                        'bio.foto',
                        'ulasan_service.deskripsi',
                        DB::raw("format(ulasan_service.bintang,1) as bintang")
                    )
                    ->orderBy('ulasan_service.id','desc')
                    ->first();

                if (!$ulasan) {
                    $ulasan = User::query()
                        ->where('users.id', $dt->user_id)
                        ->leftJoin('bio', 'bio.user_id', '=', 'users.id')
                        ->select(
                            'users.id',
                            DB::raw('name as nama'),
                            'foto',
                            DB::raw('null as bintang'),
                            DB::raw('null as deskripsi')
                        )
                        ->first();
                }
                $ulasan = $this->imgCheck($ulasan, 'foto', 'users/foto/');

                $dt->ulasan = $ulasan;

                $dt->file_hasil = $file;
                $dt->layanan = collect($layanan)->where('id', $dt->service_id)->first();

                $pembayaran = PembayaranLayanan::where('pengerjaan_layanan_id', $dt->id)->first();

                $gabung = true;
                $dt->progressable=0;
                if ($pembayaran) {
                    if (is_numeric(strpos($pembayaran->bukti_pembayaran, 'DP'))) {
                        $dt->status = ' (DP ' . round($pembayaran->jumlah_pembayaran * 100 / $dt->layanan->harga) . '%)';
                    } elseif ((is_numeric(strpos($pembayaran->bukti_pembayaran, 'FP')))) {
                        $dt->status = ' (Lunas)';
                    } else {
                        $gabung = false;

                        $dt->status = 'Menunggu Pembayaran';
                    }
                } else {
                    $gabung = false;
                    $dt->status = 'Menunggu Pembayaran';
                }

                if ($gabung) {
                    if ($dt->selesai) {
                        $dt->status = 'Selesai' . $dt->status;
                    } else {
                        $dt->progressable=1;

                        $dt->status = 'Pengerjaan' . $dt->status;
                    }
                }
            }


            $bio = Bio::where('user_id', $user->id)
                ->select(
                    DB::raw('user_id as id'),
                    DB::raw("format(AVG((total_bintang_pekerja+total_bintang_klien)/2),1) as bintang"),
                    'foto',
                    'summary'
                )
                ->first();
            $bio->nama = $user->name;
            $bio = $this->imgCheck($bio, 'foto', 'users/foto/');

            return response()->json([
                'error' => false,

                'data' => [
                    'bio' => $bio,
                    'layanan' => $layanan,
                    'pengerjaan' => $pengerjaan,

                    'count_layanan' => collect($layanan)->count(),
                    'count_pengerjaan' => collect($pengerjaan)->count(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function tambahLayanan(Request $request)
    {
        $user = auth('api')->user();
        $judul = preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul));

        try {

            $cek = Services::where('user_id', $user->id)->where('permalink', $judul)->first();

            if (!$cek) {

                $validator = Validator::make($request->all(), [
                    'judul' => 'required|string|max:100',
                    'pengerjaan' => 'required|integer',
                    'harga' => 'required|integer',
                    'deskripsi' => 'required|string|max:250',
                    'kategori' => 'required|exists:subkategori,id',
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

                $request->request->add(['permalink' => $judul]);

                if ($request->hasFile('thumbnail')) {

                    $thumbnail =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $request->file('thumbnail')->getClientOriginalName();
                    $request->file('thumbnail')->storeAs('public/layanan/thumbnail', $thumbnail);
                } else {
                    $thumbnail = null;
                }

                $request->request->add(['thumbnail' => $thumbnail]);



                Services::create([
                    'judul' => $request->judul,
                    'permalink'=>$judul,
                    'hari_pengerjaan' => $request->pengerjaan,
                    'harga' => $request->harga,
                    'deskripsi' => $request->deskripsi,
                    'subkategori_id' => $request->kategori,
                    'thumbnail' => $thumbnail,
                    'user_id' => $user->id,

                ]);

                return response()->json([
                    'error' => false,

                    'message' =>  'Layanan [' . $request->judul . '] Berhasil dibuat...'

                ], 201);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Layanan [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function updateLayanan(Request $request)
    {


        $user = auth('api')->user();
        $judul = preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul));

        try {
            $before = Services::query()->findOrFail($request->proyek_id);


            $cek = Services::where('user_id', $user->id)->where('permalink', $judul)
                ->where('permalink', '!=', $before->permalink)
                // ->where('')
                ->first();


            if (!$cek) {

                $validator = Validator::make($request->all(), [
                    'judul' => 'required|string|max:100',
                    'jenis' => 'required|in:privat,publik',
                    'pengerjaan' => 'required|integer',
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
                    Storage::delete('public/layanan/thumbnail/' . $before->thumbnail);

                    $thumbnail = sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . $request->file('thumbnail')->getClientOriginalName();
                    $request->file('thumbnail')->storeAs('public/layanan/thumbnail', $thumbnail);
                } else {
                    $thumbnail = $before->thumbnail;
                }



                $before->update([
                    'user_id' => $user->id,
                    'subkategori_id' => $request->kategori,
                    'judul' => $request->judul,
                    'permalink' =>  $judul,
                    'deskripsi' => $request->deskripsi,
                    'hari_pengerjaan' => $request->pengerjaan,
                    'harga' =>  $request->harga,
                    'thumbnail' => $thumbnail,
                    // 'lampiran' => $lampiran,

                ]);
                return response()->json([
                    'error' => false,
                    "data" => ['message' => 'berhasil diubah!']

                ]);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Layanan [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 500);
        }
    }

    public function deleteLayanan($proyek_id)
    {
        $user = auth('api')->user();

        try {
            $cek = Services::where('user_id', $user->id)
                ->where('id', $proyek_id)->first();

            if ($cek) {


                if ($cek->thumbnail != "") {
                    Storage::delete('public/layanan/thumbnail/' . $cek->thumbnail);
                }



                $name = $cek->judul;
                $cek->delete();

                return response()->json([
                    'error' => false,
                    'data' => [
                        'message' => "Layanan ['$name'] berhasil dihapus!"
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => true,

                    'message' =>  'Layanan tidak ditemukan!'

                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function fileFinal($pengerjaan_id,Request $request)
    {
        $user = auth('api')->user();
        // $pengerjaan_id = $request->pengerjaan_id;
        

        $validator = Validator::make($request->all(), [
            'tautan' => 'required|string',
            'file_hasil' => 'required|array',
            'file_hasil.*' => 'mimes:jpg,jpeg,png|max:2048',
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
           $pengerjaan=PengerjaanLayanan::query()
           ->where('pengerjaan_layanan.id',$pengerjaan_id)
           ->join('service as s','s.id','pengerjaan_layanan.service_id')
           ->select('pengerjaan_layanan.*','s.judul')
           ->firstOrFail();

           if ($request->hasFile('file_hasil')) {

                $file_hasil = [];
                $i = 0;
                foreach ($request->file('file_hasil') as $file) {
                    $file_hasil[$i] =  sprintf("%05d", $user->id) . now()->format('ymds') . sprintf("%02d", rand(0, 99)) . '_' . 
                    $file->getClientOriginalName();

                    $file->storeAs('public/layanan/hasil',  $file_hasil[$i]);
                    $i = 1 + $i;
                }
            } else {
                $file_hasil = null;
            }

            PengerjaanLayanan::find($pengerjaan->id)->update([
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

            asset('admins/img/avatar/avatar-1'  . '.png'),
            asset('images/porto.jpg'),
            asset('images/undangan-1' .'.jpg'),

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
