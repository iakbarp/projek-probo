<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Auth\ActivationMail;
use App\Model\Bio;
// use App\Models\Bio;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        try {
            $isEmail = false;
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $isEmail = true;
            }
            $user = User::when($isEmail, function ($q) use ($request) {
                $q->where('email', $request->email);
            })
                ->when(!$isEmail, function ($q) use ($request) {
                    $q->where('username', $request->email);
                })
                ->firstOrFail();

            $user->password = $request->password;
            $credentials = $user->only('email', 'password');


            // if ($user->status != 0) {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 404);
            }
            // } else {
            //     return response()->json(['error' => 'Silahkan aktivasi akun anda'], 400);
            // }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:60|unique:users',
            'username' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'data' => [
                    'message' =>json_decode( $validator->errors()->toJson())
                ]
            ], 422);
        }

        try {

            $data = $request->toArray();

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 'other'
            ]);

            Bio::create([
                'user_id' => $user->id,

            ]);

            $token = JWTAuth::fromUser($user);
            DB::commit();


            return response()->json(['error' => false, 'data' => compact('user', 'token')], 201);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => true, 'data' => ['message' => $e]], 500);
        }
    }


    public function check_email(Request $request)
    {
        $res = [
            'error' => true,
        ];
        $status = 404;
        $v = "/[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";

        try {
            if ($request->has('email')) {

                $email = $request->email;
                $jumlahUser = User::where('email', $email)->count();
                if (!(bool)preg_match($v, $email)) {
                    $res['data'] = ['message' => 'gunakan email yang valid'];
                } elseif ($jumlahUser) {

                    $res['data'] = ['message' => 'email sudah digunakan'];
                } else {
                    $res['error'] = false;
                    $res['data'] = ['message' => 'email dapat digunakan'];
                    $status = 200;
                }
            } else {

                $res['data'] = ['message' => 'email kosong'];
            }

            return response()->json($res, $status);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => false,
                'data' => [
                    'message' => $exception->getMessage()
                ]
            ], 500);
        }
    }
}
