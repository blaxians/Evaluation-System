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
            unlink(public_path('storage/student_file.csv'));
            $excel = $request->file('importedFile');
            $name = 'student_file.csv';
            Storage::disk('public')->putFileAs($excel, $name);

            // papuntahin mo ditt sa route name na insertStudent.post
            return response()->json('success');
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
                $records = $chunk->map(function ($row) {
                    $user = User::where('username', $row[0])->first();
                    if ($user == null) {
                        return [
                            'name' => $row[1] . " " . $row[2] . " " . $row[3],
                            'username' => $row[0],
                            'password' => $row[0],
                            'role' => 'student'
                        ];
                    }
                })->ToArray();
                $filteredArray = array_filter($records, function ($value) {
                    return !is_null($value);
                });
                DB::table('users')->insert($filteredArray);
            });

        // return ka uli sa import route
        return response()->json('success');
    }
}
