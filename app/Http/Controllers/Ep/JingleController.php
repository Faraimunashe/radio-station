<?php

namespace App\Http\Controllers\Ep;

use App\Http\Controllers\Controller;
use App\Models\Jingle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JingleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jingles = Jingle::paginate(10);
        $search = $request->search;

        if (isset($search)) {
            $jingles = Jingle::where("title","like","%".$search."%")
            ->paginate(10);
        }

        return view('ep.jingles', [
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
                'music' => ['required', 'file'],
                'title' => ['required', 'string']
            ]);

            $file = $request->file('music');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->music->move(public_path('music/jingles'), $filename);

            $jingle = new Jingle();
            $jingle->user_id = Auth::id();
            $jingle->title = $request->title;
            $jingle->name = $filename;
            $jingle->save();

            return redirect()->back()->with('success','Successfully uploaded a jingle');
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
