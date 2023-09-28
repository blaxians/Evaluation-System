<?php

namespace App\Http\Controllers\Admin\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Student extends Controller
{
    public function index()
    {
        return view('pages.admin.student.index');
    }

    public function show()
    {
        $student = User::all();
        return response()->json($student);
    }
}
