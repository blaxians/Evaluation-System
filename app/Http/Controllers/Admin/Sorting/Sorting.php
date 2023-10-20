<?php

namespace App\Http\Controllers\Admin\Sorting;

use App\Models\User;
use App\Models\YearSem;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Sorting extends Controller
{


    public function index(Request $request)
    {
        // return mo dito ung sorting.blade.php
        return view();
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

    public function institute($params)
    {
        $institute = User::select('institute')
            ->where('campus', $params)
            ->groupBy('institute')
            ->get();
        $list_institute = [];
        foreach ($institute as $key => $value) {
            if ($value->institute == null) {
                unset($institute[$key]);
            } else {
                $list_institute[] = $value->institute;
            }
        }
        return response()->json($list_institute);
    }
    public function courses($params)
    {
        $data = explode(',', $params);
        $courses = User::select('program_name')
            ->where('campus', $data[0])
            ->where('institute', $data[1])
            ->groupBy('program_name')
            ->get();

        $list_course = [];
        foreach ($courses as $key => $value) {
            if ($value->program_name == null) {
                unset($courses[$key]);
            } else {
                $list_course[] = $value->program_name;
            }
        }
        return response()->json($list_course);
    }
    public function year_level($params)
    {
        $data = explode(',', $params);
        $year = User::select('year_level')
            ->where('campus', $data[0])
            ->where('institute', $data[1])
            ->where('program_name', $data[2])
            ->groupBy('year_level')
            ->get();
        $list_year = [];
        foreach ($year as $key => $value) {
            if ($value->year_level == null) {
                unset($year[$key]);
            } else {
                $list_year[] = $value->year_level;
            }
        }
        return response()->json($list_year);
    }
    public function section($params)
    {
        $data = explode(',', $params);

        $year = User::select('section_name')
            ->where('campus', $data[0])
            ->where('institute', $data[1])
            ->where('program_name', $data[2])
            ->where('year_level', $data[3])
            ->groupBy('section_name')
            ->get();

        $list_year = [];
        foreach ($year as $key => $value) {
            if ($value->section_name == null) {
                unset($year[$key]);
            } else {
                $list_year[] = $value->section_name;
            }
        }
        return response()->json($list_year);
    }
    public function search($params)
    {
        $year_sem = YearSem::latest()->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;
        $data = explode(',', $params);

        $students = User::where('campus', $data[0])
            ->where('institute', $data[1])
            ->where('program_name', $data[2])
            ->where('year_level', $data[3])
            ->where('section_name', $data[4])
            ->get();

        $studentIds = $students->pluck('id');
        $studentEvaluations = Evaluate::whereIn('user_id', $studentIds)
            ->where('year_sem', $new_year_sem)
            ->get();
        $new_data = [];
        foreach ($students as $key => $student) {

            $studentStatus = $studentEvaluations->where('user_id', $student->id)->pluck('status');
            $result = $studentStatus->isEmpty() ? false : $studentStatus->every(fn ($status) => $status == 1);

            $new_data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'username' => $student->username,
                'institute' => $student->institute,
                'program_name' => $student->program_name,
                'section_name' => $student->section_name,
                'year_level' => $student->year_level,
                'sex' => $student->sex == 'F' ? 'Female' : 'Male',
                'status' => $result ? 'Done' : 'Pending',
                'actions' => !$result,
            ];
        }
        return response()->json($new_data);
    }
}
