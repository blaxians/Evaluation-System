<?php

namespace App\Http\Controllers\Admin\Institute;

use App\Models\YearSem;
use App\Models\Question;
use App\Models\Faculties;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Institute extends Controller
{
    public function index()
    {
        return view('pages.admin.institute.index');
    }

    public function select(Request $request)
    {
        // $insitute = $request->insitute;
        $insitute = 'College of Agriculture';
        $array = [];

        $faculties = Faculties::where('institute', $insitute)->get();
        $critiria = [
            1 => [
                [
                    1 => ['count' => 0, 'percent' => 0, 'names' => []],
                    2 => ['count' => 0, 'percent' => 0, 'names' => []],
                    3 => ['count' => 0, 'percent' => 0, 'names' => []],
                    4 => ['count' => 0, 'percent' => 0, 'names' => []],
                    5 => ['count' => 0, 'percent' => 0, 'names' => []],
                ]
            ],
            2 => [
                [
                    1 => ['count' => 0, 'percent' => 0, 'names' => []],
                    2 => ['count' => 0, 'percent' => 0, 'names' => []],
                    3 => ['count' => 0, 'percent' => 0, 'names' => []],
                    4 => ['count' => 0, 'percent' => 0, 'names' => []],
                    5 => ['count' => 0, 'percent' => 0, 'names' => []],
                ]
            ],
            3 => [
                [
                    1 => ['count' => 0, 'percent' => 0, 'names' => []],
                    2 => ['count' => 0, 'percent' => 0, 'names' => []],
                    3 => ['count' => 0, 'percent' => 0, 'names' => []],
                    4 => ['count' => 0, 'percent' => 0, 'names' => []],
                    5 => ['count' => 0, 'percent' => 0, 'names' => []],
                ]
            ],
            4 => [
                [
                    1 => ['count' => 0, 'percent' => 0, 'names' => []],
                    2 => ['count' => 0, 'percent' => 0, 'names' => []],
                    3 => ['count' => 0, 'percent' => 0, 'names' => []],
                    4 => ['count' => 0, 'percent' => 0, 'names' => []],
                    5 => ['count' => 0, 'percent' => 0, 'names' => []],
                ]
            ],
            5 => [
                [
                    1 => ['count' => 0, 'percent' => 0, 'names' => []],
                    2 => ['count' => 0, 'percent' => 0, 'names' => []],
                    3 => ['count' => 0, 'percent' => 0, 'names' => []],
                    4 => ['count' => 0, 'percent' => 0, 'names' => []],
                    5 => ['count' => 0, 'percent' => 0, 'names' => []],
                ]
            ],
            6 => [
                [
                    1 => ['count' => 0, 'percent' => 0, 'names' => []],
                    2 => ['count' => 0, 'percent' => 0, 'names' => []],
                    3 => ['count' => 0, 'percent' => 0, 'names' => []],
                    4 => ['count' => 0, 'percent' => 0, 'names' => []],
                    5 => ['count' => 0, 'percent' => 0, 'names' => []],
                ]
            ]
        ];


        foreach ($faculties as  $faculty) {

            $year_sem = YearSem::orderBy('id', 'DESC')->first();
            $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;
            $evaluates = $faculty->evaluate->where('year_sem', $new_year_sem)->where('status', 1);
            foreach ($evaluates as $value) {

                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {
                    $answer = $evaluation_value->score;
                    $question = Question::find($evaluation_value->question_id);
                    if ($question->criteria == "Teacher's Personality") {
                        $store = $critiria[1][0][$answer];
                        $store['count']++;
                        dd($store['names']);
                    } else  if ($question->criteria == "Classroom Management") {
                    } else  if ($question->criteria == "Knowledge of the Subject Matter") {
                    } else  if ($question->criteria == "Teaching Skills") {
                    } else  if ($question->criteria == "Skills in Evaluating the Students") {
                    } else {
                    }
                }
            }
        }
        return response()->json([
            'top' => $array,
        ]);
    }
}
