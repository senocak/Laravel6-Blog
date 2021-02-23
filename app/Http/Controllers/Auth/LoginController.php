<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
    use AuthenticatesUsers;
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = "/admin/anasayfa";

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route("admin.anasayfa");
    }
}
