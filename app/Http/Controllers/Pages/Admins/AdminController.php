<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Model\Bank;
use App\Model\Bio;
use App\Model\SubKategori;
use App\Support\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Whoops\Exception\ErrorException;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $role = Auth::user();
        $admins = User::where('role', Role::ADMIN)->get();

        return view('pages.admins.dashboard', compact('role', 'admins'));
    }

    public function bank(Request $request)
    {
        $bank = Bank::all();

        return view('layouts.mst_admin', compact('bank'));
    }

    public function editProfile()
    {
        $admin = Auth::user();

        return view('pages.admins.editProfile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = User::find(Auth::id());
        if ($request->hasfile('foto')) {
            $this->validate($request, ['foto' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
            $name = $request->file('foto')->getClientOriginalName();
            if ($admin->get_bio->foto != '') {
                Storage::delete('public/users/foto/' . $admin->get_bio->foto);
            }
            $request->file('foto')->storeAs('public/users/foto', $name);

        } else {
            $name = $admin->get_bio->foto;
        }

        $admin->update(['name' => $request->name]);
        $admin->get_bio->update(['foto' => $name]);

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function accountSettings()
    {
        $admin = Auth::user();

        return view('pages.admins.akun.setting', compact('admin'));
    }

    public function updateAccount(Request $request)
    {
        $admin = User::find(Auth::id());

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Kata sandi lama Anda salah!');

        } else {
            if ($request->new_password != $request->password_confirmation) {
                return back()->with('error', 'Konfirmasi kata sandi Anda salah!');

            } else {
                $admin->update([
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => bcrypt($request->new_password)
                ]);
                return back()->with('success', 'Akun Anda berhasil diperbarui!');
            }
        }
    }

    public function admin()
    {
        $data = User::where('role', Role::ADMIN)->get();
        return view('pages.admins.akun.show', [
            'admin' => $data
        ]);
    }

    public function add_admin(Request $request)
    {
        try {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
//                'password' => bcrypt('secret'),
                'password' => bcrypt($request->password),
                'role' => Role::ADMIN,
                'username' => $request->username
            ]);

            Bio::create([
                'user_id' => $data->id
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Data Admin Berhasil Ditambahkan"
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => 401,
                'message' => $exception
            ]);
        } catch (ErrorException $error) {
            return response()->json([
                'status' => 401,
                'message' => $error
            ]);
        }
    }

    public function other()
    {
        $data = User::where('role', Role::OTHER)->get();
        return view('pages.admins.akun.other', [
            'user' => $data
        ]);
    }

    public function other_detail($username)
    {
        $data = User::where('username', $username)->first();

        return view('pages.admins.akun.detail_other', [
            'user' => $data
        ]);
    }
}
