<?php

namespace App\Http\Controllers\Master;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(UserDataTable $datatable)
    {
        return $datatable->render('master.user');
    }

    public function create()
    {
        return view('master.user-form');
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan' => $request->jabatan,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'username' => $request->username,
                'password' => bcrypt($request->password)
            ]);

            $role = strtolower(str_replace(' ', '_', $request->jabatan));
            $user->assignRole($role);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $data = User::find(decrypt($id));
        $url = route('user.update', $id);
        return view('master.user-form', compact('data', 'url'));
    }

    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find(decrypt($id));
            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            $user->jabatan = $request->jabatan;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            $role = strtolower(str_replace(' ', '_', $request->jabatan));
            $user->syncRoles([$role]);

            DB::commit();
            return responseMessage();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseMessage('error', 'Data gagal diubah');
        }
    }

    public function profile(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('profile');
        }

        $request->validate([
            'nama_lengkap' => 'required',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore(auth()->id())
            ],
            'nomor_handphone' => 'required'
        ]);

        try {
            $user = request()->user();

            $user->nama_lengkap = $request->nama_lengkap;
            $user->email = $request->email;
            $user->no_hp = $request->nomor_handphone;
            $user->save();

            return responseMessage();
        } catch (\Throwable $th) {
            return responseMessage('error', 'Data gagal diubah');
        }
    }

    public function password(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('ganti-password');
        }

        $request->validate([
            'password_lama' => 'required',
            'password' => 'required|confirmed'
        ]);

        try {
            $user = $request->user();
            if (password_verify($request->password_lama, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
            } else {
                throw new Exception('Password lama tidak sesuai');
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Ganti password berhasil',
                'reloadURL' => url('profile')
            ]);
        } catch (\Throwable $th) {
            return responseMessage('error', $th->getMessage());
        }
    }
}
