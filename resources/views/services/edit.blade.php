@extends('layouts.app')
@section('title', 'Edit Service')
@section('content')
<style>
.form-wrap{max-width:760px;margin:0 auto;}
.form-header{display:flex;align-items:center;gap:12px;margin-bottom:24px;}
.back-btn{width:36px;height:36px;border-radius:9px;border:1.5px solid #e2e8f0;background:#fff;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;transition:.2s;flex-shrink:0;}
.back-btn:hover{border-color:#F7DF79;color:#c9a800;background:#fffdf0;}
.form-title{font-size:1.4rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:3px;}
.form-sub{font-size:.85rem;color:#64748b;}
.form-card{background:#fff;border:1px solid #f0e8a0;border-radius:18px;box-shadow:0 2px 12px rgba(0,0,0,.05);overflow:hidden;}
.form-section{padding:22px 26px;border-bottom:1px solid #f1f5f9;}
.section-title{font-size:.78rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:16px;display:flex;align-items:center;gap:7px;}
.section-icon{width:22px;height:22px;border-radius:6px;display:flex;align-items:center;justify-content:center;}
.f-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.f-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.f-label{display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:7px;}
.f-input{width:100%;padding:10px 13px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:.875rem;font-family:'Outfit',sans-serif;color:#1e293b;background:#fafafa;outline:none;transition:.2s;}
.f-input:focus{border-color:#F7DF79;background:#fff;box-shadow:0 0 0 3px rgba(247,223,121,.1);}
.f-prefix-wrap{position:relative;}
.f-prefix{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:.82rem;font-weight:600;color:#94a3b8;pointer-events:none;white-space:nowrap;}
.f-input.has-prefix{padding-left:46px;}
.toggle-row{display:flex;align-items:center;justify-content:space-between;padding:14px 0;}
.toggle-info-title{font-size:.875rem;font-weight:600;color:#1e293b;margin-bottom:2px;}
.toggle-info-sub{font-size:.75rem;color:#94a3b8;}
.toggle-label{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.82rem;font-weight:600;color:#374151;}
.toggle-label input[type=checkbox]{width:16px;height:16px;accent-color:#c9a800;cursor:pointer;}
.check-row{display:flex;align-items:center;gap:8px;cursor:pointer;}
.check-row input[type=checkbox]{width:15px;height:15px;accent-color:#c9a800;cursor:pointer;}
.check-label{font-size:.85rem;font-weight:600;color:#374151;}
.peak-box{background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:16px 18px;margin-top:14px;}
.peak-box-title{font-size:.78rem;font-weight:700;color:#92400e;text-transform:uppercase;letter-spacing:.07em;margin-bottom:12px;}
.form-footer{padding:18px 26px;border-top:1px solid #f1f5f9;display:flex;gap:10px;justify-content:flex-end;}
.btn-cancel{padding:10px 22px;border:1.5px solid #e2e8f0;background:#fff;border-radius:10px;color:#64748b;font-size:.875rem;font-weight:600;cursor:pointer;text-decoration:none;font-family:'Outfit',sans-serif;transition:.2s;}
.btn-cancel:hover{border-color:#fca5a5;color:#dc2626;background:#fef2f2;}
.btn-save{padding:10px 22px;border:none;background:linear-gradient(135deg,#F7DF79,#c9a800);border-radius:10px;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;box-shadow:0 3px 10px rgba(247,223,121,.25);}
.btn-save:hover{transform:translateY(-1px);}
.danger-zone{margin-top:20px;background:#fff;border:1px solid #fecaca;border-radius:14px;padding:18px 22px;display:flex;align-items:center;justify-content:space-between;gap:16px;}
.danger-title{font-size:.875rem;font-weight:700;color:#b91c1c;margin-bottom:2px;}
.danger-sub{font-size:.75rem;color:#94a3b8;}
.btn-danger{padding:8px 16px;border:1.5px solid #fca5a5;background:#fef2f2;border-radius:9px;color:#dc2626;font-size:.8rem;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;transition:.2s;}
.btn-danger:hover{background:#fee2e2;}
</style>
<div class="form-wrap">
  <div class="form-header">
    <a href="{{ route('services.index') }}" class="back-btn">
      <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
    <div>
      <div class="form-title">Edit Service</div>
      <div class="form-sub">{{ $service->name }}</div>
    </div>
  </div>
  <div class="form-card">
    <form action="{{ route('services.update', $service) }}" method="POST">
      @csrf @method('PUT')
      <div class="form-section">
        <div class="section-title">
          <div class="section-icon" style="background:#fffdf0;color:#F7DF79;"><svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg></div>
          Basic Information
        </div>
        <div class="f-grid-2" style="margin-bottom:14px;">
          <div>
            <label class="f-label">Service Name</label>
            <input type="text" name="name" value="{{ old('name',$service->name) }}" required class="f-input">
          </div>
          <div>
            <label class="f-label">Category</label>
            <select name="category_id" required class="f-input">
              <option value="">Select category</option>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id',$service->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="f-grid-3">
          <div>
            <label class="f-label">Base Price ($)</label>
            <div class="f-prefix-wrap"><span class="f-prefix">PKR</span>
              <input type="number" step="0.01" min="0" name="price" value="{{ old('price',$service->price) }}" required class="f-input has-prefix">
            </div>
          </div>
          <div>
            <label class="f-label">Duration (mins)</label>
            <input type="number" min="1" name="duration" value="{{ old('duration',$service->duration) }}" required class="f-input">
          </div>
          <div style="display:flex;align-items:flex-end;padding-bottom:2px;">
            <label class="check-row">
              <input type="checkbox" name="is_popular" value="1" {{ old('is_popular',$service->is_popular)?'checked':'' }}>
              <span class="check-label">Mark as popular</span>
            </label>
          </div>
        </div>
      </div>
      {{-- Staff pricing --}}
      <div class="form-section">
        <div class="toggle-row">
            <div>
                <div class="toggle-info-title">Staff Level Pricing</div>
                <div class="toggle-info-sub">Enable separate rates for Junior, Senior, and Master staff</div>
            </div>
            <label class="toggle-label">
                <input type="checkbox" name="pricing_levels_enabled" value="1" {{ old('pricing_levels_enabled',$service->pricing_levels_enabled)?'checked':'' }} id="pricing_toggle">
                Enable Tiers
            </label>
        </div>

        <div id="pricing_tiers_box" style="display: {{ old('pricing_levels_enabled',$service->pricing_levels_enabled) ? 'block' : 'none' }}; margin-top: 14px;">
            <div class="f-grid-3">
                <div>
                    <label class="f-label">Junior Price (PKR)</label>
                    <div class="f-prefix-wrap">
                        <span class="f-prefix">PKR</span>
                        <input type="number" step="0.01" min="0" name="pricing_levels[junior]" value="{{ old('pricing_levels.junior',$service->pricing_levels['junior']??'') }}" class="f-input has-prefix" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="f-label">Senior Price (PKR)</label>
                    <div class="f-prefix-wrap">
                        <span class="f-prefix">PKR</span>
                        <input type="number" step="0.01" min="0" name="pricing_levels[senior]" value="{{ old('pricing_levels.senior',$service->pricing_levels['senior']??'') }}" class="f-input has-prefix" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="f-label">Master Price (PKR)</label>
                    <div class="f-prefix-wrap">
                        <span class="f-prefix">PKR</span>
                        <input type="number" step="0.01" min="0" name="pricing_levels[master]" value="{{ old('pricing_levels.master',$service->pricing_levels['master']??'') }}" class="f-input has-prefix" placeholder="0.00">
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="form-section">
        <div class="toggle-row">
          <div><div class="toggle-info-title">Peak Hour Pricing</div><div class="toggle-info-sub">Charge higher rates during busy hours</div></div>
          <label class="toggle-label"><input type="checkbox" name="peak_pricing_enabled" value="1" {{ old('peak_pricing_enabled',$service->peak_pricing_enabled)?'checked':'' }}>Enable</label>
        </div>
        <div class="peak-box">
          <div class="peak-box-title">Peak Hour Settings</div>
          <div class="f-grid-3">
            <div><label class="f-label">Peak Price ($)</label><div class="f-prefix-wrap"><span class="f-prefix">PKR</span><input type="number" step="0.01" min="0" name="peak_price" value="{{ old('peak_price',$service->peak_price) }}" class="f-input has-prefix" placeholder="0.00"></div></div>
            <div><label class="f-label">Start Time</label><input type="time" name="peak_start" value="{{ old('peak_start',$service->peak_start) }}" class="f-input"></div>
            <div><label class="f-label">End Time</label><input type="time" name="peak_end" value="{{ old('peak_end',$service->peak_end) }}" class="f-input"></div>
          </div>
        </div>
      </div>
      <div class="form-footer">
        <a href="{{ route('services.index') }}" class="btn-cancel">Cancel</a>
        <button type="submit" class="btn-save">Save Changes</button>
      </div>
    </form>
  </div>
  <div class="danger-zone">
    <div><div class="danger-title">Delete Service</div><div class="danger-sub">This cannot be undone</div></div>
    <form method="POST" action="{{ route('services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
      @csrf @method('DELETE')
      <button type="submit" class="btn-danger">Delete Service</button>
    </form>
  </div>
</div>
<script>
document.getElementById('pricing_toggle').addEventListener('change', function() {
    document.getElementById('pricing_tiers_box').style.display = this.checked ? 'block' : 'none';
});

document.querySelector('input[name="peak_pricing_enabled"]').addEventListener('change', function() {
    document.querySelector('.peak-box').style.display = this.checked ? 'block' : 'none';
});

// Initial state for peak-box
if (!document.querySelector('input[name="peak_pricing_enabled"]').checked) {
    document.querySelector('.peak-box').style.display = 'none';
}
</script>
@endsection
