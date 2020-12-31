<?php

namespace App\Http\Controllers\API\Users\Klien;

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


            $pengerjaan = PengerjaanLayanan::query()
                ->join('service as s', function ($rel) use ($q) {
                    $rel->on('s.id', '=', 'pengerjaan_layanan.service_id');

                })
                ->when($q, function ($query) use ($q) {
                    $query->where('s.judul', 'like', "%$q%");
                })
                ->leftJoin('pembayaran_layanan as pl', 'pengerjaan_layanan.id', '=', 'pl.pengerjaan_layanan_id')
                ->where('pengerjaan_layanan.user_id', $user->id)

                ->select(
                    'pengerjaan_layanan.*',
                    DB::raw('s.user_id as user_pekerja'),
                    DB::raw('(pengerjaan_layanan.file_hasil is not null or pengerjaan_layanan.tautan is not null) and pengerjaan_layanan.selesai=0 as ratingable'),
                    's.harga',
                    DB::raw("((pengerjaan_layanan.selesai=1 and pl.bukti_pembayaran is not null) or pl.id is null or pl.bukti_pembayaran is null) deleteable"),
                    DB::raw("ifnull(pl.bukti_pembayaran LIKE '%FP%',false) as isPaidOff")

                )
                ->orderBy('pengerjaan_layanan.id', 'desc')

                // ->limit($limit ?? 8)
                ->get();

            foreach ($pengerjaan as $dt) {
                $file = [];

                if ($dt->file_hasil) {
                    foreach ($dt->file_hasil as $d) {
                        $file[] = $d ? $this->imgCheck($d, null, 'layanan/hasil/', 0) : null;
                    }
                }
                $dt->file_hasil = $file;

                $pembayaran = PembayaranLayanan::where('pengerjaan_layanan_id', $dt->id)->first();

                $gabung = true;
                if ($pembayaran) {
                    if (is_numeric(strpos($pembayaran->bukti_pembayaran, 'DP'))) {
                        $dt->status = ' (DP ' . round($pembayaran->jumlah_pembayaran * 100 / $dt->harga) . '%)';
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
                        $dt->status = 'Pengerjaan' . $dt->status;
                    }
                }

                $layanan = Services::query()
                    ->where('service.id', $dt->service_id)

                    ->select(
                        'service.*',
                        // DB::raw('sub.nama as subkategori_nama'),
                        // 'sub.kategori_id',
                        // DB::raw('kat.nama as kategori_nama'),
                        DB::raw('ifnull((select count(id) from pengerjaan_layanan where
                            service.id=pengerjaan_layanan.service_id
                            and pengerjaan_layanan.selesai=1
                            ),0) as `jumlah_klien`
                            ')

                    )->first();

                if ($layanan) {
                    $sub = SubKategori::where('id', $layanan->subkategori_id)->first(['nama', 'id', 'kategori_id']);
                    if ($sub) {
                        $kat = Kategori::where('id', $sub->kategori_id)->first(['nama', 'id']);
                        unset($sub->kategori_id);

                        $layanan->kategori = $kat;
                        $layanan->subkategori = $sub;
                    }
                    $layanan = $layanan ? $this->imgCheck($layanan, 'thumbnail', 'layanan/thumbnail/', 2) : null;

                    unset($layanan->subkategori_id);
                }

                $dt->layanan = $layanan;

                $dt->pekerja = Bio::query()
                    ->where('user_id', $dt->user_pekerja)
                    ->join('users as u', 'u.id', '=', 'bio.user_id')
                    ->first(['u.id', DB::raw('u.name as nama'), 'foto', 'summary',
                    DB::raw('format(AVG((total_bintang_pekerja+total_bintang_klien)/2),1) as bintang')]);
                if ($dt->pekerja) {
                    $dt->pekerja = $this->imgCheck($dt->pekerja, 'foto', 'users/foto');
                }

                $dt->ulasan = User::query()
                    ->where('users.id', $user->id)
                    ->join('bio', 'bio.user_id', '=', 'users.id')
                    ->leftJoin('ulasan_service as u', function ($query) use ($dt) {
                        $query->on('u.user_id', '=', 'users.id');
                        $query->where('u.pengerjaan_layanan_id', '=', DB::raw($dt->id));
                    })
                    ->select(
                        'users.id',
                        DB::raw('name as nama'),
                        'bio.foto',
                        DB::raw('format(u.bintang,1) as bintang'),
                        'u.deskripsi'
                    )
                    ->orderBy('u.id', 'desc')
                    ->first();

                if ($dt->ulasan) {
                    $dt->ulasan = $this->imgCheck($dt->ulasan, 'foto', 'users/foto');
                }

                unset($dt->user_id, $dt->user_pekerja, $dt->selesai,$dt->harga);
            }

            $bio = Bio::where('user_id', $user->id)->first(['status', 'foto']);
            $bio->id = $user->id;
            $bio->nama = $user->name;
            $bio = $this->imgCheck($bio, 'foto', 'users/foto');

            return response()->json([
                'error' => false,

                'data' => [
                    'bio' => $bio,

                    'pengerjaan' => $pengerjaan,

                    'count_pengerjaan' => collect($pengerjaan)->count(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteOrder($id)
    {
        $user = auth('api')->user();

        try {

            $cek = PengerjaanLayanan::query()
                ->leftJoin('pembayaran_layanan as pl', 'pengerjaan_layanan.id', '=', 'pl.pengerjaan_layanan_id')
                ->where('pengerjaan_layanan.user_id', $user->id)
                ->where('pengerjaan_layanan.id', $id)
                ->where(function ($q) {
                    $q->where('pengerjaan_layanan.selesai', 1);
                    $q->orWhere(function ($query) {
                        $query->whereNull('pl.id');
                        $query->orWhereNull('pl.bukti_pembayaran');
                    });
                })
                ->select('pengerjaan_layanan.*')
                ->first();

            if ($cek) {
                $nama = Services::findOrFail($cek->service_id);
                $cek->delete();
                return response()->json([
                    'error' => false,
                    'data' => [
                        'message' =>  'Pesanan layanan [' . $nama->judul . '] berhasil dihapus!',
                    ]
                ], 201);
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

    public function komenLayanan($id, Request $request)
    {
        $user = auth('api')->user();

        DB::beginTransaction();
        $cek = PengerjaanLayanan::query()
            ->where('pengerjaan_layanan.user_id', $user->id)
            ->where('pengerjaan_layanan.id', $id)
            ->where('pengerjaan_layanan.selesai', 0)
            ->where(function ($q) {
                $q->whereNotNull('pengerjaan_layanan.file_hasil');
                $q->orWhereNotNull('pengerjaan_layanan.tautan');
            })
            ->select('pengerjaan_layanan.*')
            ->first();

        $validator = Validator::make($request->all(), [
            'bintang' => 'required|numeric|max:5|min:0',
            'deskripsi' => 'required|string|max:100',
            'puas' => 'in:0,1'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $validator->errors()
                ]
            ], 422);
        }

        try {

            if ($cek) {


                $nama = Services::findOrFail($cek->service_id);

                UlasanService::create([
                    'pengerjaan_layanan_id' => $id,
                    'user_id' => $user->id,
                    'bintang' => $request->bintang,
                    'deskripsi' => $request->deskripsi,
                ]);

                if($request->puas){
                    $cek->update([
                        'selesai'=>true,
                    ]);
                }


                DB::commit();

                return response()->json([
                    'error' => false,
                    'data' => [
                        'message' =>  'Ulasan layanan [' . $nama->judul . '] berhasil ditambah!',
                    ]
                ], 201);
            } else {
                DB::rollback();

                return response()->json([
                    'error' => true,
                    'message' =>  'Layanan tidak ditemukan!'

                ], 400);
            }
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
            asset('images/undangan-1'  . '.jpg'),

        ];
        $res = $data;

        if (is_array($data)) {

            $res = [];

            foreach ($data as $i => $row) {
                $res[$i] = $row;

                $res[$i][$column] = $res[$i][$column] && Storage::disk('public')->exists($path . $res[$i][$column]) ?
                    asset($path . $res[$i][$column]) :
                    $dummy_photo[$ch];
            }
        } elseif (is_object($data)) {


            $res->{$column} = $res->{$column} && Storage::disk('public')->exists($path . $res->{$column}) ?
                asset($path . $res->{$column}) :
                $dummy_photo[$ch];
        } else {


            $res = Storage::disk('public')->exists($path . $res) ?
                asset($path . $res) : $dummy_photo[$ch];
        }

        return $res;
    }
}
