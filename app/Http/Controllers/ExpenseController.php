<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'amount' => 'required|numeric|min:0.01',
            'deducted_from_drawer' => 'required|boolean',
        ]);

        Expense::create([
            'branch_id' => session('current_branch_id', 1),
            'description' => $request->description,
            'amount' => $request->amount,
            'deducted_from_drawer' => $request->deducted_from_drawer,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Expense successfully recorded!');
    }
}
