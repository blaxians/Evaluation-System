<?php

namespace App\Http\Controllers\Admin\Student;


use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use Termwind\Components\Span;
use App\Http\Controllers\Controller;
use App\Models\Faculties;
use Illuminate\Support\Facades\Hash;

class Student extends Controller
{
    public function index()
    {
        return view('pages.admin.student.index');
    }

    public function show()
    {
        $year_sem = YearSem::latest()->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $students = User::where('role', 'student')->get();
        $studentIds = $students->pluck('id');
        $studentEvaluations = Evaluate::whereIn('user_id', $studentIds)
            ->where('year_sem', $new_year_sem)
            ->get();

        $data = [];
        foreach ($students as $key => $student) {
            $studentStatus = $studentEvaluations->where('user_id', $student->id)->pluck('status');
            $result = $studentStatus->isEmpty() ? false : $studentStatus->every(fn ($status) => $status == 1);

            $data[] = [
                'id' => $student->id, 
                'name' => $student->name,
                'username' => $student->username,
                'status' => $result ? 'Done' : 'Pending',
                'actions' => !$result,
            ];  
        }

        return response()->json(['data' => $data]);
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
                $value->name = $details->last_name . ', ' . $details->first_name . ' ' . $details->middle_name;
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

    public function resetPassword(Request $request)
    {
        $id = $request->id;
        $student = User::find($id);
        if ($student == null) {
            return response()->json(['error' => 'Student not found']);
        } else {
            $student->password = Hash::make($student->username);
            $student->update();
            return response()->json('success');
        }
    }
}
