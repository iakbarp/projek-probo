<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Bank;
use App\Model\Bio;
use App\Model\Dompet;
use App\Model\DompetHistory;
use App\Model\Saldo;
use App\Model\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Cache;
use Illuminate\Support\Facades\Storage;

class dompetController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            $u = auth('api')->user();
            $user = Bio::where('user_id', $u->id)->first(['foto', 'status', 'summary','bank','an','rekening']);
            $user = $this->imgCheck($user, 'foto', 'users/foto/');
            $user->nama = $u->name;
            $user->bank=Bank::find($user->bank,['id','nama']);


            $history = DompetHistory::
                // where('user_id', $user->id)
                orderBy('created_at', 'desc')

                ->get();
            $data = [];
            foreach ($history as $dt) {
                $data[] = [
                    'id' => $dt->id,
                    'jumlah' => $dt->jumlah,
                    'created_at' => $dt->created_at,
                    'isTopup'=>$dt->isTopup,
                    'status' => $dt->status,
                ];
            }
            $saldo =  Saldo::where('id',$u->id)->first();

            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $user,
                    'set_pin' => Dompet::where('user_id', $u->id)
                        ->whereNotNull('pin')->count(),
                    'history' => $data,
                    'saldo' => $saldo ? $saldo->saldo : 0,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function pinChange(Request $request)
    {
        $user = auth('api')->user();



        $validator = Validator::make($request->all(), [
            'konfirmasi' => 'required|string',
            'pin' => 'required|string|min:6|max:6',
            'pin_repeat' => 'required|string|same:pin|min:6|max:6',

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
            $set_pin = Dompet::where('user_id', $user->id)
                ->whereNotNull('pin')->first();

            if(!Hash::check($request->konfirmasi, ($set_pin ? $set_pin->pin : $user->password))){
                return response()->json([
                    'error' => true,
                    'data'=>[
                    'message' => [
                        'konfirmasi'=>[
                            ($set_pin?'Pin':'Password').' is wrong.',
                        ]
                    ],
                ]]
                , 422);
            }

            $pin = Dompet::updateOrCreate([
               'user_id'   => $user->id,
            ],[
                'pin'=>bcrypt($request->pin),
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Pin berhasil '.($set_pin?'diubah!':'ditambahkan!'),

                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function pinCheck(Request $request)
    {
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|min:6|max:6',
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
            $set_pin = Dompet::where('user_id', $user->id)
                ->whereNotNull('pin')->first();

            if(!Hash::check($request->pin, ($set_pin ? $set_pin->pin : $user->password))){
                return response()->json([
                    'error' => true,
                    'data'=>[
                    'message' => [
                        'pin'=>[
                            ($set_pin?'Pin':'Password').' is wrong.',
                        ]
                    ],
                ]]
                , 422);
            }

            $u = auth('api')->user();
            $user = Bio::where('user_id', $u->id)->first(['foto', 'status', 'summary','bank','an','rekening']);
            $user = $this->imgCheck($user, 'foto', 'users/foto/');
            $user->nama = $u->name;
            $user->bank=Bank::find($user->bank,['id','nama']);

            Cache::put('widthdraw_'.$u->id, true, now()->addSeconds(60));


            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $user,

                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function widthdraw(Request $request)
    {
        $user = auth('api')->user();
        $saldo=Saldo::find($user->id)->saldo;

        $validator = Validator::make($request->all(), [
            'withdraw' => 'required|numeric|max:'.$saldo,
        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => true,
                'data' => [
                    'message' => $validator->errors()
                ]
            ], 422);
        }

        if(!Cache::has('widthdraw_'.$user->id)){
            return response()->json([
                'error' => true,

                    'message' => 'Request Timeout!'

            ], 400);
        }

        try {
            Withdraw::create([
                'user_id'=>$user->id,
                'jumlah'=>$request->withdraw,
            ]);

            return response()->json([
                'error' => false,
                'data' => [
                    'message' => 'Harap tunggu permintaan withdraw dikonfirmasi oleh tim kami...',

                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function viewMidtrans(Request $request)
    {
        $id=auth('api')->user()->id;

        $jumlah=is_numeric($request->jumlah)?$request->jumlah:10000;

        return view('mobile-payment.topup',compact('id','jumlah'));
    }

    private function imgCheck($data, $column, $path, $ch = 0)
    {
        $dummy_photo = [

            asset('admins/img/avatar/avatar-1' . '.png'),
            asset('images/porto.jpg'),
            asset('images/undangan-' . rand(1, 2) . '.jpg'),

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
