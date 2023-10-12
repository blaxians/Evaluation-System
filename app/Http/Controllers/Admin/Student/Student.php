<?php

namespace App\Http\Controllers\Admin\Student;


use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use Termwind\Components\Span;
use App\Http\Controllers\Controller;
use App\Models\Faculties;

class Student extends Controller
{
    public function index()
    {
        return view('pages.admin.student.index');
    }

    public function show()
    {
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;
        $student = User::where('role', 'student')->get();

        if (count($student) > 0) {
            $table = '<table class="table bg-white rounded shadow-sm  table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col" width="50">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="30px">View</th>
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($student as $key => $stud) {
                $status_array = [];
                $student_status = Evaluate::where('user_id', $stud->id)->where('year_sem', $new_year_sem)->get();
                foreach ($student_status as $stud_stat) {
                    $status_array[] = $stud_stat->status;
                }
                if (empty($status_array)) {
                    $result = false;
                } else {
                    $result = array_reduce($status_array, function ($carry, $stats) {
                        return $carry && ($stats == 1);
                    }, true);
                }

                if ($result) {
                    $table .= '<tr>
                                        <td>' . intval($key + 1) . '</td>
                                        <td>' . $stud->name . '</td>
                                        <td>' . $stud->username . '</td>
                                        <td><span class="badge text-bg-success">Done</span>
                                        </td>
                                        <td>
                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#view_student_modal" id="btn_view_button" data-status="Done" data-id="' . $stud->id . '"><i class="bi bi-eye-fill"></i></button>
                                        </td>
                                    </tr>';
                } else {
                    $table .= '<tr>
                                        <td>' . intval($key + 1) . '</td>
                                        <td>' . $stud->name . '</td>
                                        <td>' . $stud->username . '</td>
                                        <td><span class="badge text-bg-warning">Pending</span>
                                        </td>
                                        <td>
                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#view_student_modal" id="btn_view_button" data-status="Pending" data-id="' . $stud->id . '">
                                        <i class="bi bi-eye-fill"></i></button>
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

    public function view(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $student = User::find($id);

        if ($student === null) {
            return response()->json(['error' => 'Student not found']);
        }

        $faculties = $student->evaluate;

        $faculty_table = '<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Faculty Name</th>
                                    <th>Institute</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>';

        if (count($faculties) > 0) {
            foreach ($faculties as $value) {
                $details = Faculties::find($value->faculties_id);
                $value->name = $details->last_name . ' ' . $details->first_name . ' ' . $details->middle_name;
                $value->institute = $details->institute;

                $span = ($value->status == 1) ? '<span class="badge text-bg-success">Done</span>' : '<span class="badge text-bg-warning">Pending</span>';

                $faculty_name = empty($value->name) ? 'No Data' : $value->name;
                $faculty_insti = empty($value->institute) ? 'No Data' : $value->institute;
                $faculty_span = empty($span) ? 'No Data' : $span;

                $faculty_table .= '<tr>
                                    <td>' . $faculty_name . '</td>
                                    <td>' . $faculty_insti . '</td>
                                    <td>' . $faculty_span . '</td>
                                </tr>';
            }
        } else {
            $faculty_table .= '<tr>
                                <td colspan="3" class="text-center ">No Data</td>
                            </tr>';
        }

        $faculty_table .= '</tbody>
                    </table>';

        $student->evaluations;

        return response()->json([
            'student' => $student,
            'status' => $status,
            'faculties' => $faculties,
            'faculty_table' => $faculty_table,
        ]);
    }
}
