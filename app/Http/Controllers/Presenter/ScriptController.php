<?php

namespace App\Http\Controllers\Presenter;

use App\Http\Controllers\Controller;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scripts = Script::where('user_id', Auth::id())->paginate(10);

        return view('presenter.script', [
            'scripts'=> $scripts
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
                'document'=> ['required','file', 'mimes:docx,pdf'],
            ]);

            $file = $request->file('document');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->document->move(public_path('documents/scripts'), $filename);

            $script = new Script();
            $script->user_id = Auth::id();
            $script->title = $request->title;
            $script->file = $filename;
            $script->save();

            return redirect()->back()->with('success','Script created successfully');
        }catch(\Exception $e){
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
                'title' => ['required','string'],
                'document'=> ['required','file', 'mimes:docx,pdf'],
            ]);

            $file = $request->file('document');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $request->music->move(public_path('scripts'), $filename);

            $script = Script::find( $id );
            $script->title = $request->title;
            $script->file = $filename;
            $script->save();

            return redirect()->back()->with('success','Script updated successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{

            $script = Script::find( $id );
            $script->delete();

            return redirect()->back()->with('success','Script deleted successfully');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
