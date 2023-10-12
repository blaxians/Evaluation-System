<?php

namespace App\Http\Controllers\Admin\Import;

use App\Models\User;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class Import extends Controller
{
    public function index()
    {
        return view('pages.admin.import.index');
    }

    public function import(Request $request)
    {
        // GET THE DATA OF EXCEL
        $excelData = (new UsersImport)->toArray($request->file('importedFile'));
        if ($excelData[0] == null) {
            return response()->json(['error', 'File is Empty']);
        } else {
            $data = $excelData[0];
            $uploaded_count = 0;
            foreach ($data as  $value) {
                $student = User::where('username', $value[1])->first();
                if ($student == null) {

                    User::create([
                        'name' => $value[0],
                        'username' => $value[1],
                        'password' => Hash::make($value[1]),
                        'role' => 'student'
                    ]);
                    $uploaded_count++;
                }
            }

            return response()->json(['message' => 'success', 'count' => $uploaded_count]);
        }
    }
}
