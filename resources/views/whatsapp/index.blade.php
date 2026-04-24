@extends('layouts.app')
@section('title', 'WhatsApp Marketing')

@section('content')
<div style="padding:28px;">
    <div style="margin-bottom:32px;">
        <h1 style="font-size:2rem;font-weight:800;color:#1e293b;margin-bottom:8px;">WhatsApp Marketing</h1>
        <p style="color:#64748b;">Send automated messages, reminders, and promotions to your customers</p>
    </div>

    <!-- Quick Actions -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;margin-bottom:32px;">
        <div class="card" style="padding:24px;text-align:center;">
            <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#25d366,#128c7e);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:white;">
                <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>
                </svg>
            </div>
            <h3 style="font-size:1.25rem;font-weight:700;color:#1e293b;margin-bottom:8px;">Send Promotion</h3>
            <p style="color:#64748b;margin-bottom:16px;">Send promotional offers and special deals</p>
            <button onclick="openPromotionModal()" class="btn-primary" style="padding:10px 20px;border:none;font-size:.875rem;font-weight:600;">Create Promotion</button>
        </div>

        <div class="card" style="padding:24px;text-align:center;">
            <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:white;">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 style="font-size:1.25rem;font-weight:700;color:#1e293b;margin-bottom:8px;">Re-engage Customers</h3>
            <p style="color:#64748b;margin-bottom:16px;">Reach out to inactive customers</p>
            <button onclick="openReengagementModal()" class="btn-primary" style="padding:10px 20px;border:none;font-size:.875rem;font-weight:600;">Send Re-engagement</button>
        </div>

        <div class="card" style="padding:24px;text-align:center;">
            <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#8b5cf6,#7c3aed);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;color:white;">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 style="font-size:1.25rem;font-weight:700;color:#1e293b;margin-bottom:8px;">Bulk Messaging</h3>
            <p style="color:#64748b;margin-bottom:16px;">Send messages to multiple customers</p>
            <button onclick="openBulkModal()" class="btn-primary" style="padding:10px 20px;border:none;font-size:.875rem;font-weight:600;">Send Bulk</button>
        </div>
    </div>

    <!-- Message History -->
    <div class="card" style="padding:24px;">
        <h2 style="font-size:1.5rem;font-weight:700;color:#1e293b;margin-bottom:20px;">Message Templates</h2>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;">
            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
                <h4 style="font-size:1.1rem;font-weight:600;color:#1e293b;margin-bottom:12px;">Appointment Reminder</h4>
                <p style="color:#64748b;font-size:.875rem;margin-bottom:16px;">"Hi [Name]! This is a reminder for your appointment at The Crimpers tomorrow at [Time]. We look forward to seeing you!"</p>
                <span style="background:#dcfce7;color:#166534;padding:4px 12px;border-radius:99px;font-size:.75rem;font-weight:600;">Automated</span>
            </div>

            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
                <h4 style="font-size:1.1rem;font-weight:600;color:#1e293b;margin-bottom:12px;">Booking Confirmation</h4>
                <p style="color:#64748b;font-size:.875rem;margin-bottom:16px;">"Hi [Name]! Your appointment has been confirmed. See you on [Date] at [Time]!"</p>
                <span style="background:#dbeafe;color:#1d4ed8;padding:4px 12px;border-radius:99px;font-size:.75rem;font-weight:600;">Confirmation</span>
            </div>

            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
                <h4 style="font-size:1.1rem;font-weight:600;color:#1e293b;margin-bottom:12px;">Re-engagement</h4>
                <p style="color:#64748b;font-size:.875rem;margin-bottom:16px;">"Hi [Name]! We haven't seen you in 30 days. Special offer: 20% off any service!"</p>
                <span style="background:#fef3c7;color:#92400e;padding:4px 12px;border-radius:99px;font-size:.75rem;font-weight:600;">Re-engagement</span>
            </div>

            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
                <h4 style="font-size:1.1rem;font-weight:600;color:#1e293b;margin-bottom:12px;">Invoice Share</h4>
                <p style="color:#64748b;font-size:.875rem;margin-bottom:16px;">"Here's your invoice #[Number] for $[Amount]. Thank you for choosing The Crimpers!"</p>
                <span style="background:#f0fdf4;color:#166534;padding:4px 12px;border-radius:99px;font-size:.75rem;font-weight:600;">Invoice</span>
            </div>
        </div>
    </div>

    @if(!empty($birthdays) && $birthdays->count())
    <div class="card" style="padding:24px; margin-top:24px;">
        <h2 style="font-size:1.5rem;font-weight:700;color:#1e293b;margin-bottom:20px;">Upcoming Birthdays</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
            @foreach($birthdays as $customer)
            <div style="border:1px solid #e5e7eb;border-radius:12px;padding:18px;">
                <div style="font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:6px;">{{ $customer->name }}</div>
                <div style="color:#64748b;font-size:.9rem;margin-bottom:10px;">{{ $customer->birthday->format('M d') }}</div>
                <div style="color:#0f172a;font-size:.85rem;line-height:1.6;">{{ $customer->phone ?? 'No phone on file' }}</div>
                @if($customer->phone)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $customer->phone) }}?text={{ urlencode('Happy Birthday ' . $customer->name . '! 🎉 Wishing you a beautiful day from The Crimpers.') }}" target="_blank" style="display:inline-flex;margin-top:12px;padding:8px 12px;border-radius:10px;background:#22c55e;color:white;font-size:.85rem;text-decoration:none;">Send Birthday Wish</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Promotion Modal -->
