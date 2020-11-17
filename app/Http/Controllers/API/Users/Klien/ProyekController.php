<?php

namespace App\Http\Controllers\API\Users\klien;

use App\Http\Controllers\Controller;
use App\Model\Bio;
use App\Model\Pengerjaan;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProyekController extends Controller
{
    public function dashboard(Request $request)
    {
        try{
        $q=$request->q;
        $user=auth('api')->user();

        $proyek=Project::where('user_id',$user->id)
        ->where('judul','like',"%$q%")->get();

        $bio=Bio::where('user_id',$user->id)->select(['status','foto'])->first();
        $bio->nama=$user->name;
        $bio->foto=$this->imgCheck($bio, 'foto', 'storage/proyek/thumbnail');

        $Pengerjaan=Pengerjaan::whereIn('proyek_id',$proyek->pluck('id'))
        ->get();

        return response()->json([
            'error' => true,
            'data' => [
                'proyek'=>$proyek,
                'Pengerjaan'=>$Pengerjaan,
                'proyek_count'=>$proyek->count(),
                'Pengerjaan_count'=>$Pengerjaan->count(),
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
