<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Evaluate;
use App\Models\Faculties;
use App\Models\Question;
use App\Models\User;
use App\Models\YearSem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Controller
{
    public function index()
    {
        return view('pages.admin.dasboard.index');
    }

    public function show()
    {
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        return response()->json($year_sem);
    }


    // Add School Year
    public function post(Request $request)
    {

        $validatator = Validator::make($request->all(), [
            'year' => 'required|unique:year_sems',
        ]);

        if ($validatator->fails()) {
            return response()->json(['error' => $validatator->messages()]);
        } else {
            $valid = $request->all();

            array_shift($valid);
            $year_sem = new YearSem();
            $year_sem->year = $valid['year'];
            $year_sem->semester = 1;
            $year_sem->save();
            return response()->json('success');
        }
    }


    // Edit the Semester
    public function edit(Request $request)
    {

        $id = $request->id;
        $year_sem = YearSem::find($id);
        if ($year_sem === null) {
            return response()->json(['error' => 'School Year not found']);
        } else {

            $validatator = Validator::make($request->all(), [
                'semester' => 'required',
            ]);

            if ($validatator->fails()) {
                return response()->json(['error' => $validatator->messages()]);
            } else {
                $valid = $request->all();

                if ($year_sem->semester == $valid['semester']) {
                    return response()->json(['error' => 'Semester is already set']);
                } else {

                    if ($year_sem->semester == 2 && $valid['semester'] == 1) {
                        return response()->json(['error' => 'Semester is cant back set']);
                    } else {
                        $year_sem->semester = $valid['semester'];
                        $year_sem->update();
                        return response()->json('success');
                    }
                }
            }
        }
    }


    //stats

    public function statistic()
    {
        $user = User::with('evaluate')->where('role', '!=', 'admin')->get();

        $total_faculties = Faculties::count();
        $total_students = User::where('role', 'student')->count();

        $institutes = ['College of Agriculture', 'Institute of Arts and Science', 'Institute of Engineering and Applied Technology', 'Institute of Education', 'Institute of Management'];

        $total_per_institute = [];

        foreach ($institutes as $institute) {
            $total_per_institute[] = Faculties::where('institute', $institute)->count();
        }

        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $dean = [0, 0];
        $student = [0, 0];

        foreach ($user as $value) {
            $evaluate = $value->evaluate->where('year_sem', $new_year_sem);
            $true = $evaluate->isNotEmpty() && $evaluate->every(function ($evaluate_value) {
                return $evaluate_value->status != 0;
            });

            if ($value->role == 'student') {
                $student[$true ? 0 : 1]++;
            } else {
                $dean[$true ? 0 : 1]++;
            }
        }

        $number_format_faculty = number_format($total_faculties);
        $number_format_students = number_format($total_students);
        return response()->json([
            'total_faculty' => $number_format_faculty,
            'total_student' => $number_format_students,
            'total_institute' => $total_per_institute,
            'dean' => $dean,
            'student' => $student,
        ]);
    }
}
