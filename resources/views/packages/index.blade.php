@extends('layouts.app')
@section('title', 'Package Deals')

@section('content')
<style>
.pkg-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px;gap:16px;}
.pkg-title{font-size:1.45rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:4px;}
.pkg-sub{font-size:.85rem;color:#64748b;}
.btn-solid{padding:9px 18px;border:none;background:linear-gradient(135deg,#F7DF79,#c9a800);border-radius:10px;color:#fff;font-size:.85rem;font-weight:600;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(247,223,121,.25);text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.btn-solid:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(247,223,121,.35);}
.btn-outline{padding:9px 18px;border:1.5px solid #e2e8f0;background:#fff;border-radius:10px;color:#64748b;font-size:.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:.2s;font-family:'Outfit',sans-serif;}
.btn-outline:hover{border-color:#F7DF79;color:#c9a800;background:#fffdf0;}

/* Package cards */
.pkg-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:16px;}

.pkg-card{background:#fff;border:1px solid #f0e8a0;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,.04);overflow:hidden;transition:box-shadow .2s;display:flex;flex-direction:column;}
.pkg-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.08);}

.pkg-card-head{padding:20px 22px;border-bottom:1px solid #f8fafc;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;}
.pkg-icon{width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#fffdf0,#FBEFBC);display:flex;align-items:center;justify-content:center;color:#F7DF79;flex-shrink:0;}
.pkg-name{font-size:.95rem;font-weight:700;color:#1e293b;margin-bottom:4px;}
.pkg-desc{font-size:.75rem;color:#94a3b8;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.pkg-price-block{text-align:right;flex-shrink:0;}
.pkg-price{font-size:1.3rem;font-weight:800;color:#c9a800;line-height:1;}
.pkg-price-label{font-size:.68rem;color:#94a3b8;margin-top:2px;}
.pkg-peak-price{font-size:.78rem;font-weight:600;color:#f59e0b;margin-top:3px;}
.pkg-duration{font-size:.78rem;font-weight:600;color:#64748b;margin-top:3px;}

/* Pricing Grid */
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px;}
.pricing-item{background:#f8fafc;border:1px solid #f1f5f9;border-radius:10px;padding:10px 12px;text-align:center;}
.pricing-item-label{font-size:.65rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;}
.pricing-item-val{font-size:.85rem;font-weight:700;color:#1e293b;}
.pricing-item-val.muted{color:#cbd5e1;font-weight:400;}

.pkg-card-body{padding:14px 22px;flex:1;}
.pkg-chips{display:flex;gap:7px;flex-wrap:wrap;margin-bottom:14px;}
.pkg-chip{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-size:.7rem;font-weight:600;}
.chip-active{background:#FBEFBC;color:#a07800;}
.chip-inactive{background:#f1f5f9;color:#64748b;}
.chip-duration{background:#fffdf0;color:#c9a800;}
.chip-count{background:#eff6ff;color:#1d4ed8;}

.services-label{font-size:.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;}
.services-list{display:flex;flex-direction:column;gap:5px;}
.service-item{display:flex;align-items:center;gap:8px;font-size:.82rem;color:#374151;}
.service-dot{width:6px;height:6px;border-radius:50%;background:#F7DF79;flex-shrink:0;}
.service-empty{font-size:.8rem;color:#cbd5e1;font-style:italic;}

.pkg-card-foot{padding:12px 22px;border-top:1px solid #f8fafc;display:flex;align-items:center;justify-content:space-between;}
.action-link{color:#18181b;font-size:.8rem;font-weight:700;text-decoration:none;padding:5px 12px;border-radius:7px;transition:.15s;background:#f4f4f5;border:1.5px solid #e4e4e7;display:inline-flex;align-items:center;gap:4px;}
.action-link:hover{background:#e4e4e7;color:#18181b;}
.action-del{color:#ef4444;font-size:.8rem;font-weight:600;background:none;border:none;cursor:pointer;padding:5px 10px;border-radius:7px;font-family:'Outfit',sans-serif;transition:.15s;display:inline-flex;align-items:center;gap:4px;}
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

<div class="pkg-header">
    <div>
        <div class="pkg-title">Package Deals</div>
        <div class="pkg-sub">Bundle services together with custom pricing</div>
    </div>
    {{-- <div style="display:flex;gap:10px;">
        <a href="{{ route('services.index') }}" class="btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            Services
        </a>
        <a href="{{ route('packages.create') }}" class="btn-solid">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Package
        </a>
    </div> --}}
</div>

@forelse($packages as $package)
@if($loop->first)<div class="pkg-grid">@endif

<div class="pkg-card">
    <div class="pkg-card-head">
        <div style="display:flex;align-items:flex-start;gap:12px;">
            <div class="pkg-icon">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div style="min-width:0;">
                <div class="pkg-name">{{ $package->name }}</div>
                @if($package->description)
                <div class="pkg-desc">{{ $package->description }}</div>
                @endif
            </div>
        </div>
        <div class="pkg-price-block">
            <div class="pkg-price">PKR {{ number_format($package->price, 2) }}</div>
            <div class="pkg-price-label">Package price</div>
            <div class="pkg-duration">{{ $package->duration }} mins</div>
            @if($package->peak_pricing_enabled && $package->peak_price)
            <div class="pkg-peak-price">Peak PKR {{ number_format($package->peak_price, 2) }}</div>
            @endif
        </div>
    </div>

    <div class="pkg-card-body">
        <div class="pkg-chips">
            <span class="pkg-chip {{ $package->is_active ? 'chip-active' : 'chip-inactive' }}">
                <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                {{ $package->is_active ? 'Active' : 'Inactive' }}
            </span>
            <span class="pkg-chip chip-duration">
                <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $package->duration }} mins
            </span>
            @if($package->services->count())
            <span class="pkg-chip chip-count">
                {{ $package->services->count() }} {{ Str::plural('service', $package->services->count()) }}
            </span>
            @endif
            @if($package->peak_pricing_enabled)
            <span class="pkg-chip" style="background:#fff7ed;color:#c2410c;">Peak price active</span>
            @endif
        </div>

        @if($package->pricing_levels)
        <div class="pricing-grid">
            <div class="pricing-item">
                <div class="pricing-item-label">Junior</div>
                <div class="pricing-item-val {{ isset($package->pricing_levels['junior']) ? '' : 'muted' }}">
                    {{ isset($package->pricing_levels['junior']) ? 'PKR '.number_format($package->pricing_levels['junior'],2) : '—' }}
                </div>
            </div>
            <div class="pricing-item">
                <div class="pricing-item-label">Senior</div>
                <div class="pricing-item-val {{ isset($package->pricing_levels['senior']) ? '' : 'muted' }}">
                    {{ isset($package->pricing_levels['senior']) ? 'PKR '.number_format($package->pricing_levels['senior'],2) : '—' }}
                </div>
            </div>
            <div class="pricing-item">
                <div class="pricing-item-label">Master</div>
                <div class="pricing-item-val {{ isset($package->pricing_levels['master']) ? '' : 'muted' }}">
                    {{ isset($package->pricing_levels['master']) ? 'PKR '.number_format($package->pricing_levels['master'],2) : '—' }}
                </div>
            </div>
        </div>
        @endif

        @if($package->peak_pricing_enabled && $package->peak_start && $package->peak_end)
        <div style="font-size:.75rem;color:#94a3b8;display:flex;align-items:center;gap:5px;margin-bottom:14px;">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Peak hours: {{ $package->peak_start }} – {{ $package->peak_end }}
        </div>
        @endif

        <div class="services-label">Included Services</div>
        <div class="services-list">
            @forelse($package->services as $svc)
            <div class="service-item">
                <span class="service-dot"></span>
                <span>{{ $svc->name }}</span>
                <span style="color:#94a3b8;font-size:.72rem;margin-left:auto;">{{ $svc->duration }}m</span>
            </div>
            @empty
            <div class="service-empty">No services added yet</div>
            @endforelse
        </div>
    </div>

    <div class="pkg-card-foot">
        <a href="{{ route('packages.edit', $package) }}" class="action-link" style="background:#f4f4f5;border:1.5px solid #e4e4e7;color:#18181b;padding:6px 14px;">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:3px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit
        </a>
        <button type="button" class="action-del" onclick="confirmDeletePackage({{ $package->id }}, '{{ addslashes($package->name) }}')">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/></svg>
            Delete
        </button>
        <form id="delete-form-{{ $package->id }}" method="POST" action="{{ route('packages.destroy', $package) }}" style="display:none;">
            @csrf @method('DELETE')
        </form>
    </div>
</div>

@if($loop->last)</div>@endif
@empty
<div class="empty-state">
    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
    <p>No packages yet — create your first bundle</p>
</div>
@endforelse

@if($packages->hasPages())
<div class="pagination-wrap">{{ $packages->links() }}</div>
@endif

{{-- Delete Confirmation Modal --}}
<div class="modal-overlay" id="delModal">
    <div class="modal-box">
        <div class="modal-title">Delete Package?</div>
        <div class="modal-sub" id="del_msg_text">Are you sure you want to delete this package deal? This action cannot be undone.</div>
        <div class="m-footer">
            <button type="button" class="btn-m btn-m-cancel" onclick="hideDelModal()">Cancel</button>
            <button type="button" class="btn-m btn-m-delete" id="confirm_del_btn">Delete Package</button>
        </div>
    </div>
</div>

<script>
let packageIdToDelete = null;

function confirmDeletePackage(id, name) {
    packageIdToDelete = id;
    document.getElementById('del_msg_text').textContent = `Are you sure you want to delete "${name}"? All bundle settings will be cleared.`;
    document.getElementById('delModal').style.display = 'flex';
}

function hideDelModal() {
    document.getElementById('delModal').style.display = 'none';
    packageIdToDelete = null;
}

document.getElementById('confirm_del_btn').addEventListener('click', function() {
    if (packageIdToDelete) {
        document.getElementById(`delete-form-${packageIdToDelete}`).submit();
    }
});
</script>
@endsection
