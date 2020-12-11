<?php

namespace App\Http\Controllers\API\Users\klien;

use App\Http\Controllers\Controller;
use App\Model\Bio;
use App\Model\Pengerjaan;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class ProyekController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            $q = $request->q;
            $user = auth('api')->user();

            $proyek = Project::where('user_id', $user->id)
                ->where('judul', 'like', "%$q%")->get();

            $bio = Bio::where('user_id', $user->id)->select(['status', 'foto'])->first();
            $bio->nama = $user->name;
            $bio->foto = $this->imgCheck($bio, 'foto', 'storage/users/foto/');

            $Pengerjaan = Pengerjaan::whereIn('proyek_id', $proyek->pluck('id'))
                ->get();

            return response()->json([
                'error' => true,
                'data' => [
                    'proyek' => $proyek,
                    'Pengerjaan' => $Pengerjaan,
                    'proyek_count' => $proyek->count(),
                    'Pengerjaan_count' => $Pengerjaan->count(),
                ]
            ], 400);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
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
                    'kategori'=>'required|exists:subkategori,id',
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
                    $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", $user->id).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
                } else {
                    $thumbnail = null;
                }

                if ($request->hasFile('lampiran')) {

                    $lampiran = [];
                    $i = 0;
                    foreach ($request->file('lampiran') as $file) {
                        $file->storeAs('public/proyek/lampiran', sprintf("%05d", $user->id).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$file->getClientOriginalName());
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
                    'pribadi' => $request->jenis=='privat'?1:0,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' =>  'Tugas/Proyek [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'
                    ]
                ], 400);}
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 400);
        }
    }

    public function updateProyek($proyek_id,Request $request)
    {


        $user = auth('api')->user();
        $judul = preg_replace("![^a-z0-9]+!i", "-", strtolower($request->judul));
        $before=Project::findOrFail($proyek_id);

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
                    'kategori'=>'required|exists:subkategori,id',
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
                    $request->file('thumbnail')->storeAs('public/proyek/thumbnail', sprintf("%05d", $user->id).now()->format('ymds'). sprintf("%02d", rand(0, 99)).'_'.$thumbnail);
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
                    'pribadi' => $request->jenis=='privat'?1:0,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' =>  'Tugas/Proyek [' . $request->judul . '] Anda telah tersedia! Silahkan buat tugas/proyek Anda dengan judul yang berbeda, terimakasih.'
                    ]
                ], 400);}
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
            $cek=Project::where('user_id',$user->id)
            ->where('id',$proyek_id)->first();

            if (!$cek) {


                if ($cek->thumbnail != "") {
                    Storage::delete('public/proyek/thumbnail/' . $cek->thumbnail);
                }

                if ($cek->lampiran != "") {
                    foreach ($cek->lampiran as $item) {
                        Storage::delete('public/proyek/lampiran/' . $item);
                    }
                }

                $name=$cek->judul;
                $cek->delete();

                return response()->json([
                    'error' => false,
                    'data' => [
                        'message' =>"Proyek ['$name'] berhasil dihapus!"
                    ]
                ]);

            } else {
                return response()->json([
                    'error' => true,
                    'data' => [
                        'message' =>  'Tugas/Proyek [' . $name . '] tidak ditemukan!'
                    ]
                ], 400);}
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

            asset('admins/avatar/avatar-' . rand(1, 2) . '.jpg'),
            asset('images/porto.jpg'),



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
        } elseif ($data) {


            $res->{$column} = $res->{$column} && File::exists($path . $res->{$column}) ?
                asset($path . $res->{$column}) :
                $dummy_photo[$ch];
        } else {


            $res->{$column} = $dummy_photo[$ch];
        }

        return $res;
    }
}
