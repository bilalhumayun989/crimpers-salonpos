@extends('layouts.app')
@section('title', 'Suppliers')

@section('content')
<style>
:root{--y1:#F7DF79;--y2:#FBEFBC;--yd:#c9a800;--ydark:#a07800;--ybg:#fffdf0;}

.pg-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;flex-wrap:wrap;}
.pg-title{font-size:1.45rem;font-weight:800;color:#18181b;letter-spacing:-.02em;margin-bottom:3px;}
.pg-sub{font-size:.85rem;color:#71717a;}
.header-right{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}

/* Search */
.search-wrap{position:relative;display:flex;align-items:center;}
.search-wrap svg{position:absolute;left:12px;color:#a1a1aa;pointer-events:none;}
.search-input{padding:9px 14px 9px 38px;border:1.5px solid #f0e8a0;border-radius:10px;font-size:.85rem;font-family:'Outfit',sans-serif;background:var(--ybg);color:#18181b;outline:none;transition:.2s;width:240px;}
.search-input:focus{border-color:var(--y1);background:#fff;box-shadow:0 0 0 3px rgba(247,223,121,.15);}
.btn-search{padding:9px 14px;background:#18181b;color:#fff;border:none;border-radius:10px;font-weight:700;font-size:.82rem;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;margin-left:6px;}
.btn-search:hover{background:#3f3f46;}

.btn-add{padding:9px 18px;background:linear-gradient(135deg,var(--y1),var(--yd));color:#18181b;border:none;border-radius:10px;font-weight:800;font-size:.85rem;text-decoration:none;display:inline-flex;align-items:center;gap:7px;box-shadow:0 3px 10px rgba(247,223,121,.35);transition:.2s;}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(247,223,121,.45);}

/* Grid */
.supp-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px;}

/* Card */
.supp-card{background:#fff;border-radius:18px;border:1.5px solid #f0e8a0;box-shadow:0 2px 8px rgba(0,0,0,.05);transition:all .22s ease;padding:24px;display:flex;flex-direction:column;position:relative;}
.supp-card:hover{transform:translateY(-4px);box-shadow:0 12px 28px rgba(247,223,121,.25);border-color:var(--y1);}

.supp-icon-wrap{width:60px;height:60px;border-radius:16px;background:var(--y2);display:flex;align-items:center;justify-content:center;color:var(--ydark);margin-bottom:16px;box-shadow:0 4px 10px rgba(247,223,121,0.2);}
.supp-name{font-size:1.1rem;font-weight:800;color:#18181b;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.supp-contact{font-size:.78rem;color:#71717a;font-weight:600;margin-bottom:12px;display:flex;align-items:center;gap:6px;}

.supp-info-list{margin-bottom:16px;border-top:1px solid #f4f4f5;padding-top:16px;}
.info-item{display:flex;align-items:center;gap:8px;font-size:.82rem;color:#52525b;margin-bottom:8px;}
.info-item svg{color:#a1a1aa;flex-shrink:0;}

/* Actions */
.supp-actions{display:flex;gap:8px;margin-top:auto;padding-top:16px;border-top:1px solid #f4f4f5;}
.btn-act{flex:1;padding:8px;border-radius:9px;font-size:.78rem;font-weight:700;cursor:pointer;transition:.15s;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:5px;border:1.5px solid transparent;font-family:'Outfit',sans-serif;}
.btn-edit{background:#f4f4f5;color:#18181b;border-color:#e4e4e7;}
.btn-edit:hover{background:#e4e4e7;}
.btn-del{background:#fef2f2;color:#dc2626;border-color:#fecaca;}
.btn-del:hover{background:#fee2e2;}

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
.btn-m-confirm{background:#dc2626;color:#fff;box-shadow:0 3px 10px rgba(220,38,38,.2);}
.btn-m-confirm:hover{background:#b91c1c;transform:translateY(-1px);}

.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:9999;}
.toast{background:#18181b;color:#fff;padding:12px 20px;border-radius:11px;font-weight:600;font-size:.85rem;box-shadow:0 8px 20px rgba(0,0,0,.15);display:none;animation:slideUp .3s ease-out;}
@keyframes slideUp{from{transform:translateY(16px);opacity:0;}to{transform:translateY(0);opacity:1;}}
</style>

<div class="pg-header">
    <div>
        <div class="pg-title">Suppliers</div>
        <div class="pg-sub">Manage your product and service vendors</div>
    </div>
    <div class="header-right">
        <form action="{{ route('suppliers.index') }}" method="GET" style="display:flex;align-items:center;gap:6px;">
            <div class="search-wrap">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" class="search-input" placeholder="Search suppliers…">
            </div>
            <button type="submit" class="btn-search">Search</button>
        </form>
        <a href="{{ route('suppliers.create') }}" class="btn-add">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Supplier
        </a>
    </div>
</div>

<div class="supp-grid">
    @forelse($suppliers as $supplier)
    <div class="supp-card" id="supplier-{{ $supplier->id }}">
        <div class="supp-icon-wrap">
            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        
        <div class="supp-name">{{ $supplier->name }}</div>
        <div class="supp-contact">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            {{ $supplier->contact_person ?? 'No contact person' }}
        </div>

        <div class="supp-info-list">
            <div class="info-item">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l2.27-2.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                {{ $supplier->phone ?? 'N/A' }}
            </div>
            <div class="info-item">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                {{ $supplier->email ?? 'N/A' }}
            </div>
            <div class="info-item">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m4 0h1m-7 4h1m4 0h1m4 0h1"/></svg>
                Terms: {{ strtoupper(str_replace('_',' ',$supplier->payment_terms ?? 'Default')) }}
            </div>
        </div>

        <div class="supp-actions">
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn-act btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <button type="button" class="btn-act btn-del" onclick="confirmDelete({{ $supplier->id }}, '{{ addslashes($supplier->name) }}')">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
                Delete
            </button>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;padding:60px;text-align:center;background:#fff;border-radius:18px;border:2px dashed #f0e8a0;color:#a1a1aa;">
        No suppliers found. Click "Add Supplier" to get started.
    </div>
    @endforelse
</div>

<div style="margin-top:28px;">{{ $suppliers->links() }}</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delModal">
    <div class="modal-box">
        <div class="modal-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
        </div>
        <div class="modal-title">Delete Supplier?</div>
        <div class="modal-text" id="del_msg">This will permanently remove the supplier from your records.</div>
        <div class="modal-footer">
            <button class="btn-m btn-m-cancel" onclick="hideModal()">Cancel</button>
            <button class="btn-m btn-m-confirm" id="btn-confirm-del">Yes, Delete</button>
        </div>
    </div>
</div>

<div class="toast-wrap"><div class="toast" id="toast"></div></div>

<script>
let deleteId = null;
function confirmDelete(id, name) {
    deleteId = id;
    document.getElementById('del_msg').textContent = `Are you sure you want to delete supplier "${name}"?`;
    document.getElementById('delModal').style.display = 'flex';
}
function hideModal() {
    document.getElementById('delModal').style.display = 'none';
    deleteId = null;
}
document.getElementById('btn-confirm-del').addEventListener('click', async function() {
    if (!deleteId) return;
    const btn = this;
    btn.disabled = true; btn.textContent = 'Deleting...';
    let res, data;
    try {
        res = await fetch(`{{ url('suppliers') }}/${deleteId}`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ _method: 'DELETE' })
        });
        data = await res.json();
    } catch (e) {
        showToast('Server error during deletion.');
        hideModal(); btn.disabled = false; btn.textContent = 'Yes, Delete';
        return;
    }
    if (data.success) {
        const card = document.getElementById(`supplier-${deleteId}`);
        card.style.transition = 'opacity .3s, transform .3s';
        card.style.opacity = '0'; card.style.transform = 'scale(.95)';
        setTimeout(() => { card.remove(); if(!document.querySelector('.supp-card')) location.reload(); }, 300);
        showToast(data.message);
    }
    hideModal(); btn.disabled = false; btn.textContent = 'Yes, Delete';
});
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg; t.style.display = 'block';
    setTimeout(() => t.style.display = 'none', 3000);
}
</script>
@endsection
