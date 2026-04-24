@extends('layouts.app')
@section('title', 'Employee Roles')

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
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.02em;
            margin: 0 0 4px;
        }

        .page-sub {
            font-size: .85rem;
            color: #64748b;
            margin: 0;
        }

        .btn-primary {
            padding: 9px 18px;
            border: none;
            background: linear-gradient(135deg, var(--y1), var(--yd));
            border-radius: 10px;
            color: #18181b;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: .2s;
            box-shadow: 0 3px 10px rgba(199, 168, 0, .2);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(199, 168, 0, .3);
            color: #18181b;
        }

        /* Role Cards Grid */
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 16px;
        }

        .role-card {
            background: #fff;
            border: 1.5px solid #e9e0c0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(199, 168, 0, .08);
            transition: .2s;
        }

        .role-card:hover {
            box-shadow: 0 6px 20px rgba(199, 168, 0, .15);
            transform: translateY(-2px);
        }

        .role-card-head {
            padding: 18px 20px;
            background: var(--ybg);
            border-bottom: 1.5px solid #f0e8b0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .role-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--y1), var(--yd));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #18181b;
            flex-shrink: 0;
        }

        .role-name {
            font-size: 1rem;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .role-desc {
            font-size: .78rem;
            color: #94a3b8;
            margin: 3px 0 0;
            line-height: 1.4;
        }

        .role-card-body {
            padding: 14px 20px;
        }

        .role-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .82rem;
            padding: 7px 0;
            border-bottom: 1px solid #faf6e8;
        }

        .role-stat:last-child {
            border-bottom: none;
        }

        .role-stat-label {
            color: #64748b;
        }

        .role-stat-value {
            font-weight: 700;
            color: #1e293b;
        }

        .count-badge {
            background: var(--y2);
            color: var(--yk);
            padding: 3px 10px;
            border-radius: 99px;
            font-size: .72rem;
            font-weight: 700;
        }

        .role-card-foot {
            padding: 12px 20px;
            border-top: 1.5px solid #f0e8b0;
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            flex: 1;
            padding: 7px 10px;
            border: 1px solid #e2e8f0;
            background: #f4f4f5;
            border-radius: 8px;
            color: #18181b;
            font-size: .75rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
            transition: .2s;
            font-family: 'Outfit', sans-serif;
        }

        .btn-sm:hover {
            background: #e4e4e7;
            border-color: #d4d4d8;
            color: #18181b;
        }

        .btn-sm-del {
            background: #fff;
            border-color: #fca5a5;
            color: #ef4444;
        }

        .btn-sm-del:hover {
            background: #fef2f2;
            border-color: #f87171;
            color: #dc2626;
        }

        .empty-state {
            background: #fff;
            border: 1.5px solid #e9e0c0;
            border-radius: 16px;
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: .9rem;
            margin: 8px 0 0;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(.97)
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }
    </style>

    <div class="page-header">
        <div>
            <div class="page-title">Employee Roles</div>
            <div class="page-sub">Define and manage worker categories like Cashier, Stylist, etc.</div>
        </div>
        <a href="{{ route('staff-roles.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Create Role
        </a>
    </div>



    @if($roles->count())
        <div class="roles-grid">
            @foreach($roles as $role)
                <div class="role-card">
                    <div class="role-card-head">
                        <div class="role-icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                            </svg>
                        </div>
                        <div>
                            <div class="role-name">{{ $role->name }}</div>
                            @if($role->description)
                                <div class="role-desc">{{ Str::limit($role->description, 60) }}</div>
                            @else
                                <div class="role-desc">No description provided</div>
                            @endif
                        </div>
                    </div>

                    <div class="role-card-body">
                        <div class="role-stat">
                            <span class="role-stat-label">Assigned Employees</span>
                            <span class="count-badge">{{ $role->staff_count }} assigned</span>
                        </div>
                        @if($role->email)
                            <div class="role-stat">
                                <span class="role-stat-label">Shared Login</span>
                                <span class="role-stat-value" style="font-size:.75rem;">{{ $role->email }}</span>
                            </div>
                        @else
                            <div class="role-stat">
                                <span class="role-stat-label">Shared Login</span>
                                <span style="font-size:.75rem;color:#94a3b8;">Not configured</span>
                            </div>
                        @endif
                    </div>

                    <div class="role-card-foot">
                        <a href="{{ route('staff-roles.edit', $role) }}" class="btn-sm">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                                style="display:inline;vertical-align:middle;margin-right:3px;">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </a>
                        <button type="button" class="btn-sm btn-sm-del"
                            onclick="openDeleteModal('{{ route('staff-roles.destroy', $role) }}', '{{ addslashes($role->name) }}')">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                                style="display:inline;vertical-align:middle;margin-right:3px;">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top:20px;">{{ $roles->links() }}</div>
    @else
        <div class="empty-state">
            <svg width="52" height="52" fill="none" stroke="#c9a800" stroke-width="1.5" viewBox="0 0 24 24"
                style="margin:0 auto;opacity:.5;">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
            </svg>
            <p>No roles yet — create your first employee role</p>
        </div>
    @endif

    <!-- Delete Form -->
    <form id="delete-form" method="POST" style="display:none;">@csrf @method('DELETE')</form>

    <!-- Delete Modal -->
    <div id="deleteModal"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
        <div
            style="background:#fff;padding:32px 28px;border-radius:20px;width:100%;max-width:400px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.15);animation:modalIn .2s ease-out;margin:16px;">
            <div
                style="width:56px;height:56px;border-radius:50%;background:#fee2e2;color:#ef4444;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                    <path d="M10 11v6M14 11v6" />
                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                </svg>
            </div>
            <h3 style="margin:0 0 8px;font-size:1.25rem;font-weight:800;color:#0f172a;">Delete Role?</h3>
            <p style="margin:0 0 24px;color:#64748b;font-size:.9rem;line-height:1.6;">You are about to delete <strong
                    id="delete-target-name" style="color:#0f172a;"></strong>.<br>This action <strong>cannot be
                    undone</strong>.</p>
            <div style="display:flex;gap:12px;">
                <button type="button" onclick="closeDeleteModal()"
                    style="flex:1;padding:11px;border:1.5px solid #e2e8f0;border-radius:10px;background:#fff;color:#64748b;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;font-size:.9rem;">Cancel</button>
                <button type="button" onclick="document.getElementById('delete-form').submit()"
                    style="flex:1;padding:11px;border:none;border-radius:10px;background:#ef4444;color:#fff;font-weight:700;cursor:pointer;font-family:'Outfit',sans-serif;font-size:.9rem;box-shadow:0 4px 14px rgba(239,68,68,.3);">Yes,
                    Delete</button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(url, name) {
            document.getElementById('delete-target-name').innerText = name;
            document.getElementById('delete-form').action = url;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
    </script>
@endsection