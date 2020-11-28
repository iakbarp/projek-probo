<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Bank;
use App\Model\Kota;
use App\Model\Bio;
use App\Model\Negara;
use App\Model\Skill;
use App\Model\Portofolio;
use App\Model\Provinsi;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class userController extends Controller
{
    public function get()
    {
        try {
            $user = auth('api')->user();
            $user = User::find($user->id);

            // ->makeHidden(['id','user_id'])

            // $user->get_portofolio;
            $user->bio = Bio::where('user_id', $user->id)->first();
            $user->skills = Skill::where('user_id', $user->id)->get()->makeHidden(['user_id', 'created_at', 'updated_at']);
            $user->portofolio = portofolio::where('user_id', $user->id)->orderBy(
                'tahun'
            )->get()->makeHidden(['user_id']);

            $user->makeHidden(['id', 'created_at', 'deleted_at', 'updated_at', 'role']);

            $user->bio = $this->imgCheck($user->bio, 'foto', 'storage/users/foto/');
            $user->portofolio = $this->imgCheck($user->portofolio->toArray(), 'foto', 'storage/users/portofolio/', 1);

            $user->bio->bank = Bank::find($user->bio->bank);
            $user->bio->bank = $user->bio->bank ? $user->bio->bank->nama : null;
            $user->bio->kota = Kota::find($user->bio->kota_id);
            $user->bio->provinsi = $user->bio->kota ? Provinsi::find($user->bio->kota->provinsi_id)->nama : null;
            $user->bio->kota = $user->bio->kota ? $user->bio->kota->nama : null;
            $user->bio->makeHidden(['kota_id', 'id', 'user_id', 'created_at', 'updated_at', 'latar_belakang']);

            return response()->json(
                [
                    'error' => false,
                    'data' => $user
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

    public function negara(Request $r)
    {
        $id = $r->id;
        $q = $r->q;
        try {
            $negara = Negara::select(
                'id',
                'nama',
                DB::raw("if(id='$id',true,false) as selected")
            )
                ->when($q, function ($query) use ($q) {
                    $query->where('nama', 'like', "%$q%");
                })
                ->get()->toArray();

            return response()->json(
                [
                    'error' => false,
                    'data' => $negara,
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

    public function kota(Request $r)
    {
        $id = $r->id;
        $q = $r->q;

        try {
            $negara = Provinsi::select('id', 'nama')->get()->toArray();
            $negara = collect($negara);


            $keyed = $negara->map(function ($item, $i) use ($id, $q) {
                $kota = Kota::select(
                    'id',
                    'nama',
                    DB::raw("if(id='$id',true,false) as selected")
                )->where('provinsi_id', $item['id'])
                    ->when($q, function ($query) use ($q) {
                        $query->where('nama', 'like', "%$q%");
                    })
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

    public function bank(Request $r)
    {
        $id = $r->id;
        $q = $r->q;
        try {
            $Bank = Bank::select(
                'id',
                'nama',
                DB::raw("if(id='$id',true,false) as selected")
            )
                ->when($q, function ($query) use ($q) {
                    $query->where('nama', 'like', "%$q%");
                })
                ->get();

            return response()->json(
                [
                    'error' => false,
                    'data' => $Bank,
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

    public function summary(Request $request)
    {

        $summary = $request->summary;
        $validator = Validator::make($request->all(), [
            'summary' => 'required|string|min:20|max:255',
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
            $bio = auth('api')->user()->get_bio;
            $summary_edit = $bio->summary;

            $bio->update([
                'summary' => $summary
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'summary berhasil ' . ($summary_edit ? 'diubah!' : 'ditambah!'),
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function edit(Request $request)
    {


        try {
            $user = auth('api')->user();
            $bio = $user->get_bio;


            $bio->name = $user->name;
            $bio->email = $user->email;
            $bio->bank = Bank::find($bio->bank, ['id', 'nama', 'kode']);
            $bio->kota_provinsi = Kota::find($bio->kota_id, ['id', 'nama', 'provinsi_id']);
            $bio->kota_provinsi->nama_provinsi = Provinsi::find($bio->kota_provinsi->provinsi_id)->nama;

            $bio->makeHidden(['id', 'user_id', 'latar_belakang', 'created_at', 'updated_at', 'summary', 'kota_id']);
            $bio = $this->imgCheck($bio, 'foto', 'storage/users/foto/');
            $bio->kewarganegaraan = Negara::where('nama', $bio->kewarganegaraan)->first()
                ->makeHidden(['created_at', 'updated_at']);
            //   return response()->json($bio);

            return response()->json([
                'error' => false,
                'data' => $bio
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function update(Request $r)
    {
        $user = auth('api')->user();
        $validator = Validator::make($r->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $user->id,
            'jenis_kelamin' => 'required|string',
            'tgl_lahir' => 'required|date_format:Y-m-d',
            'status' => 'required|max:60',
            'kewarganegaraan' => 'required|exists:negara,nama',
            'hp' => 'required|max:60',
            'alamat' => 'required|max:191',
            'kota_id' => 'nullable|exists:kota,id',
            'bank' => 'required|exists:bank,id',
            'rekening' => 'required|max:191',
            'an' => 'required|max:100',

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
            $user = auth('api')->user();
            $bio = $user->get_bio;

            User::find($user->id)->update($r->only('name', 'email'));
            $bio->update($r->except('name', 'email'));

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'informasi telah diperbarui!'
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function photo(Request $r)
    {
        try {
            $image_64 = $r->photo; //your base64 encoded data
            $user = auth('api')->user();
            $bio = $user->get_bio;

            // $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

            // $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            // $image = str_replace($replace, '', $image_64);

            // $image = str_replace(' ', '+', $image);
            $image = $image_64;
            $extension = 'jpg';

            $kond = (bool) base64_decode($image, true);

            if ($kond) {

                $imageName = $user->id . '_' . str_replace(' ', '-', $user->name) . '_' . now()->format('dHis') . '.' . $extension;

                if ($user->get_bio->foto != '') {
                    Storage::delete('public/users/foto/' . $bio->foto);
                }

                $picture = base64_decode($image);
                // optimize


                Storage::disk('public')->put('users/foto/' . $imageName, $picture);
                $new = 'storage/users/foto/' . $imageName;

                $bio->update([
                    'foto' => $imageName
                ]);
            }

            return response()->json([
                'error' => !(bool)$kond,

                'message' => $kond ? 'foto telah diperbarui!' : 'Harap pilih gambar!',

            ], ($kond ? 201 : 400));
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function skills()
    {


        try {
            $user = auth('api')->user();
            $skills = Skill::where('user_id', $user->id)->get(['id', 'nama', 'tingkatan']);

            return response()->json([
                'error' => false,
                'data' => $skills
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 400);
        }
    }

    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function skills_update(Request $r)
    {
        DB::beginTransaction();


        try {
            $user = auth('api')->user();

            if (!$this->isJson($r->update)) {
                return response()->json([
                    'error' => true,

                    'message' => 'form incompleted!'

                ], 422);
            }

            $data = collect(json_decode($r->update));

            if (!collect($data[0])->has(['id', 'nama', 'tingkatan'])) {
                return response()->json([
                    'error' => true,

                    'message' => 'form incompleted!'

                ], 422);
            }

            $ids = $data->filter(function ($item) {
                return is_numeric($item->id);
            })->pluck('id');



            $skills = Skill::where('user_id', $user->id)
                ->when(count($ids), function ($q) use ($ids) {
                    $q->whereNotIn('id', $ids);
                })
                ->delete();



            foreach ($data as $row) {
                $row->user_id = $user->id;

                $row = collect($row);
                $res = $row->only('nama', 'tingkatan', 'user_id')->toArray();

                if ($row['id'] && $skill = Skill::find($row['id'])) {
                    $skill->update($res);
                } else {
                    Skill::create($res);
                }
            }

            DB::commit();


            return response()->json([
                'error' => false,

                'message' => 'berhasil diperbarui!'

            ]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function portofolio(Request $r)
    {

        $validator = Validator::make($r->all(), [
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1960|max:' . now()->format('Y'),
            'tautan' => 'required',

            'image' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048'
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
            $user = auth('api')->user();

            $foto = $user->id . now()->format('is') . '_' . $r->file('image')->getClientOriginalName();
            $r->file('image')->storeAs('public/users/portofolio', $foto);

            $r->request->add(['user_id' => $user->id]);
            $r->request->add(['foto' => $foto]);

            $port = Portofolio::create($r->only('user_id', 'judul', 'deskripsi', 'tahun', 'tautan', 'foto'));
            DB::commit();

            return response()->json([
                'error' => false,

                'message' => 'Portofolio berhasil dibuat!'

            ]);
        } catch (\Exception $exception) {
            DB::rollback();


            return response()->json([
                'error' => true,

                'message' => $exception->getMessage()

            ], 400);
        }
    }

    public function portofolio_update(Request $r, $id)
    {
        $validator = Validator::make($r->all(), [
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255',
            'tahun' => 'required',
            'tautan' => 'required',

            'image' => 'image|mimes:jpg,jpeg,gif,png|max:2048'
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
            $user = auth('api')->user();
            $port = Portofolio::where('user_id', $user->id)
                ->where('id', $id)
                ->first();

            if ($port) {
                if ($r->hasFile('image')) {
                    if ($port->foto) {
                        Storage::delete('public/users/portofolio/' . $port->foto);
                    }

                    $foto = $user->id . now()->format('is') . '_' . $r->file('image')->getClientOriginalName();
                    $r->file('image')->storeAs('public/users/portofolio', $foto);
                }
                $r->request->add(['foto' => $r->hasFile('image') ? $foto : $port->foto]);


                $port->update($r->only('judul', 'deskripsi', 'tahun', 'tautan', 'foto'));
                DB::commit();
            }

            return response()->json([
                'error' => !((bool) $port),
                'data' => [
                    'message' => ((bool) $port ? 'Portofolio berhasil diubah!' : 'data tidak ditemukan!')
                ]
            ], ($port ? 201 : 400));
        } catch (\Exception $exception) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 400);
        }
    }

    public function portofolio_delete($id)
    {

        DB::beginTransaction();


        try {
            $user = auth('api')->user();
            $port = Portofolio::where('user_id', $user->id)
                ->where('id', $id)
                ->first();

            if ($port) {
                if ($port->foto != '') {
                    Storage::delete('public/users/portofolio/' . $port->foto);
                }


                $port->delete();
                DB::commit();
            }

            return response()->json([
                'error' => !(bool) $port,

                'message' => $port ? 'Portofolio berhasil dihapus!' : 'data tidak ditemukan!'

            ], ($port ? 201 : 400));
        } catch (\Exception $exception) {
            DB::rollback();

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
            asset('images/photo_holder.png'),



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
