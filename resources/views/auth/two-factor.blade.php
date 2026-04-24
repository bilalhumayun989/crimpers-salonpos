<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Verification — The Crimpers</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--y1:#F7DF79;--y2:#FBEFBC;--yd:#c9a800;--yk:#a07800;--ybg:#fffdf0;}
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Outfit',sans-serif;}

        body{
            min-height:100vh;
            display:flex;
            background:#0f0f0f;
            overflow-y:auto;
        }

        .auth-left{
            flex:1;background:linear-gradient(160deg,#1a1a1a 0%,#111 100%);
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            padding:40px;position:sticky;top:0;height:100vh;overflow:hidden;
        }
        .auth-left::before{content:'';position:absolute;top:-80px;left:-80px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(247,223,121,.12) 0%,transparent 70%);}
        .auth-left-content{position:relative;z-index:1;text-align:center;max-width:300px;}
        .auth-brand-icon{width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,var(--y1),var(--yd));display:flex;align-items:center;justify-content:center;margin:0 auto 20px;box-shadow:0 10px 24px rgba(199,168,0,.3);}
        .auth-brand-name{font-size:1.8rem;font-weight:800;color:#fff;letter-spacing:-.03em;margin-bottom:8px;}
        .auth-brand-sub{font-size:.85rem;color:#71717a;line-height:1.6;}

        .auth-right{
            width:480px;min-width:480px;background:#fff;
            display:flex;flex-direction:column;align-items:center;justify-content:flex-start;
            padding:40px 44px;min-height:100vh;
        }
        .auth-right-inner{
            width:100%;max-width:400px;
            margin:auto;
            padding:20px 0;
        }
        @media(max-width:900px){.auth-left{display:none;}.auth-right{width:100%;min-width:0;padding:32px 24px;}}

        .form-header{width:100%;margin-bottom:22px;text-align:center;}
        .form-header-icon{width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,var(--y1),var(--yd));display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 6px 16px rgba(199,168,0,.25);}
        .form-header h2{font-size:1.4rem;font-weight:800;color:#0f172a;letter-spacing:-.02em;margin-bottom:5px;}
        .form-header p{font-size:.82rem;color:#64748b;line-height:1.6;}

        /* QR Section */
        .qr-card{background:var(--ybg);border:1.5px solid #f0e8b0;border-radius:14px;padding:18px;margin-bottom:18px;width:100%;text-align:center;}
        .qr-card img,.qr-card svg{width:140px;height:140px;}
        .qr-label{font-size:.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin-top:12px;margin-bottom:5px;}
        .qr-secret{font-family:monospace;font-size:.8rem;color:var(--yk);background:#fff;border:1.5px dashed #f0e8b0;border-radius:7px;padding:6px 10px;display:inline-block;letter-spacing:.04em;word-break:break-all;}

        /* Code Input */
        .code-group{width:100%;margin-bottom:16px;}
        .code-label{display:block;font-size:.78rem;font-weight:700;color:#334155;margin-bottom:8px;text-align:center;text-transform:uppercase;letter-spacing:.06em;}
        .code-input{
            width:100%;padding:13px;
            letter-spacing:10px;font-size:1.8rem;text-align:center;font-weight:800;
            border:1.5px solid #e2e8f0;border-radius:12px;
            background:#fff;outline:none;transition:.2s;color:#0f172a;
        }
        .code-input:focus{border-color:var(--yd);box-shadow:0 0 0 3px rgba(199,168,0,.12);}

        .btn-verify{
            width:100%;padding:12px;
            background:linear-gradient(135deg,var(--y1),var(--yd));
            border:none;border-radius:11px;
            color:#18181b;font-size:.9rem;font-weight:700;
            cursor:pointer;font-family:'Outfit',sans-serif;
            box-shadow:0 4px 14px rgba(199,168,0,.3);transition:.2s;
        }
        .btn-verify:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(199,168,0,.4);}

        .error-box{background:#fef2f2;border:1.5px solid #fecaca;border-radius:10px;padding:10px 13px;margin-bottom:16px;color:#dc2626;font-size:.82rem;font-weight:600;display:flex;align-items:center;gap:8px;width:100%;}

        .cancel-wrap{margin-top:14px;text-align:center;}
        .cancel-wrap button{background:none;border:none;color:#94a3b8;cursor:pointer;font-weight:600;font-size:.8rem;font-family:'Outfit',sans-serif;transition:.15s;}
        .cancel-wrap button:hover{color:#52525b;}

        .auth-footer{text-align:center;margin-top:20px;font-size:.7rem;color:#94a3b8;font-weight:500;}
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-brand-icon">
                <svg width="36" height="36" fill="none" stroke="#18181b" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 21a9 9 0 110-18 9 9 0 010 18z"/><path d="M12 8v4l3 3"/></svg>
            </div>
            <div class="auth-brand-name">The Crimpers</div>
            <div class="auth-brand-sub">Two-factor authentication keeps your account secure. Scan the QR code with your authenticator app.</div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-right-inner">
        <div class="form-header">
            <div class="form-header-icon">
                <svg width="28" height="28" fill="none" stroke="#18181b" stroke-width="2.5" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            </div>
            <h2>Verify Your Identity</h2>
            <p>Scan the QR code with <strong>Google Authenticator</strong> or enter the secret key manually, then enter the 6-digit code.</p>
        </div>

        @if($errors->any())
        <div class="error-box">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
        @endif

        <div class="qr-card">
            {!! $qrCodeImage !!}
            <div class="qr-label">Manual Entry Key</div>
            <div class="qr-secret">{{ $secret }}</div>
        </div>

        <form action="{{ route('verify.store') }}" method="POST" style="width:100%;">
            @csrf
            <div class="code-group">
                <label class="code-label">Enter 6-Digit Code</label>
                <input type="text" name="one_time_password" class="code-input"
                       maxlength="6" pattern="\d{6}" placeholder="000000"
                       autofocus required autocomplete="off" inputmode="numeric">
            </div>
            <button type="submit" class="btn-verify">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:5px;"><polyline points="20 6 9 17 4 12"/></svg>
                Verify &amp; Enter Dashboard
            </button>
        </form>

        <div class="cancel-wrap">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Cancel &amp; Return to Login</button>
            </form>
        </div>

        <div class="auth-footer">Powered by The Crimpers</div>
        </div>{{-- end auth-right-inner --}}
    </div>
</body>
</html>
