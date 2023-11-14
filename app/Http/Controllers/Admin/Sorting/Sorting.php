<?php

namespace App\Http\Controllers\Admin\Sorting;

use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use App\Models\Faculties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class Sorting extends Controller
{


    public function index(Request $request)
    {

        return view('pages.admin.sorting.sorting    ');
    }

    public function campus()
    {

        $campus = User::select('campus')
            ->groupBy('campus')
            ->get();
        $list_campus = [];
        foreach ($campus as $key => $value) {
            if ($value->campus == null) {
                unset($campus[$key]);
            } else {
                $list_campus[] = $value->campus;
            }
        }
        return response()->json($list_campus);
    }

    // public function institute(Request $request)
    // {
    //     $params = $request->campus;
    //     $institute = User::select('institute')
    //         ->where('campus', $params)
    //         ->groupBy('institute')
    //         ->get();
    //     $list_institute = [];
    //     foreach ($institute as $key => $value) {
    //         if ($value->institute == null) {
    //             unset($institute[$key]);
    //         } else {
    //             $list_institute[] = $value->institute;
    //         }
    //     }
    //     return response()->json($list_institute);
    // }

    public function institute(Request $request)
    {
        $campus = $request->input('campus');

        $list_institute = User::where('campus', $campus)
            ->whereNotNull('institute')
            ->distinct()
            ->pluck('institute')
            ->filter()
            ->values()
            ->toArray();

        return response()->json($list_institute);
    }

    // public function courses(Request $request)
    // {
    //     $campus = $request->main_campus;
    //     $institute = $request->main_insti;
    //     $courses = User::select('program_name')
    //         ->where('campus', $campus)
    //         ->where('institute', $institute)
    //         ->groupBy('program_name')
    //         ->get();

    //     $list_course = [];
    //     foreach ($courses as $key => $value) {
    //         if ($value->program_name == null) {
    //             unset($courses[$key]);
    //         } else {
    //             $list_course[] = $value->program_name;
    //         }
    //     }
    //     return response()->json($list_course);
    // }

    public function courses(Request $request)
    {
        $campus = $request->input('main_campus');
        $institute = $request->input('main_insti');

        $list_course = User::where('campus', $campus)
            ->where('institute', $institute)
            ->whereNotNull('program_name')
            ->distinct()
            ->pluck('program_name')
            ->filter()
            ->values()
            ->toArray();

        return response()->json($list_course);
    }


    // public function year_level(Request $request)
    // {
    //     $campus = $request->main_campus;
    //     $institute = $request->main_insti;
    //     $course = $request->main_course;

    //     $year = User::select('year_level')
    //         ->where('campus', $campus)
    //         ->where('institute', $institute)
    //         ->where('program_name', $course)
    //         ->groupBy('year_level')
    //         ->get();
    //     $list_year = [];
    //     foreach ($year as $key => $value) {
    //         if ($value->year_level == null) {
    //             unset($year[$key]);
    //         } else {
    //             $list_year[] = $value->year_level;
    //         }
    //     }
    //     return response()->json($list_year);
    // }

    public function year_level(Request $request)
    {
        $campus = $request->input('main_campus');
        $institute = $request->input('main_insti');
        $course = $request->input('main_course');

        $list_year = User::where('campus', $campus)
            ->where('institute', $institute)
            ->where('program_name', $course)
            ->whereNotNull('year_level')
            ->distinct()
            ->pluck('year_level')
            ->filter()
            ->values()
            ->toArray();

        return response()->json($list_year);
    }

    // public function section(Request $request)
    // {

    //     $campus = $request->main_campus;
    //     $institute = $request->main_insti;
    //     $course = $request->main_course;
    //     $year_level = $request->main_year;

    //     $year = User::select('section_name')
    //         ->where('campus', $campus)
    //         ->where('institute', $institute)
    //         ->where('program_name', $course)
    //         ->where('year_level', $year_level)
    //         ->groupBy('section_name')
    //         ->get();

    //     $list_year = [];
    //     foreach ($year as $key => $value) {
    //         if ($value->section_name == null) {
    //             unset($year[$key]);
    //         } else {
    //             $list_year[] = $value->section_name;
    //         }
    //     }
    //     return response()->json($list_year);
    // }

    public function section(Request $request)
    {
        $campus = $request->input('main_campus');
        $institute = $request->input('main_insti');
        $course = $request->input('main_course');
        $year_level = $request->input('main_year');

        $list_section = User::where('campus', $campus)
            ->where('institute', $institute)
            ->where('program_name', $course)
            ->where('year_level', $year_level)
            ->whereNotNull('section_name')
            ->distinct()
            ->pluck('section_name')
            ->filter()
            ->values()
            ->toArray();

        return response()->json($list_section);
    }

    // public function search(Request $request)
    // {

    //     $campus = $request->main_campus;
    //     $institute = $request->main_institute;
    //     $course = $request->main_course;
    //     $year_level = $request->main_year;
    //     $section = $request->main_section;

    //     $year_sem = YearSem::latest()->first();
    //     $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

    //     $students = User::where('campus',$campus)
    //         ->where('institute', $institute)
    //         ->where('program_name', $course)
    //         ->where('year_level', $year_level)
    //         ->where('section_name', $section)
    //         ->get();

    //     $studentIds = $students->pluck('id');
    //     $studentEvaluations = Evaluate::whereIn('user_id', $studentIds)
    //         ->where('year_sem', $new_year_sem)
    //         ->get();
    //     $new_data = [];
    //     foreach ($students as $key => $student) {

    //         $studentStatus = $studentEvaluations->where('user_id', $student->id)->pluck('status');
    //         $result = $studentStatus->isEmpty() ? false : $studentStatus->every(fn ($status) => $status == 1);

    //         $new_data[] = [
    //             'id' => $student->id,
    //             'name' => $student->name,
    //             'username' => $student->username,
    //             'institute' => $student->institute,
    //             'program_name' => $student->program_name,
    //             'section_name' => $student->section_name,
    //             'year_level' => $student->year_level,
    //             'sex' => $student->sex == 'F' ? 'Female' : 'Male',
    //             'status' => $result ? 'Done' : 'Pending',
    //             'actions' => !$result,
    //         ];
    //     }
    //     return response()->json($new_data);
    // }

    public function search(Request $request)
    {
        $campus = $request->input('main_campus');
        $institute = $request->input('main_institute');
        $course = $request->input('main_course');
        $year_level = $request->input('main_year');
        $section = $request->input('main_section');

        $year_sem = YearSem::latest()->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $students = User::where([
            'campus' => $campus,
            'institute' => $institute,
            'program_name' => $course,
            'year_level' => $year_level,
            'section_name' => $section,
        ])->get();

        $studentIds = $students->pluck('id')->toArray();

        $studentEvaluations = Evaluate::whereIn('user_id', $studentIds)
            ->where('year_sem', $new_year_sem)
            ->get();

        $evaluationStatus = $studentEvaluations->groupBy('user_id')
            ->map(fn ($evaluations) => $evaluations->every(fn ($eval) => $eval->status == 1));

        $new_data = $students->map(function ($student) use ($evaluationStatus) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'username' => $student->username,
                'institute' => $student->institute,
                'program_name' => $student->program_name,
                'section_name' => $student->section_name,
                'year_level' => $student->year_level,
                'sex' => ($student->sex == 'F') ? 'Female' : 'Male',
                'status' => $evaluationStatus->get($student->id, false) ? 'Done' : 'Pending',
                'actions' => !$evaluationStatus->get($student->id, false),
            ];
        });

        return response()->json($new_data);
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $student = User::find($id);

        if ($student === null) {
            return response()->json(['error' => 'Student not found']);
        }

        $status = $request->status;
        $student->load(['evaluate.faculties']);

        $faculty_table = '<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Faculty Name</th>
                                    <th>Institute</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>';

        if (count($student->evaluate) === 0) {

            $faculty_table .= '<tr>
                                <td colspan="3" class="text-center">No Data</td>
                            </tr>';
        } else {

            foreach ($student->evaluate as $value) {
                $faculty = $value->faculty;

                if ($faculty) {
                    $faculty_name = $faculty->last_name . ' ' . $faculty->first_name . ' ' . $faculty->middle_name;
                    $faculty_insti = $faculty->institute;
                    $span = ($value->status == 1) ? '<span class="badge text-bg-success">Done</span>' : '<span class="badge text-bg-warning">Pending</span>';
                } else {

                    $faculty_name = 'No Data';
                    $faculty_insti = 'No Data';
                    $span = 'No Data';
                }

                $faculty_table .= '<tr>
                                    <td>' . $faculty_name . '</td>
                                    <td>' . $faculty_insti . '</td>
                                    <td>' . $span . '</td>
                                </tr>';
            }
        }

        $faculty_table .= '</tbody>
                    </table>';

        // dd($faculty_table);

        return response()->json([
            'student' => $student,
            'status' => $status,
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
