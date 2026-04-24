@extends('layouts.app')
@section('title', 'Service Management')

@section('content')
<style>
.svc-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;}
.svc-title{font-size:1.45rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.svc-sub{font-size:.85rem;color:#64748b;}
.header-actions{display:flex;gap:10px;flex-shrink:0;}
.btn-solid{padding:9px 18px;border:none;background:linear-gradient(135deg,#F7DF79,#c9a800);border-radius:10px;color:#fff;font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(247,223,121,.25);text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.btn-solid:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(247,223,121,.35);}
.btn-outline{padding:9px 18px;border:1.5px solid #e2e8f0;background:#fff;border-radius:10px;color:#64748b;font-size:.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:.2s;font-family:'Outfit',sans-serif;}
.btn-outline:hover{border-color:#F7DF79;color:#c9a800;background:#fffdf0;}

/* Service cards grid */
.svc-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:16px;}

.svc-card{background:#fff;border:1px solid #f0e8a0;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,.04);overflow:hidden;transition:box-shadow .2s;}
.svc-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);}

.svc-card-head{padding:18px 20px;border-bottom:1px solid #f8fafc;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.svc-icon{width:42px;height:42px;border-radius:12px;background:#fffdf0;display:flex;align-items:center;justify-content:center;color:#F7DF79;flex-shrink:0;}
.svc-name{font-size:.95rem;font-weight:700;color:#1e293b;margin-bottom:3px;}
.svc-cat{font-size:.75rem;color:#94a3b8;display:flex;align-items:center;gap:5px;}
.svc-price-block{text-align:right;flex-shrink:0;}
.svc-price{font-size:1.2rem;font-weight:800;color:#c9a800;line-height:1;}
.svc-price-label{font-size:.68rem;color:#94a3b8;margin-top:2px;}
.svc-peak-price{font-size:.78rem;font-weight:600;color:#f59e0b;margin-top:3px;}

.svc-card-body{padding:14px 20px;}
.svc-meta-row{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;}
.svc-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:99px;font-size:.72rem;font-weight:600;}
.chip-duration{background:#fffdf0;color:#c9a800;}
.chip-popular{background:#fef3c7;color:#92400e;}
.chip-peak{background:#fff7ed;color:#c2410c;}
.chip-cat{background:#f1f5f9;color:#475569;}

.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px;}
.pricing-item{background:#f8fafc;border:1px solid #f1f5f9;border-radius:10px;padding:10px 12px;text-align:center;}
.pricing-item-label{font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}
.pricing-item-val{font-size:.9rem;font-weight:700;color:#1e293b;}
.pricing-item-val.muted{color:#cbd5e1;font-weight:400;}

.svc-card-foot{padding:12px 20px;border-top:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;}
.action-link{color:#18181b;font-size:.8rem;font-weight:700;text-decoration:none;padding:5px 12px;border-radius:7px;transition:.15s;background:#f4f4f5;border:1.5px solid #e4e4e7;display:inline-flex;align-items:center;gap:4px;}
.action-link:hover{background:#e4e4e7;color:#18181b;}
.action-del{color:#ef4444;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;padding:5px 10px;border-radius:7px;font-family:'Outfit',sans-serif;transition:.15s;}
.action-del:hover{background:#fef2f2;}

.empty-state{background:#fff;border:1px solid #f0e8a0;border-radius:16px;padding:60px 20px;text-align:center;color:#cbd5e1;}
.empty-state svg{margin:0 auto 14px;display:block;opacity:.3;}
.empty-state p{font-size:.9rem;font-weight:500;}

.pagination-wrap{margin-top:20px;}

/* Custom Delete Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;z-index:100;padding:20px;}
.modal-box{background:#fff;border-radius:18px;width:100%;max-width:400px;padding:26px;box-shadow:0 20px 50px rgba(0,0,0,.15);border:1px solid #fee2e2;}
.modal-title{font-size:1.15rem;font-weight:800;color:#ef4444;margin-bottom:10px;}
.modal-sub{font-size:.85rem;color:#64748b;line-height:1.5;margin-bottom:24px;}
.m-footer{display:flex;gap:10px;}
.btn-m{flex:1;padding:11px;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;border:none;font-family:inherit;transition:.2s;}
.btn-m-cancel{background:#f1f5f9;color:#64748b;}
.btn-m-cancel:hover{background:#e2e8f0;}
.btn-m-delete{background:#ef4444;color:#fff;}
.btn-m-delete:hover{background:#dc2626;transform:translateY(-1px);}
</style>

<div class="svc-header">
    <div>
        <div class="svc-title">Service Management</div>
        <div class="svc-sub">Manage services, pricing tiers, and peak-hour rates</div>
    </div>
    {{-- <div class="header-actions">
        @if(Route::has('packages.index'))
        <a href="{{ route('packages.index') }}" class="btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Packages
        </a>
        @endif
        <a href="{{ route('services.create') }}" class="btn-solid">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Service
        </a>
    </div> --}}
</div>

@if($services->count())
<div class="svc-grid">
    @foreach($services as $service)
    <div class="svc-card">
        <div class="svc-card-head">
            <div style="display:flex;align-items:flex-start;gap:12px;">
                <div class="svc-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <div>
                    <div class="svc-name">{{ $service->name }}</div>
                    <div class="svc-cat">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        {{ $service->category->name ?? 'Uncategorized' }}
                    </div>
                </div>
            </div>
            <div class="svc-price-block">
                <div class="svc-price">PKR {{ number_format($service->price, 2) }}</div>
                <div class="svc-price-label">Base price</div>
                @if($service->peak_pricing_enabled && $service->peak_price)
                <div class="svc-peak-price">Peak PKR {{ number_format($service->peak_price, 2) }}</div>
                @endif
            </div>
        </div>

        <div class="svc-card-body">
            <div class="svc-meta-row">
                <span class="svc-chip chip-duration">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ $service->duration }} mins
                </span>
                @if($service->is_popular)
                <span class="svc-chip chip-popular">⭐ Popular</span>
                @endif
                @if($service->peak_pricing_enabled)
                <span class="svc-chip chip-peak">Peak pricing on</span>
                @endif
            </div>

            @if($service->pricing_levels)
            <div class="pricing-grid">
                <div class="pricing-item">
                    <div class="pricing-item-label">Junior</div>
                    <div class="pricing-item-val {{ isset($service->pricing_levels['junior']) ? '' : 'muted' }}">
                        {{ isset($service->pricing_levels['junior']) ? 'PKR '.number_format($service->pricing_levels['junior'],2) : '—' }}
                    </div>
                </div>
                <div class="pricing-item">
                    <div class="pricing-item-label">Senior</div>
                    <div class="pricing-item-val {{ isset($service->pricing_levels['senior']) ? '' : 'muted' }}">
                        {{ isset($service->pricing_levels['senior']) ? 'PKR '.number_format($service->pricing_levels['senior'],2) : '—' }}
                    </div>
                </div>
                <div class="pricing-item">
                    <div class="pricing-item-label">Master</div>
                    <div class="pricing-item-val {{ isset($service->pricing_levels['master']) ? '' : 'muted' }}">
                        {{ isset($service->pricing_levels['master']) ? 'PKR '.number_format($service->pricing_levels['master'],2) : '—' }}
                    </div>
                </div>
            </div>
            @endif

            @if($service->peak_pricing_enabled && $service->peak_start && $service->peak_end)
            <div style="font-size:.75rem;color:#94a3b8;display:flex;align-items:center;gap:5px;">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Peak hours: {{ optional($service->peak_start)->format('H:i') }} – {{ optional($service->peak_end)->format('H:i') }}
            </div>
            @endif
        </div>

        <div class="svc-card-foot">
            <a href="{{ route('services.edit', $service) }}" class="action-link">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:3px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <button type="button" class="action-del" onclick="confirmDeleteService({{ $service->id }}, '{{ addslashes($service->name) }}')">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:3px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                Delete
            </button>
            <form id="delete-form-{{ $service->id }}" method="POST" action="{{ route('services.destroy', $service) }}" style="display:none;">
                @csrf @method('DELETE')
            </form>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
    <p>No services yet — create your first one</p>
</div>
@endif

@if($services->hasPages())
<div class="pagination-wrap">{{ $services->links() }}</div>
@endif

{{-- Delete Confirmation Modal --}}
<div class="modal-overlay" id="delModal">
    <div class="modal-box">
        <div class="modal-title">Delete Service?</div>
        <div class="modal-sub" id="del_msg_text">Are you sure you want to delete this service? This action cannot be undone.</div>
        <div class="m-footer">
            <button type="button" class="btn-m btn-m-cancel" onclick="hideDelModal()">Cancel</button>
            <button type="button" class="btn-m btn-m-delete" id="confirm_del_btn">Delete Service</button>
        </div>
    </div>
</div>

<script>
let serviceIdToDelete = null;

function confirmDeleteService(id, name) {
    serviceIdToDelete = id;
    document.getElementById('del_msg_text').textContent = `Are you sure you want to delete "${name}"? All associated data will be removed.`;
    document.getElementById('delModal').style.display = 'flex';
}

function hideDelModal() {
    document.getElementById('delModal').style.display = 'none';
    serviceIdToDelete = null;
}

document.getElementById('confirm_del_btn').addEventListener('click', function() {
    if (serviceIdToDelete) {
        document.getElementById(`delete-form-${serviceIdToDelete}`).submit();
    }
});
</script>
@endsection
