@extends('layouts.app')
@section('title', 'New Service')

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
.form-section:last-of-type{border-bottom:none;}
.section-title{font-size:.78rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:16px;display:flex;align-items:center;gap:7px;}
.section-icon{width:22px;height:22px;border-radius:6px;display:flex;align-items:center;justify-content:center;}

.f-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.f-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;}
.f-row{margin-bottom:0;}
.f-label{display:block;font-size:.78rem;font-weight:600;color:#374151;margin-bottom:7px;}
.f-input{width:100%;padding:10px 13px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:.875rem;font-family:'Outfit',sans-serif;color:#1e293b;background:#fafafa;outline:none;transition:.2s;}
.f-input:focus{border-color:#F7DF79;background:#fff;box-shadow:0 0 0 3px rgba(247,223,121,.1);}
.f-input::placeholder{color:#9ca3af;}
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
.btn-save:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(247,223,121,.35);}

/* Quick Add Category Modal */
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);backdrop-filter:blur(3px);display:none;align-items:center;justify-content:center;z-index:100;padding:20px;}
.modal-box{background:#fff;border-radius:18px;width:100%;max-width:360px;padding:24px;box-shadow:0 20px 50px rgba(0,0,0,.15);border:1px solid #f0e8a0;}
.modal-title{font-size:1.1rem;font-weight:800;color:#0f172a;margin-bottom:8px;}
.modal-sub{font-size:.8rem;color:#64748b;margin-bottom:18px;}
.m-footer{display:flex;gap:10px;margin-top:20px;}
.btn-m{flex:1;padding:10px;border-radius:10px;font-size:.85rem;font-weight:700;cursor:pointer;border:none;font-family:inherit;}
.btn-m-cancel{background:#f1f5f9;color:#64748b;}
.btn-m-save{background:#c9a800;color:#fff;}

/* Toast Notifications */
.toast-container{position:fixed;top:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:12px;pointer-events:none;}
.toast{min-width:280px;background:#fff;border-radius:12px;padding:16px;display:flex;align-items:center;gap:12px;box-shadow:0 10px 25px rgba(0,0,0,.15);border:1px solid #e2e8f0;transform:translateX(100%);transition:.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);pointer-events:auto;}
.toast.show{transform:translateX(0);}
.toast-icon{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.ti-success{background:#FBEFBC;color:#c9a800;}
.ti-error{background:#fee2e2;color:#dc2626;}
.toast-msg{font-size:.85rem;font-weight:600;color:#1e293b;}

/* Delete Modal Specifics */
.modal-box.delete-confirm{border-color:#fee2e2;max-width:400px;}
.btn-m-delete{background:#ef4444;color:#fff;}
</style>

<div class="form-wrap">
    <div class="form-header">
        <a href="{{ route('services.index') }}" class="back-btn">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
        <div>
            <div class="form-title">New Service</div>
            <div class="form-sub">Create a service with pricing tiers and peak-hour rates</div>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            {{-- Basic info --}}
            <div class="form-section">
                <div class="section-title">
                    <div class="section-icon" style="background:#fffdf0;color:#F7DF79;">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    Basic Information
                </div>
                <div class="f-grid-2" style="margin-bottom:14px;">
                    <div>
                        <label class="f-label">Service Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="f-input" placeholder="e.g. Men's Haircut">
                    </div>
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">
                            <label class="f-label" style="margin-bottom:0;">Category</label>
                            <div style="display:flex;gap:12px;">
                                <button type="button" onclick="showCatModal()" style="font-size:.7rem;font-weight:700;color:#c9a800;background:none;border:none;cursor:pointer;padding:0;">+ Add New</button>
                                <button type="button" id="delete_cat_btn" onclick="deleteSelectedCat()" style="font-size:.7rem;font-weight:700;color:#ef4444;background:none;border:none;cursor:pointer;padding:0;">- Delete Selected</button>
                            </div>
                        </div>
                        <select name="category_id" id="cat_select" required class="f-input">
                            <option value="">Select category…</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="f-grid-3">
                    <div>
                        <label class="f-label">Base Price (PKR)</label>
                        <div class="f-prefix-wrap">
                            <span class="f-prefix">PKR</span>
                            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required class="f-input has-prefix" placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="f-label">Duration (mins)</label>
                        <input type="number" min="1" name="duration" value="{{ old('duration',30) }}" required class="f-input" placeholder="30">
                    </div>
                    <div style="display:flex;align-items:flex-end;padding-bottom:2px;">
                        <label class="check-row">
                            <input type="checkbox" name="is_popular" value="1" {{ old('is_popular')?'checked':'' }}>
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
                        <input type="checkbox" name="pricing_levels_enabled" value="1" {{ old('pricing_levels_enabled')?'checked':'' }} id="pricing_toggle">
                        Enable Tiers
                    </label>
                </div>

                <div id="pricing_tiers_box" style="display: {{ old('pricing_levels_enabled') ? 'block' : 'none' }}; margin-top: 14px;">
                    <div class="f-grid-3">
                        <div>
                            <label class="f-label">Junior Price (PKR)</label>
                            <div class="f-prefix-wrap">
                                <span class="f-prefix">PKR</span>
                                <input type="number" step="0.01" min="0" name="pricing_levels[junior]" value="{{ old('pricing_levels.junior') }}" class="f-input has-prefix" placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="f-label">Senior Price (PKR)</label>
                            <div class="f-prefix-wrap">
                                <span class="f-prefix">PKR</span>
                                <input type="number" step="0.01" min="0" name="pricing_levels[senior]" value="{{ old('pricing_levels.senior') }}" class="f-input has-prefix" placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="f-label">Master Price (PKR)</label>
                            <div class="f-prefix-wrap">
                                <span class="f-prefix">PKR</span>
                                <input type="number" step="0.01" min="0" name="pricing_levels[master]" value="{{ old('pricing_levels.master') }}" class="f-input has-prefix" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peak pricing --}}
            <div class="form-section">
                <div class="toggle-row">
                    <div>
                        <div class="toggle-info-title">Peak Hour Pricing</div>
                        <div class="toggle-info-sub">Charge a higher rate during busy hours</div>
                    </div>
                    <label class="toggle-label">
                        <input type="checkbox" name="peak_pricing_enabled" value="1" {{ old('peak_pricing_enabled')?'checked':'' }}>
                        Enable
                    </label>
                </div>
                <div class="peak-box">
                    <div class="peak-box-title">Peak Hour Settings</div>
                    <div class="f-grid-3">
                        <div>
                            <label class="f-label">Peak Price (PKR)</label>
                            <div class="f-prefix-wrap">
                                <span class="f-prefix">PKR</span>
                                <input type="number" step="0.01" min="0" name="peak_price" value="{{ old('peak_price') }}" class="f-input has-prefix" placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="f-label">Start Time</label>
                            <input type="time" name="peak_start" value="{{ old('peak_start') }}" class="f-input">
                        </div>
                        <div>
                            <label class="f-label">End Time</label>
                            <input type="time" name="peak_end" value="{{ old('peak_end') }}" class="f-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('services.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">Create Service</button>
            </div>
        </form>
    </div>
</div>

{{-- Quick Add Modal --}}
<div class="modal-overlay" id="catModal">
    <div class="modal-box">
        <div class="modal-title">New Category</div>
        <div class="modal-sub">Create a new category for your services</div>
        <div class="f-row">
            <label class="f-label">Category Name</label>
            <input type="text" id="new_cat_name" class="f-input" placeholder="e.g. Skin Care">
        </div>
        <div class="m-footer">
            <button type="button" class="btn-m btn-m-cancel" onclick="hideCatModal()">Cancel</button>
            <button type="button" class="btn-m btn-m-save" id="save_cat_btn">Create Category</button>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal-overlay" id="delCatModal">
    <div class="modal-box delete-confirm">
        <div class="modal-title" style="color:#ef4444;">Delete Category?</div>
        <div class="modal-sub" id="del_msg_text">Are you sure you want to delete this category? All services in it will be affected.</div>
        <div class="m-footer">
            <button type="button" class="btn-m btn-m-cancel" onclick="hideDelModal()">Keep Category</button>
            <button type="button" class="btn-m btn-m-delete" id="confirm_del_btn">Delete Permanently</button>
        </div>
    </div>
</div>

<div class="toast-container" id="toast_container"></div>

<script>
function showCatModal() { document.getElementById('catModal').style.display = 'flex'; }
function hideCatModal() { document.getElementById('catModal').style.display = 'none'; document.getElementById('new_cat_name').value = ''; }

function showDelModal() { document.getElementById('delCatModal').style.display = 'flex'; }
function hideDelModal() { document.getElementById('delCatModal').style.display = 'none'; }

function showToast(msg, type = 'success') {
    const container = document.getElementById('toast_container');
    const toast = document.createElement('div');
    toast.className = `toast`;
    toast.innerHTML = `
        <div class="toast-icon ${type === 'success' ? 'ti-success' : 'ti-error'}">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"/></svg>
        </div>
        <div class="toast-msg">${msg}</div>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

const catSelect = document.getElementById('cat_select');
const deleteBtn = document.getElementById('delete_cat_btn');

catSelect.addEventListener('change', function() {
    deleteBtn.style.display = this.value ? 'inline-block' : 'none';
});

let categoryToDelete = null;

async function deleteSelectedCat() {
    const id = catSelect.value;
    const name = catSelect.options[catSelect.selectedIndex].text;
    if (!id) return;
    
    categoryToDelete = id;
    document.getElementById('del_msg_text').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
    showDelModal();
}

document.getElementById('confirm_del_btn').addEventListener('click', async function() {
    if (!categoryToDelete) return;
    
    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Deleting...';

    try {
        const response = await fetch(`{{ url('categories') }}/${categoryToDelete}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: '_method=DELETE'
        });

        const data = await response.json();
        if (data.success) {
            catSelect.remove(catSelect.selectedIndex);
            catSelect.dispatchEvent(new Event('change'));
            showToast(data.message);
            hideDelModal();
        } else {
            showToast(data.message || 'Failed to delete', 'error');
        }
    } catch (error) {
        console.error("Error deleting category:", error);
        showToast('Server error. Failed to delete.', 'error');
    }
    btn.disabled = false;
    btn.textContent = 'Delete Permanently';
    categoryToDelete = null;
});

document.getElementById('save_cat_btn').addEventListener('click', async function() {
    const name = document.getElementById('new_cat_name').value;
    if (!name) { showToast('Please enter a name', 'error'); return; }

    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Saving...';

    const response = await fetch("{{ route('categories.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ name: name, type: 'service' })
    });

    const data = await response.json();
    if (data.success) {
        const option = new Option(data.category.name, data.category.id, true, true);
        catSelect.add(option);
        catSelect.dispatchEvent(new Event('change'));
        showToast(data.message || 'Category added!');
        hideCatModal();
    } else {
        showToast('Failed to create category', 'error');
    }
    btn.disabled = false;
    btn.textContent = 'Create Category';
});

// Toggle boxes
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
