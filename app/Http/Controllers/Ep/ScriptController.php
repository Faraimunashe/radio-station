<?php

namespace App\Http\Controllers\Ep;

use App\Http\Controllers\Controller;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $scripts = Script::orderBy("id","desc")->paginate(10);
        $search = $request->search;
        if(isset($search)) {
            $scripts = Script::where("status","LIKE","%". $search ."%")
            ->orWhere("title","LIKE","%". $search ."%")
            ->paginate(10);
        }

        return view('ep.script', [
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
                'script_id' => ['required','integer'],
                'status' => ['required', 'string']
            ]);

            $script = Script::find($request->script_id);
            if(is_null($script)){
                return redirect()->back()->with('error','Script not found');
            }
            $script->status = $request->status;
            $script->approved_by = Auth::id();
            $script->save();

            return redirect()->back()->with('success','Successfully updated script');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(string $id)
    {
        $script = Script::find($id);

        $file_path = public_path('documents/scripts/' . $script->file);
        if (file_exists($file_path)) {
            return response()->download($file_path);
        } else {
            abort(404);
        }
    }
}
