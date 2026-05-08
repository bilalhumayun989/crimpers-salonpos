@extends('layouts.app')
@section('title', 'Add Expense')

@section('content')
<style>
.exp-wrap{max-width:540px;margin:20px auto 0;}
.exp-card{background:#fff;border:1.5px solid #e9e0c0;border-radius:20px;box-shadow:0 4px 20px rgba(199,168,0,.08);overflow:hidden;}
.exp-head{background:linear-gradient(135deg,#F7DF79,#c9a800);padding:24px;text-align:center;color:#18181b;}
.exp-icon{width:56px;height:56px;border-radius:16px;background:rgba(255,255,255,.3);display:inline-flex;align-items:center;justify-content:center;margin-bottom:12px;box-shadow:0 4px 12px rgba(0,0,0,.05);}
.exp-title{font-size:1.4rem;font-weight:800;margin:0;}
.exp-sub{font-size:.85rem;font-weight:600;opacity:.8;margin-top:4px;}

.exp-body{padding:32px;}
.f-row{margin-bottom:24px;}
.f-label{display:block;font-size:.85rem;font-weight:700;color:#1e293b;margin-bottom:8px;}
.f-input{width:100%;padding:14px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-family:'Outfit',sans-serif;font-size:.95rem;transition:.2s;background:#f8fafc;}
.f-input:focus{border-color:#F7DF79;background:#fff;box-shadow:0 0 0 4px rgba(247,223,121,.15);outline:none;}
textarea.f-input{resize:vertical;min-height:90px;}

.toggle-wrap{display:flex;align-items:center;justify-content:space-between;background:#f8fafc;border:1.5px solid #e2e8f0;padding:16px;border-radius:12px;}
.toggle-info strong{display:block;color:#1e293b;font-weight:700;font-size:.9rem;margin-bottom:2px;}
.toggle-info span{color:#64748b;font-size:.75rem;}

.toggle-switch{position:relative;display:inline-block;width:56px;height:30px;}
.toggle-switch input{opacity:0;width:0;height:0;}
.slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background-color:#cbd5e1;transition:.3s;border-radius:34px;}
.slider:before{position:absolute;content:"";height:22px;width:22px;left:4px;bottom:4px;background-color:white;transition:.3s;border-radius:50%;box-shadow:0 2px 4px rgba(0,0,0,.1);}
input:checked + .slider{background-color:#10b981;}
input:checked + .slider:before{transform:translateX(26px);}

.exp-footer{padding:0 32px 32px;}
.btn-submit{width:100%;padding:16px;background:#18181b;color:#F7DF79;border:none;border-radius:12px;font-size:1rem;font-weight:800;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;}
.btn-submit:hover{background:#27272a;transform:translateY(-2px);box-shadow:0 6px 16px rgba(0,0,0,.1);}
</style>

<div class="exp-wrap">
    @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;color:#166534;padding:16px;border-radius:12px;margin-bottom:20px;font-weight:700;text-align:center;display:flex;align-items:center;justify-content:center;gap:8px;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="exp-card">
        <div class="exp-head">
            <div class="exp-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <h2 class="exp-title">Record Expense</h2>
            <div class="exp-sub">Quickly track salon expenditures</div>
        </div>

        <form method="POST" action="{{ route('expenses.store') }}">
            @csrf
            <div class="exp-body">
                <div class="f-row">
                    <label class="f-label">Description</label>
                    <textarea name="description" class="f-input" placeholder="e.g., Tea and snacks for staff, salon cleaning supplies..." required></textarea>
                    @error('description')<div style="color:#ef4444;font-size:.75rem;margin-top:6px;font-weight:600;">{{ $message }}</div>@enderror
                </div>

                <div class="f-row">
                    <label class="f-label">Amount (PKR)</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:16px;top:50%;transform:translateY(-50%);font-weight:700;color:#94a3b8;">Rs.</span>
                        <input type="number" step="0.01" name="amount" class="f-input" style="padding-left:46px;" placeholder="0.00" required>
                    </div>
                    @error('amount')<div style="color:#ef4444;font-size:.75rem;margin-top:6px;font-weight:600;">{{ $message }}</div>@enderror
                </div>

                <div class="toggle-wrap">
                    <div class="toggle-info">
                        <strong>Deduct from Drawer?</strong>
                        <span>Did you take cash out of the register for this?</span>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden" name="deducted_from_drawer" value="0">
                        <input type="checkbox" name="deducted_from_drawer" value="1" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="exp-footer">
                <button type="submit" class="btn-submit">Save Expense</button>
            </div>
        </form>
    </div>
</div>
@endsection
