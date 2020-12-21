<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class aggrementController extends Controller
{
    public function proyek(Request $request)
    {
        $name=$request->name;
        return response()->view('aggrements.proyek', compact('name'));
    }
}
