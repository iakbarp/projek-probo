<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Model\Project;
use App\Model\Services;
use Illuminate\Http\Request;

class MasterProjectServiceController extends Controller
{
    public function project()
    {
        $data = Project::all();
        return view('pages.admins.master.project', [
            'project' => $data
        ]);
    }

    public function service()
    {
        $data = Services::all();
        return view('pages.admins.master.service', [
            'service' => $data
        ]);
    }
}
