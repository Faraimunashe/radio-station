<?php

namespace App\Http\Controllers\Presenter;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\PlaylistMusic;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $playlists = Playlist::join('schedules', 'schedules.id', '=', 'playlists.schedule_id')
        ->select('playlists.id','playlists.title','playlists.status','schedules.title as schedule_title','schedules.start_time','schedules.end_time','schedules.date')
        ->where('playlists.user_id', Auth::id())
        ->orderBy("playlists.created_at","desc")->paginate(10);

        $employee = Employee::where('user_id', Auth::id())->first();
        if(is_null($employee))
        {
            return redirect()->back()->with('error', 'Employee not found');
        }

        $schedules = Schedule::where('presenter_id', $employee->id)
        ->orderBy("created_at","desc")
        ->whereDate('date', '>=', now()->toDateString())
        ->get();

        return view('presenter.playlist', [
            'playlists'=> $playlists,
            'schedules' => $schedules
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
                'title' => ['required','string'],
                'schedule_id'=> ['required','integer'],
            ]);

            $playlist = Playlist::where('user_id', Auth::id())
            ->where('schedule_id', $request->schedule_id)
            ->whereNot('status', 'DECLINED')
            ->first();

            if($playlist){
                return redirect()->back()->with('error','Playlist already exist in this schedule');
            }

            Playlist::create([
                'user_id' => Auth::id(),
                'schedule_id' => $request->schedule_id,
                'title' => $request->title,
                'status' => 'PENDING'
            ]);

            return redirect()->back()->with('success','Playlist created successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try{
            $playlist = Playlist::findOrFail($id);
            $playlist_music = PlaylistMusic::join('music', 'music.id', '=', 'playlist_music.music_id')
            ->select('playlist_music.id', 'music.name', 'music.album', 'music.title', 'music.artist', 'playlist_music.created_at')
            ->where('playlist_id', $id)->paginate(10);
            $musics = [];
            $search = $request->search;
            if(isset($search))
            {
                $musics = Music::where('artist', 'LIKE', '%'.$search.'%')
                ->orWhere('title', 'LIKE', '%'.$search.'%')
                ->get();
            }

            return view('presenter.show-playlist', [
                'playlist_musics' => $playlist_music,
                'playlist' => $playlist,
                'search' => $search,
                'musics' => $musics
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
        try{
            $request->validate([
                'music_id' => ['required','integer'],
                'playlist_id'=> ['required','integer'],
            ]);

            $playlist = Playlist::find($request->playlist_id);
            if($playlist->status != "PENDING")
            {
                return redirect()->back()->with('error', 'You cannot add songs to approved/rejected playlists');
            }

            $count = PlaylistMusic::where('playlist_id', $request->playlist_id)->count();
            $sequence = $count + 1;

            $pmusic = new PlaylistMusic();
            $pmusic->playlist_id = $request->playlist_id;
            $pmusic->music_id = $request->music_id;
            $pmusic->sequence = $sequence;
            $pmusic->save();

            return redirect()->route('playlists.show', $request->playlist_id)->with('success','Music attached successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $playlist = Playlist::find($id);
        $playlist->delete();
        return redirect()->back()->with('success','Playlist deleted successfully');
    }

    public function remove(Request $request)
    {
        try{
            $request->validate([
                'music_id' => ['required', 'integer']
            ]);

            $playlist_music = PlaylistMusic::where('music_id', $request->music_id)->first();
            $playlist_music->delete();

            return redirect()->back()->with('success', 'Track removed successfully');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
