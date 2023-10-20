<?php

namespace App\Http\Controllers\Admin\Import;

use App\Models\User;

use Maatwebsite\Excel\Concerns\ToArray;
use Spatie\Async\Pool;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\returnArgument;

class Import extends Controller
{
    public function index()
    {
        return view('pages.admin.import.index');
    }

    public function import(Request $request)
    {

        if ($request->hasFile('importedFile')) {
            try {
                $excel = $request->file('importedFile');
                $name = 'student_file.csv';
                Storage::disk('public')->delete('student_file.csv'); // Delete the existing file if it exists
                Storage::disk('public')->putFileAs('', $excel, $name); // Store the new file

                // Redirect or return a response to the desired route
                return response()->json('success');
            } catch (\Throwable $th) {
                // Handle any exceptions or errors here
                return response()->json(['error' => 'An error occurred while processing the file']);
            }
        } else {
            return response()->json(['error' => 'Invalid input']);
        }
    }

    public function insertStudent()
    {
        DB::disableQueryLog();
        LazyCollection::make(function () {
            $handle = fopen(public_path('storage/student_file.csv'), 'r');
            while (($line = fgetcsv($handle, 4096)) != false) {
                $dataString = implode(', ', $line);
                $row = explode(',', $dataString);
                yield ($row);
            }
            fclose($handle);
        })
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) {
                $new_student = $chunk->map(function ($row) {
                    foreach ($row as $key => $value) {
                        if ($value == " ") {
                            unset($row[$key]);
                        }
                    }
                    $new_row =  array_values($row);

                    return [
                        'name' => strtolower(trim($new_row[1])) . " " . strtolower(trim($new_row[2])) . " " . strtolower(trim($new_row[3])),
                        'username' => trim($new_row[0]),
                        'password' => trim($new_row[0]),
                        'role' => 'student',
                        'campus' => trim($new_row[4]),
                        'institute' => trim($new_row[5]),
                        'program_name' => trim($new_row[6]),
                        'section_name' => trim($new_row[7]),
                        'year_level' => trim($new_row[8]),
                        'sex' => trim($new_row[9]),
                    ];
                })->ToArray();

                $filteredArray = array_filter($new_student, function ($value) {
                    return !is_null($value);
                });

                foreach ($filteredArray as $value) {
                    $student = User::where('username', $value['username'])->first();
                    if ($student == null) {
                        User::create($value);
                    } else {
                        $student->name = $value['name'];
                        $student->campus = $value['campus'];
                        $student->institute = $value['institute'];
                        $student->program_name = $value['program_name'];
                        $student->section_name = $value['section_name'];
                        $student->year_level = $value['year_level'];
                        $student->update();
                    }
                }
            });

        // return ka uli sa import route
        return response()->json('success');
    }
}
