<?php
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;

$products = Product::where('current_stock', '>', 0)->get();
$count = 0;

foreach ($products as $p) {
    if (!$p->purchaseItems()->exists()) {
        $supplierId = $p->supplier_id ?? Supplier::first()->id ?? 1;
        
        $pur = Purchase::create([
            'purchase_order_number' => 'INIT-' . strtoupper(bin2hex(random_bytes(3))),
            'supplier_id' => $supplierId,
            'order_date' => now(),
            'status' => 'received',
            'total_amount' => $p->current_stock * ($p->cost_price ?? 0),
            'notes' => 'Backfilled initial stock'
        ]);

        $pur->update([
            'purchase_order_number' => 'PO-' . date('Y') . '-' . str_pad($pur->id, 4, '0', STR_PAD_LEFT)
        ]);

        PurchaseItem::create([
            'purchase_id' => $pur->id,
            'product_id' => $p->id,
            'quantity_ordered' => $p->current_stock,
            'quantity_received' => $p->current_stock,
            'unit_cost' => $p->cost_price ?? 0,
            'line_total' => $p->current_stock * ($p->cost_price ?? 0)
        ]);
        $count++;
    }
}

echo "Successfully backfilled $count products into Purchase History.";
