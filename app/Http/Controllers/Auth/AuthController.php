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
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route("admin.dashboard")->with('success', 'Logged in successfully!');
        } else {
            return redirect()->back()->with('error', 'Invalid credentials!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.page')->with('success', 'Logged out successfully!');
    }
}
