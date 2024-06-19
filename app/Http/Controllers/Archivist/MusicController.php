<?php

namespace App\Http\Controllers\Archivist;

use App\Http\Controllers\Controller;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $musics = Music::paginate(10);
        $search = $request->search;

        if (isset($search)) {
            $musics = Music::where("title","like","%".$search."%")
            ->orWhere("artist","like","%".$search."%")
            ->orWhere("album","like","%".$search."%")
            ->paginate(10);
        }

        return view('archivist.music', [
            'musics'=> $musics
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
                'music' => ['required', 'file'],
                'artist' => ['required', 'string'],
                'title' => ['required', 'string'],
                'album' => ['required', 'string']
            ]);

            $file = $request->file('music');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->music->move(public_path('music'), $filename);

            Music::create([
                'user_id' => Auth::id(),
                'name' => $filename,
                'artist' => $request->artist,
                'title' => $request->title,
                'album'=> $request->album,
            ]);

            return redirect()->back()->with('success','Successfully uploaded music');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        try{
            $request->validate([
                'artist' => ['required', 'string'],
                'title' => ['required', 'string'],
                'album' => ['required', 'string']
            ]);

            Music::find($id)->update([
                'artist' => $request->artist,
                'title' => $request->title,
                'album'=> $request->album,
            ]);

            return redirect()->back()->with('success','Successfully updated music');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            Music::find($id)->delete();

            return redirect()->back()->with('success','Successfully deleted music');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
