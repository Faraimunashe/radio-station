<?php

namespace App\Http\Controllers\Eng;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $eng = Employee::where('user_id', Auth::id())->first();
            if(is_null($eng))
            {
                return redirect()->back()->with('error', 'Invalid presenter id');
            }

            $schedules = Schedule::join('schedule_engineers', 'schedule_engineers.schedule_id', '=', 'schedules.id')
            ->where('schedule_engineers.engineer_id', $eng->id)
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->paginate(10);

            return view('eng.dashboard', [
                'schedules'=> $schedules
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
