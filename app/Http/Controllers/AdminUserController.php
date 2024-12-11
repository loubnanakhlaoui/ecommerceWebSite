<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function index() {
        return view('admin.login');
    }

    public function store(Request $request) {
        $credentials = $request->only('email', 'password');
        
        // Debug: Vérifiez les credentials
        
        if (Auth::guard('admin')->attempt($credentials)) {
            session()->flash('msg', 'You have been logged in');
            return redirect('/admin');
        }
    
        return back()->withErrors([
            'message' => 'Identifiants incorrects'
        ]);
    }

    public function logout() {
        auth()->guard('admin')->logout();

        session()->flash('msg','You have been logged out');

        return redirect('/admin/login');
    }

}
