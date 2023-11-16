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
        $faculties = Faculties::where('institute', $insitute)->get();
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;


        $criteria = [
            [
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []]
            ],
            [
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []]
            ],
            [
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []]
            ],
            [
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []]
            ],
            [
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []]
            ],
            [
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []],
                ['names' => []]
            ],

        ];


        $hps = [0, 0, 0, 0, 0, 0];
        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $hps[0]++;
            } else if ($value->criteria === "Classroom Management") {
                $hps[1]++;
            } else if ($value->criteria === "Knowledge of the Subject Matter") {
                $hps[2]++;
            } else if ($value->criteria === "Teaching Skills") {
                $hps[3]++;
            } else if ($value->criteria === "Skills in Evaluating the Students") {
                $hps[4]++;
            } else if ($value->criteria === "Attitude towards the Subject and the Students") {
                $hps[5]++;
            }
        }

        foreach ($hps as $key => $value) {
            $hps[$key] = $value * 5;
        }

        foreach ($faculties as  $faculty) {
            $evaluates = $faculty->evaluate->where('year_sem', $new_year_sem)->where('status', 1);
            $score = [
                1 => 0,
                2 => 0,
                3 => 0,
                4 => 0,
                5 => 0,
                6 => 0,
            ];


            $participant = 0;
            foreach ($evaluates as $value) {
                $participant++;
                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {
                    $answer = $evaluation_value->score;
                    $question = Question::find($evaluation_value->question_id);
                    if ($question->criteria == "Teacher's Personality") {
                        $score[1] += $answer;
                    } else  if ($question->criteria == "Classroom Management") {
                        $score[2] += $answer;
                    } else  if ($question->criteria == "Knowledge of the Subject Matter") {
                        $score[3] += $answer;
                    } else  if ($question->criteria == "Teaching Skills") {
                        $score[4] += $answer;
                    } else  if ($question->criteria == "Skills in Evaluating the Students") {
                        $score[5] += $answer;
                    } else {
                        $score[6] += $answer;
                    }
                }
            }


            $name = $faculty->last_name . ' ' . $faculty->middle_name . ' ' . $faculty->first_name;
            foreach ($score as $key => $value) {

                if ($participant != 0) {
                    $formula = (intVal($value) / $hps[0]) * 100 / $participant;
                }
                if ($formula <= 100 && $formula >= 90) {
                    if (!in_array($name, $criteria[$key - 1][0]['names'])) {
                        array_push($criteria[$key - 1][0]['names'], $name);
                    }
                } else if ($formula <= 89 && $formula >= 85) {
                    if (!in_array($name, $criteria[$key - 1][1]['names'])) {
                        array_push($criteria[$key - 1][1]['names'], $name);
                    }
                } else if ($formula <= 84 && $formula >= 80) {
                    if (!in_array($name, $criteria[$key - 1][2]['names'])) {
                        array_push($criteria[$key - 1][2]['names'], $name);
                    }
                } else if ($formula <= 79 && $formula >= 75) {
                    if (!in_array($name, $criteria[$key - 1][3]['names'])) {
                        array_push($criteria[$key - 1][3]['names'], $name);
                    }
                } else {
                    if (!in_array($name, $criteria[$key - 1][4]['names'])) {
                        array_push($criteria[$key - 1][4]['names'], $name);
                    }
                }
            }
        }


        $total_faculty = count($faculties);
        foreach ($criteria as $key => $value) {
            foreach ($value as $keys => $values) {
                $count = count($values['names']);
                $percent = $count / $total_faculty * 100;
                $criteria[$key][$keys]['percent'] = $percent;
                $criteria[$key][$keys]['count'] = $count;
            }
        }

        return response()->json([
            'data' => $criteria,
            'total_faculty' => count($faculties),
        ]);
    }
}
