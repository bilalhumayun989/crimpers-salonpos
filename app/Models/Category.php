<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBranch;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, BelongsToBranch;

    protected $fillable = ['name', 'slug', 'type', 'branch_id'];

    protected $casts = [
        'name' => \App\Casts\FlexibleEncryption::class,
    ];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
