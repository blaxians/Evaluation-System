<?php

namespace App\Http\Controllers\Admin\Dean;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Dean extends Controller
{
    public function index()
    {
        $deans = User::where('role', 'dean')->get();
        return response()->json($deans);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'institute' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        } else {
            $valid = $request->all();
            array_shift($valid);
            $user = new User();
            $user->name = $valid['name'];
            $user->username = $valid['username'];
            $user->password = Hash::make($valid['username']);
            $user->role = 'dean';
            $user->institute = $valid['institute'];
            $user->save();
            return response()->json('success');
        }
    }

    public function edit(Request $request, String $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:6|max:20',
            'confirmed' => 'required|password',
        ]);

        if ($validator->failed()) {
            return response()->json($validator->messages());
        } else {
            $user = User::find($id);
            $valid = $request->all();
            array_shift($valid);
            if ($user === null) {
                return response()->json('invalid user id');
            } else {
                $user->username = $valid['username'];
                $user->password = $valid['password'];
                $user->update();
                return response()->json('success');
            }
        }
    }
}
