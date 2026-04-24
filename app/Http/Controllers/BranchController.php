<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function switch(Request $request)
    {
        $branchId = $request->input('branch_id');
        
        if (Branch::where('id', $branchId)->exists()) {
            session(['current_branch_id' => $branchId]);
        }

        return back()->with('success', 'Branch switched successfully!');
    }

    public function updateHours(Request $request, Branch $branch)
    {
        $request->validate([
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
        ]);

        $branch->update([
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
        ]);

        return back()->with('success', "Operating hours updated for {$branch->name}");
    }
}
