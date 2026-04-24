<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToBranch;

class ServicePackage extends Model
{
    use BelongsToBranch;
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'pricing_levels_enabled',
        'duration',
        'is_active',
        'pricing_levels',
        'peak_pricing_enabled',
        'peak_price',
        'peak_start',
        'peak_end',
    ];

    protected $casts = [
        'name' => \App\Casts\FlexibleEncryption::class,
        'description' => \App\Casts\FlexibleEncryption::class,
        'price' => 'decimal:2',
        'pricing_levels_enabled' => 'boolean',
        'duration' => 'integer',
        'is_active' => 'boolean',
        'pricing_levels' => \App\Casts\EncryptedArray::class,
        'peak_pricing_enabled' => 'boolean',
        'peak_price' => 'decimal:2',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_package_service');
    }

    public function invoiceItems()
    {
        return $this->morphMany(InvoiceItem::class, 'itemizable');
    }
}
