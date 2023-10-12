<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Question;
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
            return response()->json(['error'=>$validatator->messages()]);
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

                    if($year_sem->semester==2 && $valid['semester']==1)
                    {
                        return response()->json(['error' => 'Semester is cant back set']);
                    }else{
                        $year_sem->semester = $valid['semester'];
                        $year_sem->update();
                        return response()->json('success');

                    }
                  
                }
            }
        }
    }

}
