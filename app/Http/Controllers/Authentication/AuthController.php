<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pages.login');
        }

        // Get the request data
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $validated['email'])->where('password', $validated['password'])->get()->first();

        if ($user) {
            $request->session()->regenerate();
        } else {
            return redirect()->back()->with('invalid', 'Email or Password is invalid!');
        }
    }

    public function logout()
    {
        auth()->logout();
    }
}
