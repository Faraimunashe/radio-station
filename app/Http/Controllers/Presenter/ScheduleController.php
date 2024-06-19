<?php

namespace App\Http\Controllers\Presenter;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Jingle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $presenter = Employee::where('user_id', Auth::id())->first();
            if(is_null($presenter))
            {
                return redirect()->back()->with('error', 'Invalid presenter id');
            }
            $schedules = Schedule::where('presenter_id', $presenter->id)
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->paginate(10);

            return view('presenter.schedule', [
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
        try{
            $jingles = Jingle::join('schedule_jingles', 'schedule_jingles.jingle_id', '=', 'jingles.id')
            ->where('schedule_jingles.schedule_id', $id)
            ->paginate(10);

            //dd($jingles);
            return view('presenter.show-jingles', [
                'jingles' => $jingles
            ]);
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
