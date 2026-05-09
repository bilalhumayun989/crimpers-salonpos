<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:product,service',
        ]);

        $slug = Str::slug($validated['name']);

        // Check if slug already exists to avoid DB unique constraint error
        $existing = Category::where('slug', $slug)->where('type', $validated['type'])->first();
        if ($existing) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'category' => $existing,
                    'message' => 'Category already exists.'
                ]);
            }
            return back()->with('info', 'Category already exists.');
        }

        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'category' => $category
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
