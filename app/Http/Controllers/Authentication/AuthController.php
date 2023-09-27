<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(Request $request)
    {
        if ($request->isMethod('get')) {

            return view('pages.login');
        }
        // Get the request data
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Check user and password is valid
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->route('loading');
        } else {
            return redirect()->back()->with('invalid', 'Email or Password is invalid!');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
