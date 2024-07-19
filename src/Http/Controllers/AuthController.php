<?php

namespace HoangPham\SimpleAdminGeneration\Http\Controllers;

use App\Http\Controllers\Controller;
use HoangPham\SimpleAdminGeneration\Models\Admin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function index()
    {
        return view('simple_admin_generation::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect(route('simple_admin_generation.dashboard'));
        }
        return back()->withErrors([
            'password' => 'The provided credentials do not match our records.',
        ])->onlyInput('password');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('simple_admin_generation.login'));
    }

    public function profile(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Application
    {
        $meta = [
            'title' => 'Admin Profile',
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'url' => route('simple_admin_generation.dashboard')
                ],
                [
                    'name' => 'Profile',
                ]
            ]
        ];
        $admin = Admin::query()->findOrFail(Auth::guard('admin')->user()->id);
        return view('simple_admin_generation::user.profile', compact('meta', 'admin'));
    }
}