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


    public function statistic()
    {

        $total_faculties = count(Faculties::all());
        $total_students = count(User::where('role', 'student')->get());

        $total_per_institute = [];
        $total_per_institute[0] = count(Faculties::where('institute', 'College of Agriculture')->get());
        $total_per_institute[1] = count(Faculties::where('institute', 'Institute of Arts and Science')->get());
        $total_per_institute[2] = count(Faculties::where('institute', 'Institute of Engineering and Applied Technology')->get());
        $total_per_institute[3] = count(Faculties::where('institute', 'Institute of Education')->get());
        $total_per_institute[5] = count(Faculties::where('institute', 'Institute of Management')->get());


        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $user = User::where('role', '!=', 'admin')->get();

        //Done and Pending
        // [Done,Pending]
        $dean = [0, 0];
        $student = [0, 0];
        foreach ($user as $value) {
            if ($value->role == 'student') {
                $evaluate = Evaluate::where('user_id', $value->id)->where('year_sem', $new_year_sem)->get();
                $true = true;
                if (count($evaluate) == 0) {
                    $true = false;
                } else {
                    foreach ($evaluate as $evaluate_value) {
                        if ($evaluate_value->status == 0) {
                            $true = false;
                        }
                    }
                }

                if ($true == true) {
                    $student[0]++;
                } else {
                    $student[1]++;
                }
            } else {
                $evaluate = Evaluate::where('user_id', $value->id)->where('year_sem', $new_year_sem)->get();
                $true = true;
                if (count($evaluate) == 0) {
                    $true = false;
                } else {
                    foreach ($evaluate as $evaluate_value) {
                        if ($evaluate_value->status == 0) {
                            $true = false;
                        }
                    }
                }

                if ($true) {
                    $dean[0]++;
                } else {
                    $dean[1]++;
                }
            }
        }
    }
}
