<?php

namespace App\Http\Controllers\Archivist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('archivist.dashboard');
    }
}
