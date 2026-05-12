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
}
