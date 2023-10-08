<?php

namespace App\Http\Controllers\Admin\Student;

use App\Models\User;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Termwind\Components\Span;

class Student extends Controller
{
    public function index()
    {
        return view('pages.admin.student.index');
    }

    public function show()
    {
        $student = User::where('role', 'student')->get();
        if(count($student) > 0){
            $table = '<table class="table bg-white rounded shadow-sm  table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="30px">Action</th>
                            </tr>
                        </thead>
                        <tbody>';
                        
                        foreach($student as $key => $stud){
                            $status_array = [];
                            $student_status = Evaluate::where('user_id', $stud->id)->get();
                            foreach($student_status as $stud_stat){
                                $status_array[] = $stud_stat->status;
                            }
                            if (empty($status_array)) {
                                $result = false;
                            } else {
                                $result = array_reduce($status_array, function ($carry, $stats) {
                                    return $carry && ($stats == 1);
                                }, true);
                            }
                        
                            if($result){
                                $table .= '<tr>
                                        <td>'.intval($key+1).'</td>
                                        <td>'.$stud->name.'</td>
                                        <td>'.$stud->username.'</td>
                                        <td><span class="badge text-bg-success">Done</span>
                                        </td>
                                        <td>
                                        <button class="btn btn-secondary">view</i></button>
                                        </td>
                                    </tr>';
                            } else {
                                $table .= '<tr>
                                        <td>'.intval($key+1).'</td>
                                        <td>'.$stud->name.'</td>
                                        <td>'.$stud->username.'</td>
                                        <td><span class="badge text-bg-warning">Pending</span>
                                        </td>
                                        <td>
                                        <button class="btn btn-secondary">view</button>
                                        </td>
                                    </tr>';
                            }
                            
                        }
                        $table .= '</tbody>
                    </table>';

                    echo $table;
        } else {
            echo '<div class="h1 text-center text-secondary my-5">There is no record in database.</div>';
        }
    }

    public function view(String $id)
    {
        $student = User::find($id);
        if ($student === null) {
            return response()->json(['error' => 'Student not found']);
        } else {
            $student->evaluations;
            return response()->json($student);
        }
    }
}
