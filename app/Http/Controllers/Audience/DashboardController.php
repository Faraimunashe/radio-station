<?php

namespace App\Http\Controllers\Audience;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
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
        $shows = Schedule::orderBy("created_at","desc")->paginate(10);
        return view('audience.dashboard', [
            'shows' => $shows
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
    public function comment(Request $request)
    {
        try{
            $request->validate([
                'schedule_id' => ['required', 'integer'],
                'message' => ['required', 'string']
            ]);

            $comment = new Comment();
            $comment->user_id = Auth::id();
            $comment->schedule_id = $request->schedule_id;
            $comment->message = $request->message;
            $comment->save();

            return redirect()->back()->with('success', 'Comment added successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function like(string $id)
    {
        try{
            $exist = Like::where('user_id', Auth::id())->where('schedule_id', $id)->first();
            if(!is_null($exist))
            {
                return redirect()->back()->with('error', 'Already voted for this show!');
            }

            $like = new Like();
            $like->user_id = Auth::id();
            $like->schedule_id = $id;
            $like->save();

            return redirect()->back()->with('success', 'Successfully liked');
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
