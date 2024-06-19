<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatorController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('admin'))
        {
            return redirect()->route('admin-dashboard');
        }elseif(Auth::user()->hasRole('archivist')){
            return redirect()->route('archivist-dashboard');
        }elseif(Auth::user()->hasRole('ep')){
            return redirect()->route('ep-dashboard');
        }elseif(Auth::user()->hasRole('presenter')){
            return redirect()->route('presenter-dashboard');
        }elseif(Auth::user()->hasRole('audience')){
            return redirect()->route('audience-dashboard');
        }elseif(Auth::user()->hasRole('engineer')){
            return redirect()->route('eng-dashboard');
        }
    }
}
