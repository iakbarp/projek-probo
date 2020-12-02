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

class messageController extends Controller
{
    public function index(Request $r)
    {
        try {
            $user = auth('api')->user();
            $loc = 'chat/' . $user->id . '_histori/';
            $path = $loc . now()->format('Y_m_d') . '.json';
            $typing = false;


            $array = Storage::disk('local')->exists($path) ?
                json_decode(Storage::disk('local')->get($path), true) : [];
            if (count($array)) {
                $chek = array_column($array, 'id');
                $index = array_search($r->chat_id, $chek);


                if ((is_numeric($index) ? $index >= 0 : false) && now()->lt(Carbon::parse($array[$index]['typing_at']))) {
                    $typing = true;
                }
            }

            return response()->json([
                'error' => false,
                'data' => [
                    'user' => $this->getUser($user, $r),
                    'chat' => ($r->chat_id ? $this->getChat($user, $r) : []),
                    'typing' => $typing,
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
            $loc = 'chat/' . $id . '_histori/';
            $path = $loc . now()->format('Y_m_d') . '.json';


            $array = Storage::disk('local')->exists($path) ?
                json_decode(Storage::disk('local')->get($path), true) : [];

            if (!count($array)) {

                $array[] = ['id' => $user->id, 'typing_at' => now()->addSeconds(60)];
            } else {

                $chek = array_column($array, 'id');
                $index = array_search($user->id, $chek);

                if (is_numeric($index) ? $index >= 0 : false) {

                    $array[$index] = ['id' => $user->id, 'typing_at' => now()->addSeconds(3)];
                } else {
                    $array[] = ['id' => $user->id, 'typing_at' => now()->addSeconds(3)];
                }
            }

            Storage::delete($loc . now()->subDay() . '.json');
            Storage::put($loc . now()->format('Y_m_d') . '.json', json_encode($array));

            return response()->json(['error' => false, 'message' => 'berhasil update!']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function getUser($user, $r)
    {
        $limit = $r->len_user;
        $res = Message::where(function ($q) use ($user) {
            $q->where('user_to', $user->id);
            $q->Orwhere('user_from', $user->id);
        })
            ->orderBy('created_at', 'desc')
            ->select('user_from', 'user_to', 'created_at')
            ->groupBy('user_from')
            ->groupBy('user_to')
            ->groupBy('created_at')

            ->limit($limit ?? 12)->get();

        $res = DB::table('users')->whereIn('users.id', $res->pluck('user_from'))
            ->where('users.id', '!=', $user->id)
            ->join('bio', 'bio.user_id', '=', 'users.id')

            ->select(
                'users.id',
                'users.name',
                'bio.foto',
                DB::raw('ifnull((select count(ms.id) from message ms where users.id=ms.user_from and ms.`read`=0),0) as `jumlah_unread`')
            )
            ->get();
        $res = $res ? $this->imgCheck($res, 'foto', 'storage/users/foto/', 1) : [];

        return $res;
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

        $chat = $chat ? $this->imgCheck($chat, 'foto', 'storage/users/foto/', 1) : [];

        foreach ($chat as $result) {
            if($result->id_reply){
                $result->reply = [
                    'id' => $result->id_reply,
                    'name' => $result->name_reply,
                    'message' => $result->message_reply
                ];

            }
            unset($result->id_reply,
                $result->name_reply,
                $result->message_reply
            );
        }

        return $chat;
    }


    private function imgCheck($data, $column, $path, $ch)
    {
        $res = [];
        $dummy_photo = [
            asset('images/slider/beranda-' . rand(1, 5) . '.jpg'),
            asset('admins/avatar/avatar-' . rand(1, 2) . '.jpg'),
            asset('images/notfound.png')
        ];

        foreach ($data as $i => $row) {
            $res[$i] = $row;

            $res[$i]->{$column} = $res[$i]->{$column} && File::exists($path . $res[$i]->{$column}) ?
                asset($path . $res[$i]->{$column}) :
                $dummy_photo[$ch];
        }

        return $res;
    }
}
