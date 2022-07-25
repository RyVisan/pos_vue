<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Expense;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::latest()->get();
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'detials' => 'required',
            'amount' => 'required'
        ]);
        $expenses = Expense::create([
            'detials' => $request->detials,
            'amount' => $request->amount,
            'expense_date' => date('d/m/y')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'detials' => 'required',
            'amount' => 'required'
        ]);
        $expenses = Expense::find($id)->update([
            'detials' => $request->detials,
            'amount' => $request->amount
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Expense::find($id)->delete();
    }
}