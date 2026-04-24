<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — The Crimpers</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--y1:#F7DF79;--y2:#FBEFBC;--yd:#c9a800;--yk:#a07800;--ybg:#fffdf0;}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Outfit',sans-serif;}

        body{min-height:100vh;display:flex;background:#0f0f0f;overflow:hidden;}

        .auth-left{flex:1;background:linear-gradient(160deg,#1a1a1a 0%,#111 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 40px;position:relative;overflow:hidden;}
        .auth-left::before{content:'';position:absolute;top:-80px;left:-80px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(247,223,121,.12) 0%,transparent 70%);}
        .auth-left-content{position:relative;z-index:1;text-align:center;max-width:320px;}
        .auth-brand-icon{width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,var(--y1),var(--yd));display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 12px 30px rgba(199,168,0,.3);}
        .auth-brand-name{font-size:2rem;font-weight:800;color:#fff;letter-spacing:-.03em;margin-bottom:8px;}
        .auth-brand-sub{font-size:.9rem;color:#71717a;line-height:1.6;}

        .auth-right{width:460px;background:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:50px 48px;position:relative;}
        @media(max-width:768px){.auth-left{display:none;}.auth-right{width:100%;padding:40px 28px;}}

        .form-header{width:100%;margin-bottom:28px;}
        .form-header-icon{width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,var(--y1),var(--yd));display:flex;align-items:center;justify-content:center;margin-bottom:16px;box-shadow:0 6px 16px rgba(199,168,0,.25);}
        .form-header h2{font-size:1.5rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:6px;}
        .form-header p{font-size:.875rem;color:#64748b;line-height:1.6;}

        .f-group{margin-bottom:16px;width:100%;}
        .f-label{display:block;font-size:.82rem;font-weight:700;color:#334155;margin-bottom:7px;}
        .f-input{width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:11px;font-family:'Outfit',sans-serif;font-size:.9rem;color:#18181b;outline:none;transition:.2s;background:#fff;}
        .f-input:focus{border-color:var(--yd);box-shadow:0 0 0 3px rgba(199,168,0,.12);}
        .f-input:disabled{background:#f8fafc;color:#94a3b8;cursor:not-allowed;}

        .btn-reset{width:100%;padding:13px;background:linear-gradient(135deg,var(--y1),var(--yd));border:none;border-radius:11px;color:#18181b;font-size:.95rem;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;box-shadow:0 4px 14px rgba(199,168,0,.3);transition:.2s;margin-top:6px;}
        .btn-reset:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(199,168,0,.4);}

        .error-box{background:#fef2f2;border:1.5px solid #fecaca;border-radius:10px;padding:11px 14px;margin-bottom:20px;color:#dc2626;font-size:.83rem;font-weight:600;display:flex;align-items:center;gap:8px;width:100%;}

        .back-link{margin-top:20px;text-align:center;}
        .back-link a{font-size:.82rem;color:#64748b;text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:5px;transition:.15s;}
        .back-link a:hover{color:#18181b;}

        .auth-footer{position:absolute;bottom:20px;font-size:.72rem;color:#94a3b8;font-weight:500;}
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-brand-icon">
                <svg width="36" height="36" fill="none" stroke="#18181b" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 21a9 9 0 110-18 9 9 0 010 18z"/><path d="M12 8v4l3 3"/></svg>
            </div>
            <div class="auth-brand-name">The Crimpers</div>
            <div class="auth-brand-sub">Create a strong new password to secure your account.</div>
        </div>
    </div>

    <div class="auth-right">
        <div class="form-header">
            <div class="form-header-icon">
                <svg width="24" height="24" fill="none" stroke="#18181b" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 11V7l-4 4m4-4l4 4m-4-4v14"/></svg>
            </div>
            <h2>Set New Password</h2>
            <p>Enter your new password below to regain access to your account.</p>
        </div>

        @if($errors->any())
        <div class="error-box">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" style="width:100%;">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="f-group">
                <label class="f-label">Email Address</label>
                <input type="email" name="email" value="{{ request()->email }}" required disabled class="f-input">
            </div>

            <div class="f-group">
                <label class="f-label">New Password</label>
                <input type="password" name="password" required class="f-input" placeholder="Min. 8 characters">
            </div>

            <div class="f-group">
                <label class="f-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" required class="f-input" placeholder="Repeat new password">
            </div>

            <button type="submit" class="btn-reset">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>
                Update Password
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5m7 7l-7-7 7-7"/></svg>
                Back to Login
            </a>
        </div>

        <div class="auth-footer">Powered by The Crimpers</div>
    </div>
</body>
</html>
