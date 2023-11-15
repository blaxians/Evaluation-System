<?php

namespace App\Http\Controllers\Admin\Rated;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Rated extends Controller
{
    public function index()
    {
        return view('pages.admin.rated.index');
    }
    public function rated(Request $request)
    {
    }
}