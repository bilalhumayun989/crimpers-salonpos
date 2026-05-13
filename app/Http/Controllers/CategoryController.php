<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:product,service',
        ]);

        $branchId = Session::get('current_branch_id', 1);
        if (auth()->check()) {
            $user = auth()->user();
            $branchId = (is_null($user->branch_id)) ? Session::get('current_branch_id', 1) : $user->branch_id;
        }

        $baseSlug = Str::slug($validated['name']);
        // Make slug unique per branch by appending branch id
        $slug = $baseSlug . '-b' . $branchId;

        // Check if category already exists for this branch & type
        $existing = Category::withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('type', $validated['type'])
            ->where('branch_id', $branchId)
            ->first();

        if ($existing) {
            if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => true,
                    'category' => $existing,
                    'message' => 'Category already exists.'
                ]);
            }
            return back()->with('info', 'Category already exists.');
        }

        try {
            $category = Category::create([
                'name'      => $validated['name'],
                'slug'      => $slug,
                'type'      => $validated['type'],
                'branch_id' => $branchId,
            ]);
        } catch (\Exception $e) {
            // Slug collision fallback — append random suffix
            $slug = $baseSlug . '-b' . $branchId . '-' . Str::random(4);
            $category = Category::create([
                'name'      => $validated['name'],
                'slug'      => $slug,
                'type'      => $validated['type'],
                'branch_id' => $branchId,
            ]);
        }

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success'  => true,
                'category' => $category,
                'message'  => 'Category created successfully.'
            ]);
        }

        return back()->with('success', 'Category created successfully.');
    }

    public function destroy(Category $category, Request $request)
    {
        // Safety check: Don't delete if it has products or services to prevent accidental data loss
        if ($category->type === 'service') {
            if ($category->services()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'This category contains services and cannot be deleted.'
                ], 422);
            }
        } else {
            if ($category->products()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'This category contains products and cannot be deleted.'
                ], 422);
            }
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
