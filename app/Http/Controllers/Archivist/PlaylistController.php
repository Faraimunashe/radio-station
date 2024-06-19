<?php

namespace App\Http\Controllers\Archivist;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\PlaylistMusic;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $playlists = Playlist::join('schedules', 'schedules.id', '=', 'playlists.schedule_id')
        ->select('playlists.id', 'playlists.user_id', 'playlists.status', 'schedules.title as schedule_title', 'playlists.title')
        ->paginate(10);

        return view('archivist.playlist', [
            'playlists'=> $playlists
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $playlist = Playlist::findOrFail($id);
            $playlist_music = PlaylistMusic::join('music', 'music.id', '=', 'playlist_music.music_id')
            ->select('playlist_music.id', 'music.name', 'music.album', 'music.title', 'music.artist', 'playlist_music.created_at')
            ->where('playlist_id', $id)->paginate(10);

            return view('archivist.show-playlist', [
                'playlist_musics' => $playlist_music,
                'playlist' => $playlist
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
        $request->validate([
            'status' => ['required', 'string']
        ]);

        try{
            $playlist = Playlist::find($id);
            $playlist->status = $request->status;
            $playlist->save();

            return redirect()->back()->with('success', 'Successfully updated playlist status');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
