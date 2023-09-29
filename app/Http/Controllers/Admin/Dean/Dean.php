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
        return view('pages.admin.dean.index');
    }

    public function show()
    {
        $deans = User::where('role', 'dean')->get();
        $table = '';
        if($deans->count()>0){
            $table .= '<table class="table bg-white rounded shadow-sm  table-hover" id="table">
                            <thead>
                                <tr>
                                    <th scope="col" width="50"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Institute</th>
                                    <th scope="col" width="30px">Action</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach($deans as $key => $dean){
                                $table .= '<tr>
                                            <td>'.intval($key+1).'</td>
                                            <td>'.$dean->name.'</td>
                                            <td>'.$dean->institute.'</td>
                                            <td><button class="btn btn-secondary btn-sm" id="edit_dean_btn" data-id="'.$dean->id.'">Edit</button></td>
                                        </tr>';
                            }
                            $table .= '</tbody>
                            </table>';
        }
        echo $table;
        
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $dean = User::find($id);

        if ($dean === null) {
            return response()->json(['error' => 'Dean not found']);
        } else {
            return response()->json($dean);
        }
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

    public function edit(Request $request)
    {
        $id = $request->id;
        $password = $request->password;
        $confirmed = $request->confirmed;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:6|max:20',
            'confirmed' => 'required|password',
        ]);
        if($password == $confirmed){

            if ($validator->failed()) {
                return response()->json($validator->messages());
            } else{
                $user = User::find($id);
                $valid = $request->all();
                array_shift($valid);
                if ($user === null) {
                    return response()->json('invalid user id');
                } else {
                    $user->name = $valid['name'];
                    $user->password = $valid['password'];
                    $user->update();
                    return response()->json('success');
                }
            }
        } else {
            return response()->json(['error'=>"Password doesn't match!"]);
        }
        
    }
}
