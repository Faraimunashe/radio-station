<?php

namespace App\Http\Controllers\Ep;

use App\Events\EngineerScheduled;
use App\Events\PresenterScheduled;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Jingle;
use App\Models\Schedule;
use App\Models\ScheduleEngineer;
use App\Models\ScheduleJingle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schedules = Schedule::orderBy("created_at","desc")->paginate(10);
        $presenters = Employee::join('role_user', 'role_user.user_id', '=', 'employees.user_id')
        ->where('role_user.role_id', 4)
        ->get();

        $engineers = Employee::join('role_user', 'role_user.user_id', '=', 'employees.user_id')
        ->where('role_user.role_id', 5)
        ->get();

        $jingles = Jingle::all();

        return view('ep.schedule', [
            'schedules'=> $schedules,
            'presenters'=> $presenters,
            'engineers'=> $engineers,
            'jingles' => $jingles
        ]);
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
        try{
            $request->validate([
                'presenter_id' => ['required', 'integer'],
                'title' => ['required','string'],
                'start_time' => ['required', 'date_format:H:i'],
                'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
                'date' => ['required','date', 'after_or_equal:today'],
            ]);

            //dd($request->all());

            $startTimeObject = Carbon::createFromFormat('H:i', $request->start_time);

            $today = now()->format('Y-m-d');
            if($request->date == $today){
                if (!$startTimeObject->isAfter(now())) {
                    return redirect()->back()->with('error','The specified start time has lapsed.');
                }
            }

            $schedule = Schedule::create([
                'user_id' => Auth::id(),
                'presenter_id' => $request->presenter_id,
                'title' => $request->title,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'date'=> $request->date,
            ]);

            event(new PresenterScheduled($schedule));

            return redirect()->back()->with('success','Successfully created a schedule');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }


    public function add_jingle(Request $request)
    {
        try{
            $request->validate([
                'jingle_id' => ['required', 'integer'],
                'schedule_id' => [ 'required', 'integer']
            ]);

            $exist = ScheduleJingle::where('schedule_id', $request->schedule_id)->where('jingle_id', $request->jingle_id)->first();
            if(!is_null($exist))
            {
                return redirect()->back()->with('error', 'Jingle was already attached to this schedule');
            }
            $sj = new ScheduleJingle();
            $sj->schedule_id = $request->schedule_id;
            $sj->jingle_id = $request->jingle_id;
            $sj->save();

            return redirect()->back()->with('success', 'Successfully attached a jingle to a schedule');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comments = Comment::where('schedule_id', $id)->paginate(10);
        return view('ep.show-comment',[
            'comments' => $comments
        ]);
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

    public function engineer(Request $request)
    {
        try{
            $request->validate([
                'schedule_id' => ['required', 'integer'],
                'engineer_id' => ['required','integer'],
            ]);

            $schedule_engineer = ScheduleEngineer::create([
                'schedule_id' => $request->schedule_id,
                'engineer_id' => $request->engineer_id,
            ]);

            event(new EngineerScheduled($schedule_engineer));

            return redirect()->back()->with('success','Successfully allocated engineer');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
