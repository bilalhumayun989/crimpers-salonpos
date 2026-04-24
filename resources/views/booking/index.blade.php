<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Book Your Service — The Crimpers</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family:'Outfit',sans-serif; background:#f0fdf4; color:#1e293b; }
        .service-card { background:#fff; border:2px solid #dcfce7; border-radius:14px; cursor:pointer; transition:all .25s; }
        .service-card:hover { border-color:#22c55e; box-shadow:0 4px 16px rgba(34,197,94,.15); transform:translateY(-2px); }
        .service-card.selected { border-color:#16a34a; background:#f0fdf4; box-shadow:0 4px 16px rgba(34,197,94,.2); }
        .category-tab { background:#fff; border:1px solid #bbf7d0; color:#475569; border-radius:99px; transition:all .25s; }
        .category-tab.active { background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; border-color:transparent; }
        .cart-item { background:#f0fdf4; border:1px solid #dcfce7; border-radius:10px; }
        .btn-green { background:linear-gradient(135deg,#22c55e,#16a34a); color:#fff; border-radius:10px; transition:all .25s; }
        .btn-green:hover { transform:translateY(-1px); box-shadow:0 4px 14px rgba(34,197,94,.35); }
        .btn-green:disabled { opacity:.5; cursor:not-allowed; transform:none; }
        input,select { border:1px solid #bbf7d0; border-radius:10px; background:#f9fafb; transition:border-color .2s,box-shadow .2s; }
        input:focus,select:focus { outline:none; border-color:#22c55e; box-shadow:0 0 0 3px rgba(34,197,94,.15); background:#fff; }
        .payment-label { border:2px solid #dcfce7; border-radius:10px; cursor:pointer; transition:all .2s; }
        .payment-label:has(input:checked) { border-color:#22c55e; background:#f0fdf4; }
    </style>
</head>
<body class="antialiased">
    <header class="bg-white border-b border-green-100 shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-green-500 flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-green-700 leading-none">The Crimpers</h1>
                    <span class="text-xs text-green-500">Customer Portal</span>
                </div>
            </div>
            <a href="{{ route('login') }}" class="text-sm font-semibold text-green-600 hover:text-green-800 transition-colors">Staff Login →</a>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-5">Choose Your Services</h2>
                <div class="flex gap-2 mb-6 overflow-x-auto pb-1">
                    <button class="category-tab active px-4 py-2 text-sm font-semibold whitespace-nowrap" data-category="all">All</button>
                    @foreach($categories as $category)
                        <button class="category-tab px-4 py-2 text-sm font-semibold whitespace-nowrap" data-category="{{ $category->id }}">{{ $category->name }}</button>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="services-grid">
                    @foreach($categories as $category)
                        @foreach($category->services as $service)
                            <div class="service-card p-4" data-id="{{ $service->id }}" data-type="service" data-category="{{ $category->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-slate-800">{{ $service->name }}</h3>
                                    @if($service->is_popular)
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-medium">Popular</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 mb-3">{{ $service->duration }} mins</p>
                                <p class="text-lg font-bold text-green-600">PKR {{ $service->price }}</p>
                            </div>
                        @endforeach
                        @foreach($category->products as $product)
                            <div class="service-card p-4" data-id="{{ $product->id }}" data-type="product" data-category="{{ $category->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-slate-800">{{ $product->name }}</h3>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 font-medium">Product</span>
                                </div>
                                <p class="text-xs text-slate-500 mb-3">Stock: {{ $product->current_stock }}</p>
                                <p class="text-lg font-bold text-green-600">PKR {{ $product->selling_price }}</p>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Your Booking
                    </h3>
                    <form id="booking-form" action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <div class="space-y-3 mb-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Your Name *</label>
                                <input type="text" name="customer_name" required class="w-full px-3 py-2.5 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Phone Number</label>
                                <input type="tel" name="customer_phone" class="w-full px-3 py-2.5 text-sm">
                            </div>
                        </div>
                        <div id="cart-items" class="space-y-2 mb-5 min-h-[60px]">
                            <p class="text-slate-400 text-sm text-center py-6">Select services to get started</p>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Payment Method</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="payment-label flex items-center justify-center p-2.5 text-sm font-semibold text-slate-700"><input type="radio" name="payment_method" value="cash" class="sr-only" checked>Cash</label>
                                <label class="payment-label flex items-center justify-center p-2.5 text-sm font-semibold text-slate-700"><input type="radio" name="payment_method" value="card" class="sr-only">Card</label>
                                <label class="payment-label flex items-center justify-center p-2.5 text-sm font-semibold text-slate-700"><input type="radio" name="payment_method" value="qr" class="sr-only">QR Pay</label>
                            </div>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 mb-5 space-y-2 border border-green-100">
                            <div class="flex justify-between text-sm text-slate-600"><span>Subtotal</span><span id="subtotal">$0.00</span></div>
                            <div class="flex justify-between text-sm text-slate-600"><span>Tax (5%)</span><span id="tax">$0.00</span></div>
                            <div class="flex justify-between font-bold text-slate-800 pt-2 border-t border-green-200"><span>Total</span><span id="total" class="text-green-600 text-lg">$0.00</span></div>
                        </div>
                        <button type="submit" id="book-btn" class="btn-green w-full py-3 font-bold text-sm" disabled>Complete Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="success-modal" class="fixed inset-0 z-50 items-center justify-center p-4 bg-black/40 backdrop-blur-sm" style="display:none">
        <div class="bg-white w-full max-w-sm rounded-2xl p-8 text-center shadow-2xl border border-green-100">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-1">Booking Confirmed!</h2>
            <p class="text-slate-500 text-sm mb-6">Thank you for choosing The Crimpers</p>
            <div class="space-y-3">
                <a href="#" id="view-receipt-btn" class="block w-full btn-green py-3 font-semibold text-sm">View Receipt</a>
                <button onclick="window.location.reload()" class="block w-full bg-green-50 hover:bg-green-100 text-green-700 py-3 rounded-xl font-semibold text-sm transition-colors border border-green-100">Book Another Service</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let cart = [];
        const cartEl  = document.getElementById('cart-items');
        const subEl   = document.getElementById('subtotal');
        const taxEl   = document.getElementById('tax');
        const totalEl = document.getElementById('total');
        const bookBtn = document.getElementById('book-btn');
        const modal   = document.getElementById('success-modal');
        const rcptBtn = document.getElementById('view-receipt-btn');

        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function () {
                const { id, type, name, price } = this.dataset;
                this.classList.toggle('selected');
                if (this.classList.contains('selected')) {
                    const ex = cart.find(i => i.id == id && i.type == type);
                    ex ? ex.quantity++ : cart.push({ id, type, name, price: parseFloat(price), quantity: 1 });
                } else {
                    cart = cart.filter(i => !(i.id == id && i.type == type));
                }
                renderCart();
            });
        });

        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                const cat = this.dataset.category;
                document.querySelectorAll('.service-card').forEach(c => {
                    c.style.display = (cat === 'all' || c.dataset.category === cat) ? '' : 'none';
                });
            });
        });

        function renderCart() {
            if (!cart.length) {
                cartEl.innerHTML = '<p class="text-slate-400 text-sm text-center py-6">Select services to get started</p>';
                bookBtn.disabled = true; setTotals(0); return;
            }
            cartEl.innerHTML = cart.map(item => `
                <div class="cart-item p-3 flex justify-between items-center">
                    <div><p class="text-sm font-semibold text-slate-800">${item.name}</p><p class="text-xs text-slate-500">Qty: ${item.quantity}</p></div>
                    <div class="text-right"><p class="text-sm font-bold text-slate-800">$${(item.price*item.quantity).toFixed(2)}</p>
                    <button onclick="removeItem('${item.id}','${item.type}')" class="text-xs text-red-400 hover:text-red-600">Remove</button></div>
                </div>`).join('');
            bookBtn.disabled = false;
            setTotals(cart.reduce((s, i) => s + i.price * i.quantity, 0));
        }

        function setTotals(sub) {
            const tax = sub * .05;
            subEl.textContent   = `PKR ${sub.toFixed(2)}`;
            taxEl.textContent   = `PKR ${tax.toFixed(2)}`;
            totalEl.textContent = `PKR ${(sub+tax).toFixed(2)}`;
        }

        window.removeItem = function (id, type) {
            cart = cart.filter(i => !(i.id == id && i.type == type));
            document.querySelector(`[data-id="${id}"][data-type="${type}"]`)?.classList.remove('selected');
            renderCart();
        };

        document.getElementById('booking-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const fd = new FormData(this);
            fd.append('items', JSON.stringify(cart));
            fetch(this.action, {
                method: 'POST', body: fd,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(r => r.json())
            .then(data => { if (data.success) { rcptBtn.href = `/booking/${data.invoice.id}/receipt`; modal.style.display = 'flex'; } })
            .catch(() => alert('An error occurred. Please try again.'));
        });
    });
    </script>
</body>
</html>
