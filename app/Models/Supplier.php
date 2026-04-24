<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBranch;

class Supplier extends Model
{
    use BelongsToBranch;
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'payment_terms',
        'is_active'
    ];

    protected $casts = [
        'name' => \App\Casts\FlexibleEncryption::class,
        'contact_person' => \App\Casts\FlexibleEncryption::class,
        'email' => \App\Casts\FlexibleEncryption::class,
        'phone' => \App\Casts\FlexibleEncryption::class,
        'address' => \App\Casts\FlexibleEncryption::class,
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
