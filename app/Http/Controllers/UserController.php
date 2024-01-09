<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function login()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => ['required'],
            'password' => ['required'],
            // 'g-recaptcha-response' => 'required|captcha'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('admin');
        }
        return redirect()->back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|unique:users',
            'password' => 'required',
            'level' => 'required',
        ]);

        $user = new User();
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->level = $request->input('level');
        $user->save();

        return redirect('admin/user')->with('success', 'User berhasil ditambahkan');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login'); 
    }

    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.user.user', ['users' => $users]);
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'username' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|min:6',
            'level' => 'required|in:superadmin,admin',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->email = $request->input('email');
        $user->username = $request->input('username');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->level = $request->input('level');
        $user->save();

        return redirect('admin/user')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('admin/user')->with('success', 'User berhasil dihapus');
    }
}
