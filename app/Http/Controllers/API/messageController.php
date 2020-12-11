<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Cache;
use Illuminate\Support\Facades\Validator;


class messageController extends Controller
{
    public function index(Request $r)
    {
        try {
            $user = auth('api')->user();
            $loc = 'chat/' . $user->id . '_histori/';
            $path = $loc . now()->format('Y_m_d') . '.json';



            return response()->json([
                'error' => false,
                'data' => [
                    'test' => Cache::has('12_to_1'),
                    'user' => $this->getUser($user, $r),
                    'chat' => ($r->chat_id ? $this->getChat($user, $r) : []),
                    'typing' => Cache::has('chat_' . $r->chat_id . '_to_' . $user->id),

                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function eventTyping(Request $r)
    {
        try {
            $user = auth('api')->user();
            $id = $r->id;
            // $loc = 'chat/' . $id . '_histori/';
            // $path = $loc . now()->format('Y_m_d') . '.json';

            Cache::put('chat_' . $user->id . '_to_' . $id, true, now()->addSeconds(3));


            // $array = Storage::disk('local')->exists($path) ?
            //     json_decode(Storage::disk('local')->get($path), true) : [];

            // if (!count($array)) {

            //     $array[] = ['id' => $user->id, 'typing_at' => now()->addSeconds(4)];
            // } else {

            //     $chek = array_column($array, 'id');
            //     $index = array_search($user->id, $chek);

            //     if (is_numeric($index) ? $index >= 0 : false) {

            //         $array[$index] = ['id' => $user->id, 'typing_at' => now()->addSeconds(3)];
            //     } else {
            //         $array[] = ['id' => $user->id, 'typing_at' => now()->addSeconds(3)];
            //     }
            // }

            // Storage::delete($loc . now()->subDay() . '.json');
            // Storage::put($loc . now()->format('Y_m_d') . '.json', json_encode($array));

            return response()->json(['error' => false, 'message' => 'berhasil update!',]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendChat(Request $r)
    {

        $validator = Validator::make($r->all(), [
            'chat_id' => 'required|exists:users,id',
            'image' => 'mimes:jpg,jpeg',
            'message' => 'string',
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
            $id = $r->chat_id;
            $user = auth('api')->user();
            $msg = $r->message;

            if ($r->file('image')) {
                $picture = $r->file('image');
                $imageName = now()->format('ymd') . '_' . now()->format('His') . '_' . sprintf("%02d", rand(0, 99)) . '.' . $picture->extension();
                $picture->storeAs('chat/' . $user->id, $imageName, 'public');
            }

            if ($r->file('image') || $msg) {
                // return response()->json([
                //     'user_to'=>$id,
                //     'user_from'=>$user->id,
                //     'message'=>$msg?$msg:null,
                //     'image'=>isset($imageName)?$imageName:null,
                // ]);
                Message::create([

                    'message' => ($msg ? $msg : ''),
                    'image' => (isset($imageName) ? $imageName : null),
                    'read' => 0,
                    'user_to' => $id,
                    'user_from' => $user->id,
                ]);

                return response()->json([
                    'error' => false,
                    'message' => 'berhasil kirim chat!',
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Harap isi field',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 501);
        }
    }

    private function getUser($user, $r)
    {
        $resNew = $checker = [];
        $limit = $r->len_user;
        $q = $r->q;
        $res = Message::where(function ($q) use ($user) {
            $q->where('user_to', $user->id);
            $q->Orwhere('user_from', $user->id);
        })

            ->orderBy('id', 'desc')
            ->select('user_from', 'user_to', 'created_at')

            ->get();

        foreach ($res as $i => $dt) {
            $id = $dt->user_to == $user->id ? $dt->user_from : $dt->user_to;
            $key = array_search($id, $checker);

            if (!is_numeric($key)) {
                $checker[] = $id;

                $r = collect(DB::table('users')
                    ->where('users.id', $id)

                    ->when($q, function ($query) use ($q) {
                        $query->where('users.name', 'like', "%$q%");
                    })
                    ->join('bio', 'bio.user_id', '=', 'users.id')

                    ->select(
                        'users.id',
                        'users.name',
                        'bio.foto',
                        DB::raw('ifnull((select count(ms.id) from message ms where users.id=ms.user_from and ms.`read`=0),0) as `jumlah_unread`')
                    )

                    ->first())->toArray();

                if ($r) {
                    $resNew[] = collect($this->imgCheck((object)$r, 'foto', 'storage/users/foto/', 1))->toArray();
                }
                if (count($resNew) == ($limit ? $limit : 12)) {
                    break;
                }
            }
        }

        return $resNew;
    }

    private function getChat($user, $r)
    {
        $limit = $r->len_chat;
        $chat_to = $r->chat_id;



        $chat = DB::table('message')
            ->leftJoin('bio', 'bio.user_id', '=', 'message.user_from')
            ->join('users', 'users.id', '=', 'message.user_from')
            ->leftJoin('message as ms', 'ms.id', '=', 'message.reply_id')
            ->leftJoin('users as us', 'us.id', '=', 'ms.user_from')

            ->select(
                'message.id',
                'message.image',
                'users.name as nama',
                'bio.foto',
                'ms.id as id_reply',
                'us.name as name_reply',
                'ms.message as message_reply',
                DB::raw("message.user_from='" . $user->id . "' is_me"),
                'message.message',
                'message.created_at'
            )
            ->where(function ($q) use ($chat_to, $user) {
                $q->where('message.user_to', $user->id);
                $q->where('message.user_from', $chat_to);
            })
            ->orWhere(function ($q) use ($chat_to, $user) {
                $q->where('message.user_to', $chat_to);
                $q->where('message.user_from', $user->id);
            })
            ->limit($limit ?? 12)
            ->orderBy('message.id', 'desc')
            ->get();

        $to_read = Message::where('user_from', $chat_to)
            ->where('user_to', $user->id)
            ->where('read', '0');

        $to_read->update(['read' => '1']);

        $chat = $chat ? $this->imgCheck($chat->toArray(), 'foto', 'storage/users/foto/', 1) : [];

        foreach ($chat as $result) {
            if ($result->id_reply) {
                $result->reply = [
                    'id' => $result->id_reply,
                    'name' => $result->name_reply,
                    'message' => $result->message_reply
                ];
            }
            unset($result->id_reply,
            $result->name_reply,
            $result->message_reply,);

            if ($result->image) {
                unset($result->message);

                $result = $result ? $this->imgCheck($result, 'image', 'storage/chat/' . $user->id . '/', 2) : [];
            } else {
                unset($result->image);
            }
        }

        return $chat;
    }



    private function imgCheck($data, $column, $path, $ch = 0)
    {

        $dummy_photo = [
            asset('images/slider/beranda-' . rand(1, 5) . '.jpg'),
            asset('admins/img/avatar/avatar-' . '1' . '.png'),
            asset('images/notfound.png')
        ];
        $res = $data;


        if (is_array($data)) {


            $res = [];

            foreach ($data as $i => $row) {


                $res[$i] = $row;

                $res[$i]->{$column} = $res[$i]->{$column} && File::exists($path . $res[$i]->{$column}) ?
                    asset($path . $res[$i]->{$column}) :
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
