<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\YearSem;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $year_sem = YearSem::latest()->first();
        return view('pages.admin.dasboard.index', compact('year_sem'));
    }
}
