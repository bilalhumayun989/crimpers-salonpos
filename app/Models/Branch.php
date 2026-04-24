<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'is_active', 'opening_time', 'closing_time'];

    protected $casts = [
        'name' => \App\Casts\FlexibleEncryption::class,
        'address' => \App\Casts\FlexibleEncryption::class,
        'phone' => \App\Casts\FlexibleEncryption::class,
        'is_active' => 'boolean',
    ];

    public function invoices() { return $this->hasMany(Invoice::class); }
    public function users() { return $this->hasMany(User::class); }
    public function products() { return $this->hasMany(Product::class); }
}
