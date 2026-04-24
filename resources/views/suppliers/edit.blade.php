@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('content')
<style>
:root{--y1:#F7DF79;--y2:#FBEFBC;--yd:#c9a800;--ydark:#a07800;--ybg:#fffdf0;}
.form-wrap{max-width:720px;margin:0 auto;}
.form-header{display:flex;align-items:center;gap:12px;margin-bottom:22px;}
.back-btn{width:36px;height:36px;border-radius:9px;border:1.5px solid #e4e4e7;background:#fff;display:flex;align-items:center;justify-content:center;color:#71717a;text-decoration:none;transition:.2s;flex-shrink:0;}
.back-btn:hover{border-color:var(--y1);color:var(--ydark);background:var(--ybg);}
.pg-title{font-size:1.4rem;font-weight:800;color:#18181b;letter-spacing:-.02em;margin-bottom:3px;}
.pg-sub{font-size:.85rem;color:#71717a;}

.form-card{background:#fff;border:1.5px solid #f0e8a0;border-radius:18px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.05);}
.form-section{padding:22px 26px;border-bottom:1px solid #f4f4f5;}
.section-title{font-size:.72rem;font-weight:700;color:#a1a1aa;text-transform:uppercase;letter-spacing:.1em;margin-bottom:16px;display:flex;align-items:center;gap:7px;}
.section-icon{width:22px;height:22px;border-radius:6px;background:var(--y2);display:flex;align-items:center;justify-content:center;color:var(--ydark);}
.f-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;}
.f-row{margin-bottom:14px;}
.f-label{display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:7px;}
.f-input{width:100%;padding:10px 13px;border:1.5px solid #f0e8a0;border-radius:10px;font-size:.875rem;font-family:'Outfit',sans-serif;color:#18181b;background:var(--ybg);outline:none;transition:.2s;box-sizing:border-box;}
.f-input:focus{border-color:var(--y1);background:#fff;box-shadow:0 0 0 3px rgba(247,223,121,.15);}
textarea.f-input{resize:vertical;min-height:90px;}
.check-row{display:flex;align-items:center;gap:8px;cursor:pointer;}
.check-row input[type=checkbox]{width:15px;height:15px;accent-color:var(--ydark);cursor:pointer;}
.check-lbl{font-size:.875rem;font-weight:600;color:#374151;}

.form-footer{padding:18px 26px;display:flex;gap:10px;justify-content:flex-end;}
.btn-cancel{padding:10px 22px;border:1.5px solid #e4e4e7;background:#fff;border-radius:10px;color:#71717a;font-size:.875rem;font-weight:600;cursor:pointer;text-decoration:none;font-family:'Outfit',sans-serif;transition:.2s;}
.btn-cancel:hover{border-color:#fca5a5;color:#dc2626;background:#fef2f2;}
.btn-save{padding:10px 22px;border:none;background:linear-gradient(135deg,var(--y1),var(--yd));border-radius:10px;color:#18181b;font-size:.875rem;font-weight:800;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(247,223,121,.3);}
.btn-save:hover{transform:translateY(-1px);}

.danger-zone{margin-top:20px;background:#fff;border:1px solid #fecaca;border-radius:14px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;}
.danger-title{font-size:.875rem;font-weight:700;color:#b91c1c;margin-bottom:2px;}
.danger-sub{font-size:.75rem;color:#a1a1aa;}
.btn-danger{padding:8px 16px;border:1.5px solid #fca5a5;background:#fef2f2;border-radius:9px;color:#dc2626;font-size:.8rem;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;}
.btn-danger:hover{background:#fee2e2;}

/* Delete Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;z-index:999;padding:20px;}
.modal-box{background:#fff;border-radius:20px;width:100%;max-width:380px;padding:28px;text-align:center;box-shadow:0 20px 50px rgba(0,0,0,.2);}
.modal-icon{width:52px;height:52px;background:#fef2f2;color:#dc2626;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
.modal-title{font-size:1.1rem;font-weight:800;color:#18181b;margin-bottom:6px;}
.modal-text{font-size:.85rem;color:#71717a;line-height:1.6;margin-bottom:22px;}
.modal-footer{display:flex;gap:10px;}
.btn-m{flex:1;padding:11px;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;transition:.2s;border:none;font-family:'Outfit',sans-serif;}
.btn-m-cancel{background:#f4f4f5;color:#52525b;}
.btn-m-cancel:hover{background:#e4e4e7;}
.btn-m-confirm{background:#dc2626;color:#fff;}
.btn-m-confirm:hover{background:#b91c1c;transform:translateY(-1px);}
</style>

<div class="form-wrap">
    <div class="form-header">
        <a href="{{ route('suppliers.index') }}" class="back-btn">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <div>
            <div class="pg-title">Edit Supplier</div>
            <div class="pg-sub">{{ $supplier->name }}</div>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('suppliers.update',$supplier) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg></div>
                    Company Information
                </div>
                <div class="f-row">
                    <label class="f-label">Company Name <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="name" value="{{ old('name',$supplier->name) }}" required class="f-input">
                </div>
                <div class="f-row">
                    <label class="f-label">Address</label>
                    <textarea name="address" class="f-input">{{ old('address',$supplier->address) }}</textarea>
                </div>
                <div class="f-row" style="margin-bottom:0;">
                    <label class="check-row">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active',$supplier->is_active)?'checked':'' }}>
                        <span class="check-lbl">Active supplier</span>
                    </label>
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                    Contact Details
                </div>
                <div class="f-grid-2">
                    <div>
                        <label class="f-label">Contact Person</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person',$supplier->contact_person) }}" class="f-input">
                    </div>
                    <div>
                        <label class="f-label">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone',$supplier->phone) }}" class="f-input">
                    </div>
                </div>
                <div class="f-row" style="margin-bottom:0;">
                    <label class="f-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email',$supplier->email) }}" class="f-input">
                </div>
            </div>

            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
                    Payment Terms
                </div>
                <div class="f-row" style="margin-bottom:0;">
                    <label class="f-label">Payment Terms</label>
                    <select name="payment_terms" class="f-input">
                        <option value="cod" {{ old('payment_terms',$supplier->payment_terms)==='cod'?'selected':'' }}>Cash on Delivery (COD)</option>
                        <option value="net_15" {{ old('payment_terms',$supplier->payment_terms)==='net_15'?'selected':'' }}>Net 15 Days</option>
                        <option value="net_30" {{ old('payment_terms',$supplier->payment_terms??'net_30')==='net_30'?'selected':'' }}>Net 30 Days</option>
                        <option value="net_60" {{ old('payment_terms',$supplier->payment_terms)==='net_60'?'selected':'' }}>Net 60 Days</option>
                    </select>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('suppliers.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Danger zone --}}
    <div class="danger-zone">
        <div>
            <div class="danger-title">Delete Supplier</div>
            <div class="danger-sub">This action cannot be undone</div>
        </div>
        <button type="button" class="btn-danger" onclick="showDelModal()">Delete Supplier</button>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delModal">
    <div class="modal-box">
        <div class="modal-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
        </div>
        <div class="modal-title">Delete Supplier?</div>
        <div class="modal-text">Are you sure you want to permanently delete <strong>{{ $supplier->name }}</strong>? This cannot be undone.</div>
        <div class="modal-footer">
            <button class="btn-m btn-m-cancel" onclick="hideDelModal()">Cancel</button>
            <button class="btn-m btn-m-confirm" onclick="document.getElementById('del-form').submit()">Yes, Delete</button>
        </div>
    </div>
</div>
<form id="del-form" method="POST" action="{{ route('suppliers.destroy',$supplier) }}" style="display:none;">
    @csrf @method('DELETE')
</form>

<script>
function showDelModal(){ document.getElementById('delModal').style.display='flex'; }
function hideDelModal(){ document.getElementById('delModal').style.display='none'; }
</script>
@endsection
