<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — The Royal Crest Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --gold:      #C9A84C;
            --gold-dark: #7A5E32;
            --sidebar-bg: #1A1A1A;
            --sidebar-w:  260px;
            --admin-bg:   #0f0f0f;
            --admin-surface: #1a1214;
            --admin-surface-2: #221820;
            --admin-border: rgba(201,168,76,.15);
            --admin-text: #E6E2DA;
            --admin-text-muted: rgba(192,192,192,.6);
        }
        body { font-family: 'Inter', sans-serif; background: var(--admin-bg); color: var(--admin-text); }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1030;
            transition: transform .3s;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
        }
        #sidebar .sidebar-brand {
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--gold);
            letter-spacing: 1px;
        }
        #sidebar .nav-section {
            padding: 10px 20px 4px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,.7);
            padding: 9px 20px;
            font-size: .875rem;
            border-radius: 0;
            transition: all .2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #sidebar .nav-link:hover { color: #fff; background: rgba(201,168,76,.12); }
        #sidebar .nav-link.active { color: var(--gold); background: rgba(201,168,76,.15); border-left: 3px solid var(--gold); }
        #sidebar .nav-link i { font-size: 1rem; width: 20px; flex-shrink: 0; }

        /* Main content */
        #mainContent {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
        }

        /* Top bar */
        #topBar {
            background: #fff;
            border-bottom: 1px solid #E9ECEF;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Cards */
        .stat-card { border: none; border-radius: 12px; overflow: hidden; transition: transform .2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card .stat-icon { width: 52px; height: 52px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        
        /* Fix bg-light cards to have dark background */
        .stat-card.bg-light { background: var(--admin-surface) !important; border: 1px solid var(--admin-border); }
        .stat-card.bg-light .card-body { color: #E6E2DA !important; }
        .stat-card.bg-light .text-muted { color: #B8AFA6 !important; }
        .stat-card.bg-light .fw-bold { color: #E6E2DA !important; }
        
        /* Stat card text colors */
        .stat-card .small { opacity: 0.85; }
        .stat-card.bg-primary .small, .stat-card.bg-success .small, 
        .stat-card.bg-danger .small { color: rgba(255,255,255,0.9) !important; }
        .stat-card.bg-warning .small { color: rgba(0,0,0,0.7) !important; }

        .admin-card { background: var(--admin-surface); border-radius: 12px; border: 1px solid var(--admin-border); box-shadow: 0 2px 12px rgba(0,0,0,.3); }

        /* Top bar */
        #topBar {
            background: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        #topBar .text-muted { color: var(--admin-text-muted) !important; }
        #topBar .fw-semibold { color: var(--admin-text) !important; }

        /* Table */
        .table * { color: #E6E2DA !important; }
        .table thead th { font-size: .78rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; color: #B8AFA6 !important; background: var(--admin-surface-2); border-bottom: 1px solid var(--admin-border); border-color: var(--admin-border); }
        .table td { vertical-align: middle; font-size: .88rem; border-color: var(--admin-border); color: #E6E2DA !important; }
        .table tbody tr { background: var(--admin-surface) !important; }
        .table tbody tr td { background: var(--admin-surface) !important; color: #E6E2DA !important; }
        .table-hover > tbody > tr:hover > td { background: rgba(201,168,76,.12) !important; }
        .table > :not(caption) > * > * { background-color: transparent !important; color: #E6E2DA !important; }
        .table a.text-gold { color: var(--gold) !important; text-decoration: none; }

        /* Form controls inside admin */
        .form-control, .form-select {
            background: var(--admin-surface-2);
            border: 1px solid var(--admin-border);
            color: var(--admin-text);
        }
        .form-control:focus, .form-select:focus {
            background: var(--admin-surface-2);
            border-color: var(--gold);
            color: var(--admin-text);
            box-shadow: 0 0 0 3px rgba(201,168,76,.15);
        }
        .form-control::placeholder { color: var(--admin-text-muted); }
        .form-select option { background: var(--admin-surface); color: var(--admin-text); }

        /* Breadcrumb */
        .breadcrumb-item a { color: var(--gold); text-decoration: none; }
        .breadcrumb-item.active { color: var(--admin-text-muted); }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--admin-text-muted); }

        /* Notification items */
        .notification-item { transition: background .2s; }
        .notification-item:hover { background: rgba(201,168,76,.18) !important; }
        .notification-item.unread { background: rgba(201,168,76,.12) !important; }
        .notification-item * { color: #E6E2DA; }
        .notification-item .text-muted { color: #B8AFA6 !important; }
        .notification-item .fw-semibold { color: #E6E2DA !important; }

        /* Text gold */
        .text-gold { color: var(--gold) !important; }
        .btn-gold { background: var(--gold); color: #101111; border: none; font-weight: 600; }
        .btn-gold:hover { background: var(--gold-dark); color: #fff; }
        .bg-gold { background: var(--gold) !important; }
        .border-gold { border-color: var(--gold) !important; }

        /* Button variants for dark theme */
        .btn-outline-secondary { color: var(--admin-text); border-color: var(--admin-border); }
        .btn-outline-secondary:hover { background: var(--admin-surface-2); border-color: var(--gold); color: var(--gold); }
        .btn-outline-primary { color: #6EA8FE; border-color: #6EA8FE; }
        .btn-outline-primary:hover { background: rgba(110,168,254,.15); border-color: #6EA8FE; color: #6EA8FE; }
        .btn-outline-danger { color: #ea868f; border-color: #ea868f; }
        .btn-outline-danger:hover { background: rgba(220,53,69,.15); border-color: #ea868f; color: #ea868f; }

        /* Badge */
        .badge { font-weight: 500; padding: 4px 10px; }

        /* Page headings */
        h4.fw-bold, h5.fw-bold { color: var(--admin-text); }

        /* Global text utilities */
        .text-muted { color: #B8AFA6 !important; }
        .small { color: #E6E2DA !important; }
        
        /* Ensure all text in admin cards is visible */
        .admin-card, .admin-card * { color: #E6E2DA; }
        .admin-card .fw-semibold { color: #E6E2DA !important; }
        .admin-card .text-muted { color: #B8AFA6 !important; }

        /* Fix all card text colors */
        .card { background: var(--admin-surface); border: 1px solid var(--admin-border); color: #E6E2DA; }
        .card-body, .card-body * { color: #E6E2DA; }
        .card-title, .card-text { color: #E6E2DA !important; }
        .card .text-muted { color: #B8AFA6 !important; }
        
        /* List group items */
        .list-group-item { background: var(--admin-surface); border-color: var(--admin-border); color: #E6E2DA; }
        .list-group-item:hover { background: rgba(201,168,76,.12); }
        
        /* Input group text */
        .input-group-text { background: var(--admin-surface-2); border-color: var(--admin-border); color: #E6E2DA; }
        
        /* All paragraph text */
        p, span, div, label, a { color: #E6E2DA; }
        h1, h2, h3, h4, h5, h6 { color: #E6E2DA !important; }
        
        /* Dropdown menus */
        .dropdown-menu { background: var(--admin-surface); border-color: var(--admin-border); }
        .dropdown-item { color: #E6E2DA; }
        .dropdown-item:hover { background: rgba(201,168,76,.15); color: var(--gold); }
        
        /* Nav tabs/pills */
        .nav-tabs .nav-link { color: #B8AFA6; border-color: var(--admin-border); }
        .nav-tabs .nav-link.active { background: var(--admin-surface); color: var(--gold); border-color: var(--admin-border) var(--admin-border) var(--admin-surface); }
        .nav-tabs .nav-link:hover { color: var(--gold); }
        
        /* Charts and canvas text */
        canvas { background: transparent !important; }
        
        /* Ensure stat card numbers are visible */
        .stat-card .display-4, .stat-card .fs-1, .stat-card .fs-2, .stat-card .fs-3 {
            color: #E6E2DA !important;
        }
        .stat-card .small, .stat-card .text-muted {
            color: #B8AFA6 !important;
        }

        /* Modals */
        .modal-content { background: var(--admin-surface); border: 1px solid var(--admin-border); color: var(--admin-text); }
        .modal-header, .modal-footer { border-color: var(--admin-border); }
        .modal-title { color: var(--admin-text); }
        .btn-close { filter: invert(1); }

        /* Alerts */
        .alert-success { background: rgba(25,135,84,.15); border-color: rgba(25,135,84,.3); color: #75b798; }
        .alert-danger  { background: rgba(220,53,69,.15);  border-color: rgba(220,53,69,.3);  color: #ea868f; }
        .alert-warning { background: rgba(255,193,7,.12);  border-color: rgba(255,193,7,.3);  color: #ffc107; }

        /* Pagination */
        .pagination .page-link { background: var(--admin-surface-2); border-color: var(--admin-border); color: var(--admin-text); }
        .pagination .page-link:hover { background: rgba(201,168,76,.15); color: var(--gold); border-color: var(--gold); }
        .pagination .page-item.active .page-link { background: var(--gold); border-color: var(--gold); color: #101111; }
        .pagination .page-item.disabled .page-link { background: var(--admin-surface); color: var(--admin-text-muted); }

        /* Sidebar toggle (mobile) */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #mainContent { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-building me-2"></i>The Royal Crest
            <div style="font-size:.6rem;color:rgba(255,255,255,.4);letter-spacing:3px;font-family:'Inter',sans-serif;">ADMIN PANEL</div>
        </div>

        <ul class="nav flex-column mt-2 pb-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <div class="nav-section mt-2">Reservations</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.bookings.index') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}">
                    <i class="bi bi-calendar-check"></i> Bookings
                    @php $pending = \App\Models\Booking::where('status','pending')->count(); @endphp
                    @if($pending > 0)<span class="badge bg-warning text-dark ms-auto">{{ $pending }}</span>@endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.bookings.calendar') ? 'active' : '' }}" href="{{ route('admin.bookings.calendar') }}">
                    <i class="bi bi-calendar3"></i> Calendar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                    <i class="bi bi-credit-card"></i> Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.checkin*') ? 'active' : '' }}" href="{{ route('admin.checkin.scan') }}">
                    <i class="bi bi-qr-code-scan"></i> QR Check-in
                </a>
            </li>
            <div class="nav-section mt-2">Rooms</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.rooms*') ? 'active' : '' }}" href="{{ route('admin.rooms.index') }}">
                    <i class="bi bi-door-open"></i> Rooms
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.room-types*') ? 'active' : '' }}" href="{{ route('admin.room-types.index') }}">
                    <i class="bi bi-grid"></i> Room Types
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.amenities*') ? 'active' : '' }}" href="{{ route('admin.amenities.index') }}">
                    <i class="bi bi-stars"></i> Amenities
                </a>
            </li>

            <div class="nav-section mt-2">Content</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.facilities*') ? 'active' : '' }}" href="{{ route('admin.facilities.index') }}">
                    <i class="bi bi-building"></i> Facilities
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}">
                    <i class="bi bi-images"></i> Gallery
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.promotions*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">
                    <i class="bi bi-tag"></i> Promotions
                </a>
            </li>

            <div class="nav-section mt-2">Management</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Users / Guests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                    <i class="bi bi-envelope"></i> Messages
                    @php $unread = \App\Models\Contact::where('is_read', false)->count(); @endphp
                    @if($unread > 0)<span class="badge bg-danger ms-auto">{{ $unread }}</span>@endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="bi bi-bar-chart"></i> Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.email-blast*') ? 'active' : '' }}" href="{{ route('admin.email-blast.index') }}">
                    <i class="bi bi-envelope-paper"></i> Email Blast
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear"></i> Settings
                </a>
            </li>

            <div class="nav-section mt-2">Account</div>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-globe"></i> View Website
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="nav-link w-100 text-start btn btn-link" style="color:rgba(255,255,255,.5);">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div id="mainContent">
        <!-- Top Bar -->
        <div id="topBar" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm d-lg-none" id="sidebarToggle" style="background:rgba(201,168,76,.15);border:1px solid var(--admin-border);color:var(--gold);">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <nav aria-label="breadcrumb" class="d-none d-md-block">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="small text-muted d-none d-sm-inline">{{ now()->format('D, d M Y') }}</span>
                
                <!-- Notification Bell -->
                <div class="dropdown">
                    <button class="btn position-relative" type="button" id="adminNotificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background:rgba(201,168,76,.12);border:1px solid var(--admin-border);color:var(--gold);">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="adminNotificationBadge" style="display:none;font-size:.65rem;padding:3px 6px;">0</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="adminNotificationDropdown" style="width:340px;max-height:450px;overflow-y:auto;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.4);background:var(--admin-surface);border:1px solid var(--admin-border);">
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="border-color:var(--admin-border)!important;background:var(--admin-surface-2);">
                            <h6 class="mb-0" style="color:var(--admin-text);">Notifications</h6>
                            <button class="btn btn-sm btn-link p-0" id="adminMarkAllReadBtn" style="font-size:.75rem;color:var(--gold);text-decoration:none;">Mark all read</button>
                        </div>
                        <div id="adminNotificationList">
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
                                <small>No notifications</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle" width="36" height="36" style="object-fit:cover;border:2px solid var(--gold);">
                    <div class="d-none d-sm-block">
                        <div class="small fw-semibold lh-1" style="color:var(--admin-text);">{{ auth()->user()->name }}</div>
                        <div class="small" style="font-size:.72rem;color:var(--gold);">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-4">
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show small" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Admin Notification polling
        let adminNotificationInterval;
        
        function fetchAdminNotifications() {
            fetch('{{ route("notifications.index") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('adminNotificationBadge');
                const list = document.getElementById('adminNotificationList');
                
                // Update badge
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
                
                // Update list
                if (data.notifications.length === 0) {
                    list.innerHTML = '<div class="text-center py-4 text-muted"><i class="bi bi-bell-slash fs-3 d-block mb-2"></i><small>No notifications</small></div>';
                } else {
                    list.innerHTML = data.notifications.map(n => `
                        <div class="notification-wrapper position-relative" data-id="${n.id}">
                            <div class="notification-item p-3 border-bottom ${n.read ? '' : 'unread'}" style="background:${n.read ? 'var(--admin-surface)' : 'rgba(201,168,76,.12)'};cursor:pointer;position:relative;border-color:var(--admin-border)!important;">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi ${n.data.icon || 'bi-info-circle'} fs-5" style="color:var(--gold);"></i>
                                    <div class="flex-grow-1" style="font-size:.85rem;">
                                        <div class="fw-semibold" style="color:#E6E2DA;">${n.data.title}</div>
                                        <div class="text-muted small" style="color:#B8AFA6;">${n.data.message}</div>
                                        <div class="text-muted mt-1" style="font-size:.7rem;color:#B8AFA6;">${n.time}</div>
                                    </div>
                                    <button class="btn btn-sm notification-delete-btn" style="opacity:0;transition:opacity 0.2s;background:#dc3545;color:white;border:none;border-radius:6px;padding:4px 8px;font-size:.75rem;" onclick="event.stopPropagation();deleteAdminNotification('${n.id}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    ${n.read ? '' : '<span class="badge ms-2" style="background:var(--gold);color:#000;font-size:.65rem;padding:3px 6px;">NEW</span>'}
                                </div>
                            </div>
                        </div>
                    `).join('');
                    
                    // Show delete button on hover
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.addEventListener('mouseenter', function() {
                            const deleteBtn = this.querySelector('.notification-delete-btn');
                            if (deleteBtn) deleteBtn.style.opacity = '1';
                        });
                        item.addEventListener('mouseleave', function() {
                            const deleteBtn = this.querySelector('.notification-delete-btn');
                            if (deleteBtn) deleteBtn.style.opacity = '0';
                        });
                    });
                    
                    // Add click handlers to view and mark as read
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.addEventListener('click', function(e) {
                            const wrapper = this.closest('.notification-wrapper');
                            const id = wrapper.dataset.id;
                            const notification = data.notifications.find(n => n.id === id);
                            
                            // Mark as read first
                            if (!this.classList.contains('read')) {
                                fetch(`{{ route("notifications.markRead", ":id") }}`.replace(':id', id), {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                });
                            }
                            
                            // Navigate to URL if exists
                            if (notification && notification.data.url) {
                                window.location.href = notification.data.url;
                            }
                        });
                    });
                }
            })
            .catch(err => console.error('Notification fetch error:', err));
        }
        
        // Delete notification function
        function deleteAdminNotification(id) {
            const wrapper = document.querySelector(`.notification-wrapper[data-id="${id}"]`);
            fetch(`{{ route("notifications.destroy", ":id") }}`.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                if (wrapper) {
                    wrapper.remove(); // Instant removal
                } else {
                    fetchAdminNotifications();
                }
            });
        }
        
        // Mark all as read
        document.getElementById('adminMarkAllReadBtn')?.addEventListener('click', function() {
            fetch('{{ route("notifications.markAllRead") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => fetchAdminNotifications());
        });
        
        // Initial fetch
        fetchAdminNotifications();
        
        // Poll every 30 seconds
        adminNotificationInterval = setInterval(fetchAdminNotifications, 30000);

        // Auto-dismiss flash alerts after 800ms
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.alert-dismissible').forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }, 800);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
