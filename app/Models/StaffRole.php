<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBranch;

class StaffRole extends Model
{
    use BelongsToBranch;

    protected $fillable = ['name', 'description', 'permissions', 'email', 'password', 'branch_id'];

    protected $casts = [
        'name' => \App\Casts\FlexibleEncryption::class,
        'description' => \App\Casts\FlexibleEncryption::class,
        'permissions' => \App\Casts\EncryptedArray::class,
    ];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * Retrieve the model for a bound value.
     * Bypassing branch scope to allow admins to edit roles from any branch.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withoutGlobalScopes()->where($field ?? 'id', $value)->first();
    }
}
