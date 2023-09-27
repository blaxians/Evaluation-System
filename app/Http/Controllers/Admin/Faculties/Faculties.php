<?php

namespace App\Http\Controllers\Admin\Faculties;

use App\Http\Controllers\Controller;
use App\Models\Faculties as ModelsFaculties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Faculties extends Controller
{
    //

    public function index()
    {
        $faculties = ModelsFaculties::all();
        return view('pages.admin.faculties.index', compact('faculties'));
    }

    public function post(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'employee_id' => 'required|unique:faculties',
            'institute' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
        ]);


        if ($valid->fails()) {
            return response()->json($valid->messages());
        } else {
            $valid = $request->all();
            array_shift($valid);
            ModelsFaculties::create($valid);
            return response()->json('success');
        }
    }

    public function edit(Request $request, String $id)
    {

        $valid = Validator::make($request->all(), [
            'institute' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json($valid->messages());
        } else {
            $valid = $request->all();
            array_shift($valid);
            $faculties = ModelsFaculties::find($id);
            $faculties->institute = $valid['institute'];
            $faculties->first_name = $valid['first_name'];
            $faculties->middle_name = $valid['middle_name'];
            $faculties->last_name = $valid['last_name'];
            $faculties->update();
            return response()->json('success');
        }
    }
}
