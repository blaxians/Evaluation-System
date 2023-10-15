<?php

namespace App\Http\Controllers\Admin\Dean;

use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use App\Models\Faculties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;
        $table = '';
        if ($deans->count() > 0) {
            $table .= '<table class="table bg-white rounded shadow-sm  table-hover" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Institute</th>
                                    <th scope="col" style="text-align:center;">Status</th>
                                    <th scope="col" style="text-align:center;">Edit / View</th>
                                </tr>
                            </thead>
                            <tbody>';
            foreach ($deans as $key => $dean) {
                $status = '';
                $status_array = [];
                $dean_status = Evaluate::where('user_id', $dean->id)->where('year_sem', $new_year_sem)->get();
                if (count($dean_status) < 1) {

                    $status .= ' <span class="badge text-bg-warning">Pending</span>';
                } else {
                    foreach ($dean_status as $value) {
                        if ($value->status == 0) {
                            array_push($status_array, 0);
                        }
                    }

                    if (count($status_array) == 0) {
                        $status .= ' <span class="badge text-bg-success">Done</span>';
                    } else {
                        $status .= ' <span class="badge text-bg-warning">Pending</span>';
                    }
                }
                $table .= '<tr>
                                            <td>' . intval($key + 1) . '</td>
                                            <td>' . $dean->name . '</td>
                                            <td>' . $dean->institute . '</td>
                                            <td style="text-align:center;">' . $status . '</td>
                                            <td style="text-align:center;">
                                            <button data-bs-toggle="tooltip" title="Edit" data-bs-placement="top" class="btn btn-secondary btn-sm me-1" id="edit_dean_btn" data-id="' . $dean->id . '">
                                            <i class="bi bi-pencil-square"></i></button>
                                            <button data-bs-toggle="tooltip" title="View" data-bs-placement="top" class="btn btn-success btn-sm" id="view_dean_btn" data-id="' . $dean->id . '">
                                            <i class="bi bi-eye-fill" ></i></button>
                                            </td>
                          </tr>';
            }
            $table .= '</tbody>
</table>';
            echo $table;
        } else {
            echo '<div class="h1 text-center text-secondary my-5">There is no record in database.</div>';
        }
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $dean = User::find($id);
      

        $id = $request->id;
        $status = $request->status;
        $dean = User::find($id);
        $faculties =  $dean->evaluate;

        foreach ($faculties as  $value) {
            $details = Faculties::find($value->faculties_id);
            $value->name = $details->last_name . ' ' . $details->first_name . ' ' . $details->middle_name;
            $value->institute = $details->institute;
        }


        if ($dean === null) {
            return response()->json(['error' => 'Dean not found']);
        } else {
            $dean->evaluations;
            $dean_table = '<table class="table table-bordered">
                        <thead>
                            <th>Name</th>
                            <th>Institute</th>
                            <th>Status</th>
                        </thead>
                        <tbody>';
            if(count($faculties) > 0){
                
                foreach($faculties as $faculty){

                    if($faculty->status == 1){
                        $dean_status = '<span class="badge text-bg-success">Done</span>';
                    } else {
                        $dean_status = '<span class="badge text-bg-warning">Pending</span>';
                    }
                    $dean_table .= '<tr>
                                    <td>'.$faculty->name.'</td>
                                    <td>'.$faculty->institute.'</td>
                                    <td>'.$dean_status.'</td>
                                </tr>';
                }
                $dean_table .= '</tbody>
                </table>';
            } else {
                $dean_table .= '<tr>
                                    <td>no data</td>
                                    <td>no data</td>
                                    <td>no data</td>
                                </tr>
                            </tbody>
                        </table>';
}
            
            return response()->json(['dean'=>$dean, 'faculties'=>$faculties, 'dean_table'=>$dean_table]);
        }
    }

        
    

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'institute' => 'required|unique:users'
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
        if ($password == $confirmed) {

            if ($validator->failed()) {
                return response()->json($validator->messages());
            } else {
                $user = User::find($id);
                $valid = $request->all();
                array_shift($valid);
                if ($user === null) {
                    return response()->json('invalid user id');
                } else {
                    $user->name = $valid['name'];
                    $user->password = Hash::make($valid['password']);
                    $user->update();
                    return response()->json('success');
                }
            }
        } else {
            return response()->json(['error' => "Password doesn't match!"]);
        }
    }
}
