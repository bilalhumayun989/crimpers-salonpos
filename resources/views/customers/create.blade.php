@extends('layouts.app')
@section('title', 'Add New Client')

@section('content')
<style>
.form-wrap{max-width:640px;margin:0 auto;}
.form-header{display:flex;align-items:center;gap:16px;margin-bottom:32px;}
.back-btn{width:40px;height:40px;border-radius:12px;border:1.5px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;transition:.2s;background:#fff;}
.back-btn:hover{border-color:#F7DF79;color:#5a4000;background:#FBEFBC;}

.form-card{background:#fff;border-radius:24px;border:1px solid #f1f5f9;box-shadow:0 4px 20px rgba(0,0,0,0.03);overflow:hidden;}
.form-body{padding:32px;}

.img-upload-wrap{display:flex;flex-direction:column;align-items:center;margin-bottom:32px;text-align:center;}
.img-preview-box{width:120px;height:120px;border-radius:50%;background:#f8fafc;border:2px dashed #e2e8f0;display:flex;align-items:center;justify-content:center;overflow:hidden;margin-bottom:12px;cursor:pointer;transition:.2s;position:relative;}
.img-preview-box:hover{border-color:#F7DF79;background:#fffdf0;}
.img-preview-box img{width:100%;height:100%;object-fit:cover;}
.upload-btn{font-size:.78rem;font-weight:700;color:#5a4000;cursor:pointer;padding:6px 12px;background:#FBEFBC;border-radius:99px;}

.f-group{margin-bottom:20px;}
.f-label{display:block;font-size:.8rem;font-weight:700;color:#334155;margin-bottom:8px;text-transform:uppercase;letter-spacing:.05em;}
.f-input{width:100%;padding:12px 16px;border:1.5px solid #e2e8f0;border-radius:12px;font-size:.95rem;font-family:inherit;outline:none;transition:.2s;background:#fcfcfc;}
.f-input:focus{border-color:#F7DF79;background:#fff;box-shadow:0 0 0 4px rgba(247,223,121,.1);}

.social-item{display:flex;gap:10px;margin-bottom:10px;}
.btn-remove-social{padding:12px;color:#ef4444;background:#fff1f2;border-radius:12px;display:flex;align-items:center;justify-content:center;cursor:pointer;border:none;}

.btn-add-social{display:inline-flex;align-items:center;gap:6px;font-size:.8rem;font-weight:700;color:#64748b;cursor:pointer;background:#f1f5f9;padding:6px 16px;border-radius:99px;margin-top:4px;transition:.2s;}
.btn-add-social:hover{background:#e2e8f0;color:#1e293b;}

.form-footer{padding:20px 32px;background:#f8fafc;display:flex;justify-content:flex-end;gap:12px;border-top:1px solid #f1f5f9;}
.btn-save{padding:12px 28px;background:linear-gradient(135deg,#F7DF79,#c9a800);color:#18181b;border-radius:14px;font-weight:800;font-size:.95rem;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(247,223,121,.2);transition:.2s;}
.btn-save:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(247,223,121,.3);}
</style>

<div class="form-wrap">
    <div class="form-header">
        <a href="{{ route('customers.index') }}" class="back-btn">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <div>
            <div style="font-size:1.4rem;font-weight:800;color:#0f172a;">Add New Client</div>
            <div style="font-size:.85rem;color:#64748b;">Fill in the basic info to create a profile</div>
        </div>
    </div>

    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" class="form-card">
        @csrf
        <div class="form-body">
            
            <div class="img-upload-wrap">
                <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;">
                <label for="imageInput" class="img-preview-box" id="imgPreview">
                    <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
                </label>
                <label for="imageInput" class="upload-btn">Choose Photo</label>
                <div style="font-size:.7rem;color:#94a3b8;margin-top:8px;">JPG or PNG, max 2MB</div>
            </div>

            <div class="f-group">
                <label class="f-label">Full Name</label>
                <input type="text" name="name" class="f-input" placeholder="e.g. John Doe" required>
            </div>

            <div class="f-group">
                <label class="f-label">Phone Number</label>
                <input type="text" name="phone" class="f-input" placeholder="e.g. +92 300 1234567" required>
            </div>

            <div class="f-group">
                <label class="f-label">Email Address <span style="font-weight:400;color:#94a3b8;">(Opt)</span></label>
                <input type="email" name="email" class="f-input" placeholder="e.g. john@example.com">
            </div>

            <div class="f-group">
                <label class="f-label">Social Media Handles</label>
                <div id="social_list">
                    <div class="social-item">
                        <input type="text" name="social_media[]" class="f-input" placeholder="e.g. Instagram ID">
                        <span class="btn-remove-social" onclick="this.parentElement.remove()" style="opacity:0;pointer-events:none;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                        </span>
                    </div>
                </div>
                <div class="btn-add-social" onclick="addSocialField()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Add Another Handle
                </div>
            </div>

            <div class="f-group" style="margin-bottom:0;">
                <label class="f-label">Internal Notes</label>
                <textarea name="notes" class="f-input" rows="3" placeholder="Any special preferences or hair history..."></textarea>
            </div>

        </div>

        <div class="form-footer">
            <a href="{{ route('customers.index') }}" style="color:#64748b;text-decoration:none;font-size:.9rem;font-weight:700;margin-right:12px;">Cancel</a>
            <button type="submit" class="btn-save">Save Client Profile</button>
        </div>
    </form>
</div>

<script>
function addSocialField() {
    const list = document.getElementById('social_list');
    const div = document.createElement('div');
    div.className = 'social-item';
    div.innerHTML = `
        <input type="text" name="social_media[]" class="f-input" placeholder="e.g. Social Handle">
        <button type="button" class="btn-remove-social" onclick="this.parentElement.remove()">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    `;
    list.appendChild(div);
}

document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            const preview = document.getElementById('imgPreview');
            preview.innerHTML = `<img src="${evt.target.result}">`;
            preview.style.borderStyle = 'solid';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
