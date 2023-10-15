<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pages.login');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $usernameError = $validator->errors()->first('username');
            $passwordError = $validator->errors()->first('password');

            if ($usernameError && $passwordError) {
                $message = 'Both fields are required.';
            } else if ($usernameError) {
                $message = $usernameError;
            } else if ($passwordError) {
                $message = $passwordError;
            }

            return view('pages.login')->with('message', $message);
        }

        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('loading');
        } else {
            $message = 'Invalid username or password';

            if (!User::where('username', $credentials['username'])->exists()) {
                $message = 'Invalid username';
            } elseif (!User::where('password', bcrypt($credentials['password']))->exists()) {
                $message = 'Invalid password';
            }

            return view('pages.login')->with('message', $message);
        }
    }

    //change password
    public function changePassword(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'password_old' => 'required',
            'password_new' => 'required|min:4|max:20',
            'password_confirm' => 'required|same:password_new|min:4|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()]);
        } else {
            $user = User::find(auth()->user()->id);
            if (Hash::check($request->input('password_old'), $user->password)) {
                $user->password = Hash::make($request->input('password_confirm'));
                $user->update();
                return response()->json('success');
            } else {
                return response()->json(['error' => 'Password Incorrect']);
            }
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
