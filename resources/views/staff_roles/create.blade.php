@extends('layouts.app')
@section('title', 'Create Role')

@section('content')
    <style>
        :root {
            --y1: #F7DF79;
            --y2: #FBEFBC;
            --yd: #c9a800;
            --yk: #a07800;
            --ybg: #fffdf0;
        }

        .page-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .back-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #f4f4f5;
            border: 1.5px solid #e4e4e7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #52525b;
            text-decoration: none;
            transition: .2s;
            flex-shrink: 0;
        }

        .back-btn:hover {
            background: #e4e4e7;
            color: #18181b;
        }

        .page-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 3px;
        }

        .page-sub {
            font-size: .85rem;
            color: #64748b;
            margin: 0;
        }

        .form-wrap {
            max-width: 560px;
        }

        .form-card {
            background: #fff;
            border: 1.5px solid #e9e0c0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(199, 168, 0, .08);
            margin-bottom: 16px;
        }

        .form-card-head {
            padding: 16px 22px;
            background: var(--ybg);
            border-bottom: 1.5px solid #f0e8b0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-card-head-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--y1), var(--yd));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #18181b;
            flex-shrink: 0;
        }

        .form-card-head-title {
            font-size: .9rem;
            font-weight: 700;
            color: #18181b;
        }

        .form-card-body {
            padding: 22px;
        }

        .f-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .f-group:last-child {
            margin-bottom: 0;
        }

        .f-label {
            font-size: .85rem;
            font-weight: 600;
            color: #334155;
        }

        .f-label span {
            font-weight: 400;
            color: #94a3b8;
        }

        .f-input,
        .f-textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            color: #18181b;
            background: #fff;
            outline: none;
            transition: .2s;
            box-sizing: border-box;
        }

        .f-input:focus,
        .f-textarea:focus {
            border-color: var(--yd);
            box-shadow: 0 0 0 3px rgba(199, 168, 0, .12);
        }

        .f-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .f-error {
            color: #ef4444;
            font-size: .75rem;
            margin-top: 2px;
        }

        .login-card {
            background: var(--ybg);
            border: 1.5px solid #f0e8b0;
            border-radius: 14px;
            padding: 18px;
        }

        .login-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .78rem;
            font-weight: 700;
            color: var(--yk);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 14px;
        }

        .login-card .f-input {
            border-color: #e9e0c0;
            background: #fff;
        }

        .login-card .f-input:focus {
            border-color: var(--yd);
            box-shadow: 0 0 0 3px rgba(199, 168, 0, .12);
        }

        .login-note {
            font-size: .75rem;
            color: #a07800;
            margin-top: 10px;
            line-height: 1.5;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            padding-top: 4px;
        }

        .btn-cancel {
            flex: 1;
            padding: 11px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            text-align: center;
            color: #64748b;
            font-weight: 700;
            text-decoration: none;
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            transition: .2s;
            background: #fff;
        }

        .btn-cancel:hover {
            background: #f4f4f5;
            border-color: #d4d4d8;
            color: #18181b;
        }

        .btn-save {
            flex: 1;
            padding: 11px;
            background: linear-gradient(135deg, var(--y1), var(--yd));
            border: none;
            border-radius: 10px;
            color: #18181b;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            font-size: .9rem;
            box-shadow: 0 3px 12px rgba(199, 168, 0, .25);
            transition: .2s;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 18px rgba(199, 168, 0, .35);
        }
    </style>

    <div class="form-wrap">
        <div class="page-header">
            <a href="{{ route('staff-roles.index') }}" class="back-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </a>
            <div>
                <div class="page-title">Create New Role</div>
                <div class="page-sub">Add a new employee category for your salon</div>
            </div>
        </div>

        <form action="{{ route('staff-roles.store') }}" method="POST">
            @csrf

            {{-- Role Info --}}
            <div class="form-card">
                <div class="form-card-head">
                    <div class="form-card-head-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                    </div>
                    <span class="form-card-head-title">Role Information</span>
                </div>
                <div class="form-card-body">
                    <div class="f-group">
                        <label class="f-label">Role Name <span>*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="f-input"
                            placeholder="e.g. Master Stylist, Senior Cashier...">
                        @error('name')<span class="f-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="f-group">
                        <label class="f-label">Description <span>(optional)</span></label>
                        <textarea name="description" class="f-textarea"
                            placeholder="Briefly describe the responsibilities...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Shared Login --}}
            <div class="form-card">
                <div class="form-card-head">
                    <div class="form-card-head-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                    </div>
                    <span class="form-card-head-title">Shared Login <span
                            style="font-weight:400;color:#94a3b8;">(optional)</span></span>
                </div>
                <div class="form-card-body">
                    <div class="login-card">
                        <div class="login-card-title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                            </svg>
                            Generic Role Login
                        </div>
                        <div class="f-group">
                            <label class="f-label">Login Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="f-input login-card"
                                placeholder="e.g. cashier@salon.com">
                            @error('email')<span class="f-error">{{ $message }}</span>@enderror
                        </div>
                        <div class="f-group" style="margin-bottom:0;">
                            <label class="f-label">Login Password</label>
                            <input type="password" name="password" class="f-input login-card"
                                placeholder="Set a default password">
                            @error('password')<span class="f-error">{{ $message }}</span>@enderror
                        </div>
                        <p class="login-note">If set, anyone can use these shared credentials to log in as this role.</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('staff-roles.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                        style="display:inline;vertical-align:middle;margin-right:5px;">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Create Role
                </button>
            </div>
        </form>
    </div>
@endsection