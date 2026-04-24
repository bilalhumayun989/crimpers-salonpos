<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

trait BelongsToBranch
{
    protected static function bootBelongsToBranch()
    {
        static::addGlobalScope('branch', function (Builder $builder) {
            // 1. Determine the target branch ID
            $branchId = 1;
            $isGlobalUser = false;

            if (auth()->check()) {
                $user = auth()->user();
                $isGlobalUser = ($user->role === 'admin' || is_null($user->branch_id));
                $branchId = $isGlobalUser ? Session::get('current_branch_id', 1) : $user->branch_id;
            } else {
                $branchId = Session::get('current_branch_id', 1);
            }

            // 2. Apply Scope: Show items for the active branch OR Global items (null branch_id)
            $builder->where(function($query) use ($branchId) {
                $query->where($query->getModel()->getTable() . '.branch_id', $branchId)
                      ->orWhereNull($query->getModel()->getTable() . '.branch_id');
            });
        });

        static::creating(function ($model) {
            if (!$model->branch_id) {
                $model->branch_id = Session::get('current_branch_id', 1);
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
}