<div id="promotionModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:16px;width:500px;max-width:90vw;">
        <div style="padding:24px;border-bottom:1px solid #dcfce7;">
            <h2 style="margin:0;font-size:1.25rem;font-weight:700;">Send Promotion</h2>
        </div>
        <form method="POST" action="{{ route('whatsapp.promotion') }}" style="padding:24px;">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;margin-bottom:6px;font-weight:600;">Customer Phone</label>
                <input type="tel" name="phone" required placeholder="1234567890" style="width:100%;padding:10px;border:1px solid #bbf7d0;border-radius:8px;">
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block;margin-bottom:6px;font-weight:600;">Promotion Message</label>
                <textarea name="message" rows="4" required placeholder="Enter your promotional message..." style="width:100%;padding:10px;border:1px solid #bbf7d0;border-radius:8px;"></textarea>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <button type="button" onclick="closePromotionModal()" style="padding:10px 20px;border:1px solid #bbf7d0;background:#fff;border-radius:8px;cursor:pointer;">Cancel</button>
                <button type="submit" class="btn-primary" style="padding:10px 20px;border:none;">Send Promotion</button>
            </div>
        </form>
    </div>
</div>

<!-- Re-engagement Modal -->
<div id="reengagementModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:16px;width:500px;max-width:90vw;">
        <div style="padding:24px;border-bottom:1px solid #dcfce7;">
            <h2 style="margin:0;font-size:1.25rem;font-weight:700;">Re-engage Customer</h2>
        </div>
        <form method="POST" action="{{ route('whatsapp.reengagement') }}" style="padding:24px;">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;margin-bottom:6px;font-weight:600;">Customer Name</label>
                <input type="text" name="customer_name" required placeholder="John Doe" style="width:100%;padding:10px;border:1px solid #bbf7d0;border-radius:8px;">
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block;margin-bottom:6px;font-weight:600;">Customer Phone</label>
                <input type="tel" name="phone" required placeholder="1234567890" style="width:100%;padding:10px;border:1px solid #bbf7d0;border-radius:8px;">
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <button type="button" onclick="closeReengagementModal()" style="padding:10px 20px;border:1px solid #bbf7d0;background:#fff;border-radius:8px;cursor:pointer;">Cancel</button>
                <button type="submit" class="btn-primary" style="padding:10px 20px;border:none;">Send Re-engagement</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Modal -->
<div id="bulkModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;">
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:16px;width:600px;max-width:90vw;">
        <div style="padding:24px;border-bottom:1px solid #dcfce7;">
            <h2 style="margin:0;font-size:1.25rem;font-weight:700;">Bulk WhatsApp Messaging</h2>
        </div>
        <div style="padding:24px;">
            <p style="color:#64748b;margin-bottom:20px;">This feature will be available once you integrate with a WhatsApp Business API provider.</p>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:16px;margin-bottom:20px;">
                <h4 style="font-weight:600;color:#166534;margin-bottom:8px;">Coming Soon</h4>
                <p style="color:#166534;font-size:.875rem;">Bulk messaging, automated reminders, and advanced marketing features will be available with WhatsApp Business API integration.</p>
            </div>
            <div style="display:flex;gap:12px;justify-content:flex-end;">
                <button onclick="closeBulkModal()" class="btn-primary" style="padding:10px 20px;border:none;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function openPromotionModal() {
    document.getElementById('promotionModal').style.display = 'block';
}
function closePromotionModal() {
    document.getElementById('promotionModal').style.display = 'none';
}

function openReengagementModal() {
    document.getElementById('reengagementModal').style.display = 'block';
}
function closeReengagementModal() {
    document.getElementById('reengagementModal').style.display = 'none';
}

function openBulkModal() {
    document.getElementById('bulkModal').style.display = 'block';
}
function closeBulkModal() {
    document.getElementById('bulkModal').style.display = 'none';
}
</script>
@endsection