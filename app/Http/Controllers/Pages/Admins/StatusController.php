<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Kematian;
use App\Model\StatusKematian;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function kematian()
    {
        $data = StatusKematian::all();
        $data2 = Kematian::whereIn('id', $data->pluck('kematian_id'))->orderBy('created_at')->get();
//        $data_provinsi = Provinsi::all();
//        return view('pages.admins.master.status_kematian', [
//            'status_kematian' => $data2,
////            'provinsi' => $data_provinsi
//        ]);
        return view('pages.admins.master.status_kematian', compact('data2','data'));
    }
}
