<?php

namespace App\Http\Controllers\Admin\Faculties;

use App\Http\Controllers\Controller;
use App\Models\Faculties as ModelsFaculties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Faculties extends Controller
{
    //Show all Faculties
    public function index()
    {
        return view('pages.admin.faculties.index');
    }

    // Show all faculties
    public function show()
    {
        $faculties = ModelsFaculties::all();
        $table = '';
        if(count($faculties)>0){
            $table .= '<table class="table bg-white rounded shadow-sm  table-hover" id="table">
                        <thead>
                            <tr>
                                <th scope="col" width="50"></th>
                                <th scope="col">Last Name</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Middle Name</th>
                                <th scope="col">Institute</th>
                                <th scope="col" width="30px">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

                            foreach ($faculties as $key => $facultie){
                                $table .= '<tr>
                                            <td>'.intval($key+1).'</td>
                                            <td>'.$facultie->last_name.'</td>
                                            <td>'.$facultie->first_name.'</td>
                                            <td>'.$facultie->middle_name.'</td>
                                            <td>'.$facultie->institute.'</td></td>
                                            <td>
                                                <button class="btn btn-secondary btn-sm" id="faculties_btn_edit" data-id="'.$facultie->id.'">Edit</button>
                                            </td>
                                        </tr>';
                            }

            $table .= '</tbody></table>';
        }
        echo $table;
    }

    // Create a new Faculties
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

    public function view(Request $request)
    {
        $id = $request->id;
        $faculties = ModelsFaculties::find($id);

        if ($faculties === null) {
            return response()->json(['error' => 'Faculties not found']);
        } else {
            return response()->json($faculties);
        }
    }
    // Edit the Faculties details
    public function edit(Request $request)
    {
        $id = $request->id;
        $valid = Validator::make($request->all(), [
            'institute' => 'required',
            'employee_id' => 'required',
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
            $faculties->employee_id = $valid['employee_id'];
            $faculties->first_name = $valid['first_name'];
            $faculties->middle_name = $valid['middle_name'];
            $faculties->last_name = $valid['last_name'];
            $faculties->update();
            return response()->json('success');
        }
    }

    // Active the faculties
    public function active(String $id)
    {
        $faculty = ModelsFaculties::find($id);
        if ($faculty === null) {
            return response()->json(['error' => 'faculties not found']);
        } else {
            $faculty->status = 'active';
            $faculty->update();
            return response()->json('success');
        }
    }

    // Inactive or disable the faculties
    public function inActive(String $id)
    {
        $faculty = ModelsFaculties::find($id);
        if ($faculty === null) {
            return response()->json(['error' => 'faculties not found']);
        } else {
            $faculty->status = 'inactive';
            $faculty->update();
            return response()->json('success');
        }
    }
}