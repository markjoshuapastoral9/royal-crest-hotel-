<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Royal Crest') - Where Luxury Meets Comfort</title>
    <meta name="description" content="@yield('meta_description', 'The Royal Crest Calasiao, Pangasinan - Luxury accommodations, world-class dining, and exceptional service.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --gold:       #A6824A;
            --gold-light: #C9A87C;
            --gold-dark:  #7A5E32;
            --bg-dark:    #101111;
            --surface:    #1a1214;
            --surface-2:  #150e10;
            --text-pri:   #E6E2DA;
            --text-sec:   #B8AFA6;
            --border:     rgba(230,226,218,0.10);
            --emerald:    #154230;
            --burgundy:   #5D1E21;
            /* legacy aliases for inner pages */
            --dark:       #101111;
            --dark-2:     #1a1214;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-pri);
            background: var(--bg-dark);
            overflow-x: hidden;
        }

        h1,h2,h3,h4,h5 { font-family: 'Playfair Display', serif; }

        /* Gold utilities */
        .text-gold        { color: var(--gold) !important; }
        .bg-gold          { background-color: var(--gold) !important; }
        .border-gold      { border-color: var(--gold) !important; }
        .btn-gold         { background: var(--gold); color: #101111 !important; border: 2px solid var(--gold); font-weight: 700; letter-spacing: .5px; transition: all .3s; }
        .btn-gold:hover   { background: var(--gold-light); border-color: var(--gold-light); color: #101111 !important; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(166,130,74,.4); }
        .btn-outline-gold { background: transparent; color: var(--gold) !important; border: 2px solid var(--gold); font-weight: 600; transition: all .3s; }
        .btn-outline-gold:hover { background: var(--gold); color: #101111 !important; transform: translateY(-2px); }

        /* Navbar */
        #mainNav {
            background: transparent;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border-bottom: none;
            transition: all .4s;
            padding: 20px 0;
        }
        #mainNav.scrolled {
            padding: 10px 0;
            box-shadow: 0 4px 30px rgba(0,0,0,.5);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        #mainNav .navbar-brand { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.65rem; 
            color: var(--gold) !important; 
            letter-spacing: 1px;
            padding: 0;
            margin: 0;
        }
        #mainNav .nav-link { color: rgba(255,255,255,.75) !important; font-size: .82rem; font-weight: 500; letter-spacing: .8px; text-transform: uppercase; padding: 6px 14px !important; transition: color .3s, transform .2s; position: relative; }
        #mainNav .nav-link:hover, #mainNav .nav-link.active { color: var(--gold) !important; }

        /* Gold underline slide-in on hover */
        #mainNav .nav-item:not(.dropdown) .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 14px; right: 14px;
            height: 2px;
            background: var(--gold);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .25s ease;
        }
        #mainNav .nav-item:not(.dropdown) .nav-link:hover::after,
        #mainNav .nav-item:not(.dropdown) .nav-link.active::after {
            transform: scaleX(1);
        }

        /* Nav link subtle lift on hover */
        #mainNav .nav-link:hover { transform: translateY(-1px); }

        #mainNav .btn-book { background: var(--gold); color: #101111 !important; border-radius: 8px; padding: 8px 22px !important; font-weight: 700; font-size: .82rem; letter-spacing: .5px; transition: all .3s; }
        #mainNav .btn-book:hover { background: var(--gold-light); box-shadow: 0 4px 18px rgba(166,130,74,.4); transform: translateY(-2px); }

        /* Override Bootstrap nav-pills blue with gold */
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link {
            background-color: var(--gold) !important;
            color: #101111 !important;
        }
        .nav-pills .nav-link {
            color: var(--text-sec);
        }
        .nav-pills .nav-link:hover {
            color: var(--gold);
        }

        /* Section titles (legacy inner pages) */
        .section-tag   { font-size: .7rem; font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold); margin-bottom: 10px; display: block; font-family: 'Inter', sans-serif; }
        .section-title { font-size: 2.4rem; font-weight: 700; line-height: 1.2; margin-bottom: 1rem; color: #fff; }
        .section-divider { width: 50px; height: 3px; background: linear-gradient(to right, var(--gold), var(--gold-light)); border-radius: 2px; margin: 0 auto 1.5rem; }
        .section-divider.left { margin: 0 0 1.5rem; }

        /* Cards (legacy inner pages) */
        .room-card { background: var(--surface); border: 1px solid var(--border); border-radius: 18px; overflow: hidden; transition: transform .3s, box-shadow .3s, border-color .3s; }
        .room-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,.4); border-color: rgba(166,130,74,.3); }
        .room-card .card-img-top { height: 220px; object-fit: cover; }
        .room-card .badge-type { background: var(--gold); color: #101111; font-size: .68rem; font-weight: 800; letter-spacing: .5px; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; }
        .room-card .price { font-family: 'Playfair Display', serif; color: var(--gold); font-size: 1.3rem; font-weight: 700; }
        .room-card .card-body { background: var(--surface); }
        .room-card .card-title { color: #fff !important; }
        .room-card .text-muted { color: var(--text-sec) !important; }
        .room-card .badge.bg-light { background: rgba(255,255,255,.07) !important; color: var(--text-sec) !important; border-color: var(--border) !important; }

        /* Facility card */
        .facility-card { background: var(--surface); border-radius: 18px; padding: 2rem 1.5rem; text-align: center; border: 1px solid var(--border); transition: all .3s; }
        .facility-card:hover { border-color: rgba(166,130,74,.35); transform: translateY(-4px); box-shadow: 0 12px 35px rgba(0,0,0,.4); }
        .facility-card h5 { color: #fff; }
        .facility-card p { color: var(--text-sec); }
        .facility-icon { width: 64px; height: 64px; background: rgba(166,130,74,.12); border: 1px solid rgba(166,130,74,.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--gold); font-size: 1.6rem; transition: all .3s; }
        .facility-card:hover .facility-icon { background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: #101111; }

        /* Language switcher dropdown */
        #langDropdown { border-radius: 8px; transition: color .3s; }
        .dropdown-menu .dropdown-item:hover { background: rgba(166,130,74,.12) !important; color: var(--gold) !important; }
        .dropdown-menu .dropdown-item.active { background: rgba(166,130,74,.18) !important; }

        /* Mega Menu Styles */
        .mega-menu {
            background: var(--surface, #1a1214);
            border: 1px solid var(--border, rgba(255,255,255,0.1));
            border-radius: 12px;
            min-width: 320px;
            margin-top: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            animation: megaFadeIn .22s cubic-bezier(.16,1,.3,1);
            transform-origin: top center;
        }

        @keyframes megaFadeIn {
            from {
                opacity: 0;
                transform: translateY(-8px) scaleY(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scaleY(1);
            }
        }

        /* Stagger each menu item */
        .mega-menu-content .mega-menu-item:nth-child(1) { animation: itemSlideIn .2s ease both .04s; }
        .mega-menu-content .mega-menu-item:nth-child(2) { animation: itemSlideIn .2s ease both .09s; }
        .mega-menu-content .mega-menu-item:nth-child(3) { animation: itemSlideIn .2s ease both .14s; }
        .mega-menu-content .mega-menu-item:nth-child(4) { animation: itemSlideIn .2s ease both .19s; }
        .mega-menu-content .mega-menu-item:nth-child(5) { animation: itemSlideIn .2s ease both .24s; }

        @keyframes itemSlideIn {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .mega-menu-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .mega-menu-item {
            text-decoration: none;
            color: var(--text-pri, #E6E2DA);
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .mega-menu-item:hover {
            background: rgba(166,130,74,0.08);
            border-color: rgba(166,130,74,0.2);
            color: var(--gold);
            transform: translateX(3px);
        }

        .mega-icon {
            width: 40px;
            height: 40px;
            background: rgba(166,130,74,0.12);
            border: 1px solid rgba(166,130,74,0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.2rem;
            flex-shrink: 0;
            transition: all 0.25s cubic-bezier(.34,1.56,.64,1);
        }

        .mega-menu-item:hover .mega-icon {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: #101111;
            transform: scale(1.12) rotate(-4deg);
        }

        .mega-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: #fff;
            margin-bottom: 0.15rem;
            letter-spacing: 0.3px;
            transition: color .2s;
        }

        .mega-desc {
            font-size: 0.75rem;
            color: var(--text-sec, #B8AFA6);
            line-height: 1.3;
        }

        .mega-menu-item:hover .mega-title {
            color: var(--gold);
        }

        /* Dropdown arrow animation */
        .dropdown-toggle::after {
            transition: transform 0.25s cubic-bezier(.34,1.56,.64,1);
        }

        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        /* Gold glow pulse on active dropdown toggle */
        .dropdown-toggle[aria-expanded="true"] {
            color: var(--gold) !important;
        }

        /* Language dropdown animation */
        .dropdown-menu {
            animation: megaFadeIn .2s cubic-bezier(.16,1,.3,1);
        }

        /* Notification bell wiggle on new notification */
        @keyframes bellWiggle {
            0%,100% { transform: rotate(0); }
            20%      { transform: rotate(15deg); }
            40%      { transform: rotate(-12deg); }
            60%      { transform: rotate(8deg); }
            80%      { transform: rotate(-5deg); }
        }
        .bell-notify { animation: bellWiggle .6s ease; }

        /* Toast */
        .toast-container { z-index: 9999; }

        /* Notification items */
        .notification-item { transition: background .2s; }
        .notification-item:hover { background: rgba(166,130,74,.15) !important; }
        .notification-item.unread { background: rgba(166,130,74,.08) !important; }

        /* Breadcrumb / page hero (inner pages) */
        .page-hero { background: linear-gradient(135deg, var(--bg-dark) 0%, var(--surface) 100%); padding: 80px 0 50px; border-bottom: 1px solid var(--border); }
        .page-hero h1 { color: #fff; }
        .text-muted { color: var(--text-sec) !important; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--surface); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 3px; }

        /* Badge overrides */
        .badge-gold { background: var(--gold) !important; color: #101111 !important; }

        /* Forms (inner pages) */
        .form-control, .form-select {
            background: rgba(255,255,255,.05) !important;
            border: 1px solid rgba(255,255,255,.1) !important;
            color: #fff !important;
            border-radius: 10px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 3px rgba(166,130,74,.15) !important;
            background: rgba(255,255,255,.08) !important;
        }
        .form-control::placeholder { color: rgba(255,255,255,.3) !important; }
        .form-select option { background: var(--surface); color: #fff; }
        label { color: var(--text-sec); }

        /* Cards bg for inner pages */
        .card { background: var(--surface) !important; border: 1px solid var(--border) !important; color: #fff !important; }
        .bg-white, .bg-light { background: var(--surface) !important; }

        /* Loading overlay */
        #pageLoader { position: fixed; inset: 0; background: var(--bg-dark); display: flex; align-items: center; justify-content: center; z-index: 99999; transition: opacity .3s; }
        #pageLoader.hidden { opacity: 0; pointer-events: none; }
        .loader-brand { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--gold); animation: loaderPulse 1.5s ease-in-out infinite; }
        @keyframes loaderPulse { 0%,100%{opacity:1} 50%{opacity:.35} }

        /* Fade-up */
        .fade-up { opacity: 0; transform: translateY(28px); transition: opacity .65s ease, transform .65s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* Footer */
        footer { background: var(--surface-2, #141414); color: rgba(255,255,255,.65); border-top: 1px solid var(--border); }
        footer h6 { color: var(--gold); font-family: 'Inter', sans-serif; font-size: .72rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.2rem; }
        footer a { color: rgba(255,255,255,.55); text-decoration: none; transition: color .3s; }
        footer a:hover { color: var(--gold); }
        footer .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: var(--gold); }

        @media (max-width: 768px) {
            .section-title { font-size: 1.8rem; }

            /* Page hero */
            .page-hero { padding: 70px 0 30px; }
            .page-hero h1 { font-size: 1.6rem; }

            /* Navbar - fix alignment */
            #mainNav { padding: 12px 0 !important; }
            #mainNav .container { padding: 0 15px; }
            #mainNav .navbar-brand { font-size: 1.3rem; padding: 8px 0; }
            #mainNav .navbar-toggler { padding: 6px 10px; border: none; }
            #mainNav .navbar-collapse { background: rgba(10,10,11,.97); border-radius: 12px; padding: 1rem; margin-top: .5rem; border: 1px solid rgba(255,255,255,.08); }

            /* Mega menu mobile */
            .mega-menu {
                position: static !important;
                width: 100% !important;
                margin-top: 0.5rem;
                border-radius: 8px;
            }

            .mega-menu-content {
                max-height: 400px;
                overflow-y: auto;
            }

            .mega-menu-item {
                padding: 0.75rem !important;
            }

            .mega-icon {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .mega-title {
                font-size: 0.85rem;
            }

            .mega-desc {
                font-size: 0.7rem;
            }

            /* Footer columns */
            footer .col-lg-4, footer .col-lg-2, footer .col-lg-3 { margin-bottom: 1.5rem; }

            /* Room cards */
            .room-card .card-img-top { height: 180px; }
        }

        @media (max-width: 576px) {
            .section-title { font-size: 1.5rem; }
            .page-hero h1 { font-size: 1.35rem; }
            .btn-gold, .btn-outline-gold { font-size: .85rem; padding: .5rem 1rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Page Loader -->
    <div id="pageLoader">
        <div class="text-center">
            <div class="loader-brand">The Royal Crest</div>
            <div style="color:rgba(255,255,255,.35);margin-top:.5rem;letter-spacing:4px;font-size:.7rem;font-family:'Inter',sans-serif;">HOTEL</div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="The Royal Crest" style="height: 70px; width: auto; object-fit: contain;">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('rooms*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">{{ __('site.nav_rooms') }}</a></li>
                    
                    <!-- Packages Mega Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('packages*') ? 'active' : '' }}" 
                           href="#" 
                           id="packagesDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown" 
                           aria-expanded="false">
                            Packages
                        </a>
                        <div class="dropdown-menu mega-menu p-0" aria-labelledby="packagesDropdown">
                            <div class="mega-menu-content p-3">
                                <a href="{{ route('packages.index') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-gift"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">All Packages</div>
                                        <div class="mega-desc">Browse our exclusive deals</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                                
                                <a href="{{ route('facilities') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">Facilities</div>
                                        <div class="mega-desc">Explore our hotel amenities</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                                
                                <a href="{{ route('gallery') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-images"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">Gallery</div>
                                        <div class="mega-desc">Browse a land of packages</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Dining Mega Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('dining*') ? 'active' : '' }}" 
                           href="#" 
                           id="diningDropdown" 
                           role="button" 
                           data-bs-toggle="dropdown" 
                           aria-expanded="false">
                            Dining
                        </a>
                        <div class="dropdown-menu mega-menu p-0" aria-labelledby="diningDropdown">
                            <div class="mega-menu-content p-3">
                                <a href="{{ route('dining.restaurant') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-shop"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">Our Restaurant</div>
                                        <div class="mega-desc">Experience fine dining excellence</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                                
                                <a href="{{ route('dining.menu') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">Menu</div>
                                        <div class="mega-desc">View our culinary offerings</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                                
                                <a href="{{ route('dining.private') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-door-closed"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">Private Dining</div>
                                        <div class="mega-desc">Exclusive dining experiences</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                                
                                <a href="{{ route('dining.room-service') }}" class="mega-menu-item d-flex align-items-start gap-3 p-3 rounded-3">
                                    <div class="mega-icon">
                                        <i class="bi bi-bell"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="mega-title">Room Service</div>
                                        <div class="mega-desc">Dining in the comfort of your room</div>
                                    </div>
                                    <i class="bi bi-chevron-right ms-auto" style="color:rgba(255,255,255,0.3);"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('site.nav_about') }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('site.nav_contact') }}</a></li>
                </ul>
                <ul class="navbar-nav align-items-center gap-2">

                    <!-- Language Switcher -->
                    @php
                        $langs = [
                            'en'  => ['label' => 'EN', 'name' => 'English',  'flag' => '🇺🇸'],
                            'fil' => ['label' => 'FIL','name' => 'Filipino', 'flag' => '🇵🇭'],
                            'ja'  => ['label' => 'JA', 'name' => '日本語',   'flag' => '🇯🇵'],
                            'ko'  => ['label' => 'KO', 'name' => '한국어',    'flag' => '🇰🇷'],
                            'zh'  => ['label' => 'ZH', 'name' => '中文',     'flag' => '🇨🇳'],
                            'es'  => ['label' => 'ES', 'name' => 'Español',  'flag' => '🇪🇸'],
                        ];
                        $currentLocale = app()->getLocale();
                        $current = $langs[$currentLocale] ?? $langs['en'];
                    @endphp
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center gap-1 px-2" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:rgba(255,255,255,.75)!important;font-size:.82rem;font-weight:600;letter-spacing:.5px;">
                            <span>{{ $current['flag'] }}</span>
                            <span>{{ $current['label'] }}</span>
                            <i class="bi bi-chevron-down" style="font-size:.6rem;"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end py-1" aria-labelledby="langDropdown" style="background:var(--surface);border:1px solid var(--border);border-radius:10px;min-width:160px;margin-top:6px;">
                            @foreach($langs as $code => $info)
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-3 {{ $currentLocale === $code ? 'active' : '' }}"
                                   href="{{ route('lang.switch', $code) }}"
                                   style="color:{{ $currentLocale === $code ? 'var(--gold)' : 'var(--text-sec)' }};font-size:.84rem;background:transparent;">
                                    <span style="font-size:1rem;">{{ $info['flag'] }}</span>
                                    <span>{{ $info['name'] }}</span>
                                    @if($currentLocale === $code)
                                    <i class="bi bi-check2 ms-auto text-gold"></i>
                                    @endif
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    @auth
                        <!-- Notification Bell -->
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationBadge" style="display:none;font-size:.65rem;padding:3px 6px;">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notificationDropdown" style="width:320px;max-height:400px;overflow-y:auto;background:var(--surface);border:1px solid var(--border);border-radius:12px;margin-top:8px;">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="border-color:var(--border)!important;">
                                    <h6 class="mb-0 text-white">{{ __('site.nav_notifications') }}</h6>
                                    <button class="btn btn-sm btn-link text-gold p-0" id="markAllReadBtn" style="font-size:.75rem;text-decoration:none;">{{ __('site.nav_mark_all_read') }}</button>
                                </div>
                                <div id="notificationList" style="color:var(--text-pri);">
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-bell-slash fs-3 d-block mb-2"></i>
                                        <small>{{ __('site.nav_no_notifs') }}</small>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Dashboard Link -->
                        @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>{{ __('site.nav_dashboard') }}</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}"><i class="bi bi-person-circle me-1"></i>{{ __('site.nav_dashboard') }}</a></li>
                        @endif
                        
                        <!-- Book Now Button (for customers only) -->
                        @unless(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <li class="nav-item">
                            <a href="{{ route('rooms.index') }}" class="nav-link btn-book ms-2">
                                <i class="bi bi-calendar-check me-1"></i>{{ __('site.nav_book_now') }}
                            </a>
                        </li>
                        @endunless
                        
                        <!-- Logout Button -->
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
                                <button type="submit" class="nav-link btn btn-link text-decoration-none" style="color:rgba(255,255,255,.75)!important;font-size:.82rem;font-weight:500;letter-spacing:.8px;text-transform:uppercase;padding:6px 14px!important;transition:color .3s;">
                                    <i class="bi bi-box-arrow-right me-1"></i>{{ __('site.nav_logout') }}
                                </button>
                            </form>
                        </li>
                    @else
                        <!-- Guest: Login + Book Now -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}" style="color:rgba(255,255,255,.75)!important;">{{ __('site.nav_login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-book ms-2" href="{{ route('rooms.index') }}">
                                <i class="bi bi-calendar-check me-1"></i>{{ __('site.nav_book_now') }}
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error') || session('warning'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="margin-top:80px;">
        @if(session('success'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        @endif
        @if(session('error'))
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex"><div class="toast-body"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        @endif
        @if(session('warning'))
        <div class="toast align-items-center text-bg-warning border-0 show" role="alert">
            <div class="d-flex"><div class="toast-body"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>
        @endif
    </div>
    @endif

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-3">The Royal Crest</div>
                    <p class="small" style="line-height:1.8;">{{ __('site.footer_tagline') }}</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="social-icon"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6>{{ __('site.footer_navigation') }}</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>
                        <li class="mb-2"><a href="{{ route('rooms.index') }}">{{ __('site.nav_rooms') }}</a></li>
                        <li class="mb-2"><a href="{{ route('facilities') }}">{{ __('site.nav_facilities') }}</a></li>
                        <li class="mb-2"><a href="{{ route('gallery') }}">{{ __('site.nav_gallery') }}</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">{{ __('site.nav_about') }}</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">{{ __('site.nav_contact') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>{{ __('site.footer_room_types') }}</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('rooms.index', ['type' => 'deluxe-room']) }}">Deluxe Room</a></li>
                        <li class="mb-2"><a href="{{ route('rooms.index', ['type' => 'superior-room']) }}">Superior Room</a></li>
                        <li class="mb-2"><a href="{{ route('rooms.index', ['type' => 'premier-room']) }}">Premier Room</a></li>
                        <li class="mb-2"><a href="{{ route('rooms.index', ['type' => 'executive-suite']) }}">Executive Suite</a></li>
                        <li class="mb-2"><a href="{{ route('rooms.index', ['type' => 'family-suite']) }}">Family Suite</a></li>
                        <li class="mb-2"><a href="{{ route('rooms.index', ['type' => 'presidential-suite']) }}">Presidential Suite</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6>{{ __('site.footer_contact') }}</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2 text-gold"></i>Calasiao, Pangasinan 2418</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2 text-gold"></i>+63 75 123 4567</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2 text-gold"></i>info@royalcresthotel.com</li>
                        <li class="mb-2"><i class="bi bi-clock me-2 text-gold"></i>{{ __('site.footer_checkin') }}</li>
                        <li class="mb-2"><i class="bi bi-clock me-2 text-gold"></i>{{ __('site.footer_checkout') }}</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,.1); margin-top: 2rem;">
            <div class="row align-items-center">
                <div class="col-md-6 small text-center text-md-start" style="color:rgba(255,255,255,.4);">
                    &copy; {{ date('Y') }} The Royal Crest. {{ __('site.footer_copyright') }}
                </div>
                <div class="col-md-6 small text-center text-md-end" style="color:rgba(255,255,255,.4);">
                    Calasiao, Pangasinan, Philippines &mdash; {{ __('site.footer_luxury') }}
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Page loader
        window.addEventListener('load', function () {
            const loader = document.getElementById('pageLoader');
            setTimeout(() => loader.classList.add('hidden'), 300);
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('mainNav');
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Bell wiggle when unread notifications arrive
        function triggerBellWiggle() {
            const bell = document.querySelector('#notificationDropdown i.bi-bell');
            if (!bell) return;
            bell.classList.remove('bell-notify');
            void bell.offsetWidth; // reflow to restart animation
            bell.classList.add('bell-notify');
        }

        // Fade-up animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

        // Auto-dismiss toasts
        document.querySelectorAll('.toast').forEach(el => {
            const t = bootstrap.Toast.getOrCreateInstance(el, { autohide: true, delay: 3000 });
            t.show();
            setTimeout(() => t.hide(), 3000);
        });

        @auth
        // Notification polling
        let notificationInterval;
        
        function fetchNotifications() {
            fetch('{{ route("notifications.index") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                const list = document.getElementById('notificationList');
                
                // Update badge
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count;
                    badge.style.display = 'inline-block';
                    triggerBellWiggle();
                } else {
                    badge.style.display = 'none';
                }
                
                // Update list
                if (data.notifications.length === 0) {
                    list.innerHTML = '<div class="text-center py-4 text-muted"><i class="bi bi-bell-slash fs-3 d-block mb-2"></i><small>No notifications</small></div>';
                } else {
                    list.innerHTML = data.notifications.map(n => `
                        <div class="notification-wrapper position-relative" data-id="${n.id}">
                            <div class="notification-item p-3 border-bottom ${n.read ? '' : 'unread'}" style="border-color:var(--border)!important;background:${n.read ? 'transparent' : 'rgba(166,130,74,.08)'};cursor:pointer;position:relative;">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi ${n.data.icon || 'bi-info-circle'} text-gold fs-5"></i>
                                    <div class="flex-grow-1" style="font-size:.85rem;">
                                        <div class="fw-semibold text-white">${n.data.title}</div>
                                        <div class="text-muted small">${n.data.message}</div>
                                        <div class="text-muted mt-1" style="font-size:.7rem;">${n.time}</div>
                                    </div>
                                    <button class="btn btn-sm notification-delete-btn" style="opacity:0;transition:opacity 0.2s;background:#ef4444;color:white;border:none;border-radius:6px;padding:4px 8px;font-size:.75rem;" onclick="event.stopPropagation();deleteNotification('${n.id}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    ${n.read ? '' : '<span class="badge bg-gold ms-2" style="font-size:.65rem;padding:3px 6px;">NEW</span>'}
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
        function deleteNotification(id) {
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
                    fetchNotifications();
                }
            });
        }
        
        // Mark all as read
        document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
            fetch('{{ route("notifications.markAllRead") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => fetchNotifications());
        });
        
        // Initial fetch
        fetchNotifications();
        
        // Poll every 30 seconds
        notificationInterval = setInterval(fetchNotifications, 30000);
        @endauth
    </script>

    @stack('scripts')
</body>
</html>
