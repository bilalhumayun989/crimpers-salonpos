<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpsellPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'total_upsells',
        'upsell_revenue',
        'conversion_rate',
        'average_upsell_value',
        'last_upsell_date',
    ];

    protected $casts = [
        'upsell_revenue' => 'decimal:2',
        'conversion_rate' => 'decimal:2',
        'average_upsell_value' => 'decimal:2',
        'last_upsell_date' => 'datetime',
    ];

    protected $attributes = [
        'total_upsells'       => 0,
        'upsell_revenue'      => 0,
        'conversion_rate'     => 0,
        'average_upsell_value'=> 0,
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
