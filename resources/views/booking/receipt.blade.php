<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt #{{ $invoice->invoice_no }} — The Crimpers</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family:'Outfit',sans-serif; background:#f0fdf4; color:#1e293b; }
        .receipt-card { background:#fff; border:1px solid #dcfce7; border-radius:20px; box-shadow:0 4px 24px rgba(34,197,94,.10); }
        .btn-green { background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; border-radius:10px; transition:all .25s; }
        .btn-green:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(34,197,94,.35); }
        @media print {
            body { background:#fff; }
            .no-print { display:none !important; }
            .receipt-card { box-shadow:none; border:1px solid #ccc; }
        }
    </style>
</head>
<body class="antialiased min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">

        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-green-600 hover:text-green-800 transition-colors">← Back to Booking</a>
            <button onclick="window.print()" class="btn-green px-5 py-2 text-sm font-semibold">Print Receipt</button>
        </div>

        <div class="receipt-card p-8">
            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-green-500 flex items-center justify-center mx-auto mb-3 shadow-md">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-green-700">The Crimpers</h1>
                <p class="text-slate-500 text-sm mt-1">123 Beauty Lane, Glamour City</p>
                <p class="text-slate-500 text-sm">Tel: +1 234 567 890</p>
            </div>

            <div class="border-t border-b border-green-100 py-5 mb-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Invoice</p><p class="font-bold text-slate-800">{{ $invoice->invoice_no }}</p></div>
                    <div><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Date</p><p class="font-bold text-slate-800">{{ $invoice->created_at->format('M d, Y H:i') }}</p></div>
                    <div><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Customer</p><p class="font-bold text-slate-800">{{ $invoice->customer_name }}</p></div>
                    <div><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Payment</p><p class="font-bold text-slate-800">{{ ucfirst($invoice->payment_method) }}</p></div>
                    @if($invoice->customer_phone)
                    <div><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Phone</p><p class="font-bold text-slate-800">{{ $invoice->customer_phone }}</p></div>
                    @endif
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wide mb-4">Services &amp; Products</h3>
                <div class="space-y-3">
                    @foreach($invoice->items as $item)
                    <div class="flex justify-between items-center py-2.5 border-b border-green-50">
                        <div>
                            <p class="font-semibold text-slate-800">{{ $item->itemizable->name }}</p>
                            <p class="text-xs text-slate-500">Qty: {{ $item->quantity }} &times; PKR {{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <p class="font-bold text-slate-800">PKR {{ number_format($item->subtotal, 2) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-green-50 rounded-xl p-5 border border-green-100">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-slate-600"><span>Subtotal</span><span>PKR {{ number_format($invoice->subtotal, 2) }}</span></div>
                    <div class="flex justify-between text-slate-600"><span>Tax (5%)</span><span>PKR {{ number_format($invoice->tax, 2) }}</span></div>
                    <div class="flex justify-between font-bold text-slate-800 text-lg pt-3 border-t border-green-200">
                        <span>Total</span><span class="text-green-600">PKR {{ number_format($invoice->payable_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8 pt-6 border-t border-green-100">
                <p class="text-slate-500 text-sm">Thank you for choosing The Crimpers!</p>
                <p class="text-slate-400 text-xs mt-1">Generated on {{ now()->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <div class="flex justify-center gap-4 mt-6 no-print">
            <a href="{{ route('home') }}" class="bg-white border border-green-200 text-green-700 hover:bg-green-50 px-6 py-3 rounded-xl font-semibold text-sm transition-colors">Book Another</a>
            <button onclick="window.print()" class="btn-green px-6 py-3 font-semibold text-sm">Print Receipt</button>
        </div>
    </div>
</body>
</html>
