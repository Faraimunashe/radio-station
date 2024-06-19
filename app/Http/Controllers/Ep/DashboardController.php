<?php

namespace App\Http\Controllers\Ep;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('ep.dashboard', [

        ]);
    }
}
