<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {   
        // dd('here');
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return view('dashboard');
        }
        
        return redirect()->back()->with('loginerror', 'Invalid credentials. Please try again.');
    }
}

