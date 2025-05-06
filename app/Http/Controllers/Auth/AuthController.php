<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginView()
    {
        return view("auth.login");
    }

    public function registerView()
    {
        return view("auth.register");
    }

    public function register(RegisterRequest $request)
    {
        $result = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        if ($result) {
            return redirect()->route("login.page")->with("success", "Account successfully created!");
        } else {
            return redirect()->back()->with("error", "Failed to create account!");
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($request->role === 'admin') {
            if (Auth::guard('admin')->attempt($credentials)) {
                return redirect()->route('admin.dashboard');
            }
        } elseif ($request->role === 'student') {
            if (Auth::guard('students')->attempt($credentials)) {
                return redirect()->route('student.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid Credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.page')->with('success', 'Logged out successfully!');
    }
}
