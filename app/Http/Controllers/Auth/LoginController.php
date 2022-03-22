<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect(route('dashboard'));
        }
 
        return back()->withErrors([
            'email' => 'Email incorrect',
            'password' => 'Mot de passe incorrect',

        ]);
    }   
    public function displayLogin(Request $request){ 
        if(isset(auth()->user)){
            return redirect(route('dashboard'));

        }

        return Inertia::render('login');
    }
}
