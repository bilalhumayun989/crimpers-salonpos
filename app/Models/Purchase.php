<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToBranch;

class Purchase extends Model
{
    use HasFactory, BelongsToBranch;

    protected $fillable = [
        'purchase_order_number',
        'supplier_id',
        'order_date',
        'expected_delivery_date',
        'actual_delivery_date',
        'status',
        'total_amount',
        'notes'
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function expectedRevenue()
    {
        return $this->purchaseItems->sum(function($item) {
            return ($item->product->selling_price ?? 0) * ($item->quantity_received ?? $item->quantity_ordered);
        });
    }

    public function potentialProfit()
    {
        return $this->expectedRevenue() - $this->total_amount;
    }

    public function generatePurchaseOrderNumber()
    {
        return 'PO-' . date('Y') . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
