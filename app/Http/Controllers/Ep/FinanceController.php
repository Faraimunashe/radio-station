<?php

namespace App\Http\Controllers\Ep;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Finance::where('type', 'INCOME')->get();
        $expenses = Finance::where('type', 'EXPENSE')->get();

        return view('ep.finances',[
            'income' => $incomes,
            'expenses' => $expenses
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
                'details' => ['required', 'string'],
                'type' => ['required', 'alpha'],
                'amount' => ['required', 'numeric']
            ]);

            $finance = new Finance();
            $finance->details = $request->details;
            $finance->type = $request->type;
            $finance->amount = $request->amount;
            $finance->save();

            return redirect()->back()->with('success', 'Successfully added transaction');
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
