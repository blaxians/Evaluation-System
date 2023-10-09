<?php

namespace App\Http\Controllers\Admin\Report;

use App\Models\YearSem;
use App\Models\Faculties;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Evaluate;
use App\Models\Evaluation;
use App\Models\Question;
use App\Models\User;

class Report extends Controller
{

    public function index()
    {
        return view('pages.admin.report.index');
    }
    public function show($id)
    {
        $year_sem = YearSem::orderBy('id', 'DESC')->first();
        $new_year_sem = $year_sem->year . ' ' . $year_sem->semester;

        $faculties = Faculties::where('institute', $id)->get();

        //  gayahin mo lang ung show ng student para sa table

    }

    // eto link para sa evaluation ng student
    public function viewFromStudent(Request $request)
    {
        $id = $request->id;
        $faculties = Faculties::find($id);
        $evaluates = $faculties->evaluate;

        $score = [];
        foreach ($evaluates as $value) {
            $user = User::find($value->user_id);
            if ($user->role === 'student') {

                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {

                    $question = Question::find($evaluation_value->question_id);

                    if (array_key_exists($question->criteria, $score)) {
                        $score[$question->criteria] += intVal($evaluation_value->score);
                    } else {
                        $score[$question->criteria] = intVal($evaluation_value->score);
                    }
                }
            }
        }

        $q1 = 0;
        $q2 = 0;
        $q3 = 0;
        $q4 = 0;
        $q5 = 0;
        $q6 = 0;

        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $q1++;
            } else if ($value === "Classroom Management") {
                $q2++;
            } else if ($value === "Knowledge of the Subject Matter") {
                $q3++;
            } else if ($value === "Teaching Skills") {
                $q4++;
            } else if ($value === "Skills in Evaluating the Students") {
                $q5++;
            } else if ($value === "Attitude towards the Subject and the Students") {
                $q6++;
            }
        }

        $computation = [];
        foreach ($score as $key => $value) {
            if ($key === "Teacher's Personality") {
                $percent = 10;
                $formula = intVal($value) / $q1 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Classroom Management") {
                $percent = 10;
                $formula = intVal($value) / $q2 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Knowledge of the Subject Matter") {
                $percent = 20;
                $formula = intVal($value) / $q3 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Teaching Skills") {
                $percent = 20;
                $formula = intVal($value) / $q4 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Skills in Evaluating the Students") {
                $percent = 20;
                $formula = intVal($value) / $q5 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Attitude towards the Subject and the Students") {
                $percent = 20;
                $formula = intVal($value) / $q6 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            }
        }

        return response()->json(['faculties' => $faculties, 'computation' => $computation]);
    }
    // eto link para sa evaluation ng dean
    public function viewFromDean(Request $request)
    {
        $id = $request->id;
        $faculties = Faculties::find($id);
        $evaluates = $faculties->evaluate;


        $score = [];
        foreach ($evaluates as $value) {
            $user = User::find($value->user_id);
            if ($user->role === 'dean') {

                $evaluation = Evaluation::where('evaluate_id', $value->id)->get();
                foreach ($evaluation as  $evaluation_value) {

                    $question = Question::find($evaluation_value->question_id);

                    if (array_key_exists($question->criteria, $score)) {
                        $score[$question->criteria] += intVal($evaluation_value->score);
                    } else {
                        $score[$question->criteria] = intVal($evaluation_value->score);
                    }
                }
            }
        }


        $q1 = 0;
        $q2 = 0;
        $q3 = 0;
        $q4 = 0;
        $q5 = 0;
        $q6 = 0;

        $question = Question::all();
        foreach ($question as $value) {
            if ($value->criteria === "Teacher's Personality") {
                $q1++;
            } else if ($value === "Classroom Management") {
                $q2++;
            } else if ($value === "Knowledge of the Subject Matter") {
                $q3++;
            } else if ($value === "Teaching Skills") {
                $q4++;
            } else if ($value === "Skills in Evaluating the Students") {
                $q5++;
            } else if ($value === "Attitude towards the Subject and the Students") {
                $q6++;
            }
        }

        $computation = [];
        foreach ($score as $key => $value) {
            if ($key === "Teacher's Personality") {
                $percent = 10;
                $formula = intVal($value) / $q1 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Classroom Management") {
                $percent = 10;
                $formula = intVal($value) / $q2 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Knowledge of the Subject Matter") {
                $percent = 20;
                $formula = intVal($value) / $q3 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Teaching Skills") {
                $percent = 20;
                $formula = intVal($value) / $q4 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Skills in Evaluating the Students") {
                $percent = 20;
                $formula = intVal($value) / $q5 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            } else if ($key === "Attitude towards the Subject and the Students") {
                $percent = 20;
                $formula = intVal($value) / $q6 * $percent;
                $equivalent = '';
                if ($formula >= 100 && $formula <= 90) {
                    $equivalent = 'Outstanding';
                } else if ($formula >= 89 && $formula <= 85) {
                    $equivalent = 'Very Satisfactory';
                } else if ($formula >= 84 && $formula <= 80) {
                    $equivalent = 'Satisfactory';
                } else if ($formula >= 79 && $formula <= 75) {
                    $equivalent = 'Fairly Satisfactory';
                } else {
                    $equivalent = 'Needs Improvement';
                }
                $computation[$key] = [$value, $percent, $formula, $equivalent];
            }
        }

        return response()->json(['faculties' => $faculties, 'computation' => $computation]);
    }
}
