<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('site.auth_tab_register') }} — Royal Crest Hotel</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #A6824A;
            --gold-light: #C9A87C;
            --gold-dark: #7A5E32;
            --bg-dark: #101111;
            --surface: #1a1214
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html,
        body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            overflow-y: auto
        }

        body {
            display: flex;
            position: relative
        }

        .auth-bg {
            position: fixed;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=1920&q=90') center/cover no-repeat;
            z-index: 0
        }

        .auth-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(120deg, rgba(5, 5, 8, .85) 0%, rgba(10, 8, 5, .75) 50%, rgba(5, 5, 8, .88) 100%);
            z-index: 1
        }

        .auth-container {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex
        }

        .auth-left {
            flex: 1;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh
        }

        .auth-right {
            width: 520px;
            background: rgba(20, 20, 22, .92);
            backdrop-filter: blur(28px);
            border-left: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            padding: 50px;
            min-height: 100vh
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 60px
        }

        .brand-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 2rem
        }

        .brand-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            color: #fff;
            font-weight: 600;
            letter-spacing: 1px;
            line-height: 1
        }

        .brand-sub {
            font-size: .6rem;
            color: rgba(255, 255, 255, .4);
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 2px
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.2rem;
            color: #fff;
            line-height: 1.2;
            font-weight: 600;
            margin-bottom: 1rem
        }

        .hero-title .gold {
            color: var(--gold)
        }

        .hero-sub {
            color: rgba(192, 192, 192, .85);
            font-size: 1.05rem;
            line-height: 1.8;
            max-width: 480px;
            margin-bottom: 2.5rem
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 3rem
        }

        .feat-item {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .feat-icon {
            width: 42px;
            height: 42px;
            background: rgba(166, 130, 74, .12);
            border: 1px solid rgba(166, 130, 74, .25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 1.1rem;
            flex-shrink: 0
        }

        .feat-text {
            color: rgba(255, 255, 255, .8);
            font-size: .92rem
        }

        .widgets {
            display: flex;
            gap: 20px;
            flex-wrap: wrap
        }

        .widget {
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .widget-icon {
            color: var(--gold);
            font-size: 1.3rem
        }

        .widget-text {
            font-size: .8rem;
            color: rgba(255, 255, 255, .5);
            line-height: 1.3
        }

        .widget-value {
            font-size: 1rem;
            color: #fff;
            font-weight: 600
        }

        .form-card {
            width: 100%
        }

        .tabs {
            display: flex;
            margin-bottom: 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, .1)
        }

        .tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            font-size: .95rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .5);
            cursor: pointer;
            transition: all .3s;
            border-bottom: 2px solid transparent;
            font-family: 'Inter', sans-serif
        }

        .tab.active {
            color: #fff;
            border-bottom-color: var(--gold)
        }

        .f-group {
            margin-bottom: 1rem
        }

        .f-label {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(192, 192, 192, .7);
            margin-bottom: .45rem;
            font-family: 'Inter', sans-serif
        }

        .f-input-wrap {
            position: relative
        }

        .f-input {
            width: 100%;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 10px;
            color: #fff;
            padding: 11px 14px;
            font-size: .86rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all .25s
        }

        .f-input:focus {
            border-color: var(--gold);
            background: rgba(255, 255, 255, .09);
            box-shadow: 0 0 0 3px rgba(166, 130, 74, .12)
        }

        .f-input::placeholder {
            color: rgba(192, 192, 192, .35)
        }

        .f-input.is-invalid {
            border-color: rgba(239, 68, 68, .5)
        }

        .invalid-msg {
            font-size: .72rem;
            color: #fca5a5;
            margin-top: .3rem
        }

        .pwd-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gold);
            cursor: pointer;
            font-size: .9rem;
            padding: 4px;
            z-index: 1
        }

        .check-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: .6rem;
            margin-bottom: 1rem
        }

        .check-row input[type=checkbox] {
            accent-color: var(--gold);
            width: 16px;
            height: 16px;
            margin-top: 2px;
            flex-shrink: 0
        }

        .check-row label {
            font-size: .8rem;
            color: rgba(192, 192, 192, .7);
            line-height: 1.5
        }

        .check-row a {
            color: var(--gold);
            text-decoration: none
        }

        .btn-primary {
            width: 100%;
            background: var(--gold);
            color: #101111;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            transition: all .3s;
            font-family: 'Inter', sans-serif
        }

        .btn-primary:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(166, 130, 74, .35)
        }

        .alert-err {
            background: rgba(220, 38, 38, .12);
            border: 1px solid rgba(220, 38, 38, .3);
            border-radius: 10px;
            color: #fca5a5;
            padding: 10px 14px;
            font-size: .82rem;
            margin-bottom: 1.2rem
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .78rem;
            color: rgba(192, 192, 192, .5);
            text-decoration: none;
            margin-top: 1rem;
            transition: color .2s
        }

        .back-link:hover {
            color: var(--gold)
        }

        @media(max-width:1024px) {
            .auth-left {
                padding: 40px 50px
            }

            .auth-right {
                width: 460px;
                padding: 40px 35px
            }

            .hero-title {
                font-size: 2.6rem
            }
        }

        @media(max-width:768px) {
            .auth-left {
                display: none
            }

            .auth-right {
                width: 100%;
                border-left: none
            }
        }
    </style>
</head>

<body>
    <div class="auth-bg"></div>
    <div class="auth-overlay"></div>
    <div class="auth-container">
        <div class="auth-left">
            <div>
                <div class="brand">
                    <img src="{{ asset('images/logo.png') }}" alt="The Royal Crest"
                        style="width:80px;height:80px;border-radius:12px;object-fit:cover;">
                    <div>
                        <div class="brand-text">THE ROYAL CREST</div>
                        <div class="brand-sub">HOTEL</div>
                    </div>
                </div>
                <h1 class="hero-title">{{ __('site.auth_create_account') }}<br><span
                        class="gold">{{ __('site.auth_create_gold') }}</span></h1>
                <p class="hero-sub">{{ __('site.auth_register_sub') }}</p>
                <div class="features">
                    <div class="feat-item">
                        <div class="feat-icon"><i class="bi bi-calendar-check"></i></div>
                        <div class="feat-text">{{ __('site.auth_easy_booking') }}</div>
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon"><i class="bi bi-receipt"></i></div>
                        <div class="feat-text">{{ __('site.auth_booking_history') }}</div>
                    </div>
                    <div class="feat-item">
                        <div class="feat-icon"><i class="bi bi-tag"></i></div>
                        <div class="feat-text">{{ __('site.auth_member_disc') }}</div>
                    </div>
                </div>
            </div>
            <div>
                <div class="widgets">
                    <div class="widget">
                        <div class="widget-icon"><i class="bi bi-shield-lock"></i></div>
                        <div>
                            <div class="widget-text">{{ __('site.auth_secure') }}</div>
                            <div class="widget-value">{{ __('site.auth_data_protected') }}</div>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="widget-icon"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="widget-text">{{ __('site.auth_trusted_by') }}</div>
                            <div class="widget-value">{{ __('site.auth_thousands') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <div class="form-card">
                <div class="tabs">
                    <div class="tab" onclick="window.location.href='{{ route('login') }}'">
                        {{ __('site.auth_tab_login') }}</div>
                    <div class="tab active">{{ __('site.auth_tab_register') }}</div>
                </div>

                @if($errors->any())
                    <div class="alert-err">@foreach($errors->all() as $e)<div><i
                    class="bi bi-exclamation-circle me-1"></i>{{ $e }}</div>@endforeach</div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="f-group">
                                <label class="f-label">{{ __('site.auth_fullname') }}</label>
                                <input type="text" name="name" class="f-input @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Juan dela Cruz" required autofocus>
                                @error('name')<div class="invalid-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="f-group">
                                <label class="f-label">{{ __('site.auth_email_req') }}</label>
                                <input type="email" name="email" class="f-input @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="juan@example.com" required>
                                @error('email')<div class="invalid-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="f-group">
                                <label class="f-label">{{ __('site.auth_phone') }}</label>
                                <input type="text" name="phone" class="f-input" value="{{ old('phone') }}"
                                    placeholder="+63 9xx xxx xxxx">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="f-group">
                                <label class="f-label">{{ __('site.auth_pwd') }}</label>
                                <div class="f-input-wrap">
                                    <input type="password" name="password" id="pwd1"
                                        class="f-input @error('password') is-invalid @enderror"
                                        placeholder="{{ __('site.auth_pwd_min') }}" required>
                                    <button type="button" class="pwd-toggle" onclick="togglePwd('pwd1','icon1')"><i
                                            class="bi bi-eye" id="icon1"></i></button>
                                </div>
                                @error('password')<div class="invalid-msg">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="f-group">
                                <label class="f-label">{{ __('site.auth_confirm_pwd') }}</label>
                                <div class="f-input-wrap">
                                    <input type="password" name="password_confirmation" id="pwd2" class="f-input"
                                        placeholder="{{ __('site.auth_reenter_pwd') }}" required>
                                    <button type="button" class="pwd-toggle" onclick="togglePwd('pwd2','icon2')"><i
                                            class="bi bi-eye" id="icon2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="check-row">
                                <input type="checkbox" name="terms" id="terms" required>
                                <label for="terms">{{ __('site.auth_terms_agree') }} <a
                                        href="#">{{ __('site.auth_terms_link') }}</a> &amp; <a
                                        href="#">{{ __('site.auth_privacy_link') }}</a></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-primary">
                                <i class="bi bi-person-plus me-2"></i>{{ __('site.auth_create_btn') }}
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center">
                    <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left"></i>
                        {{ __('site.auth_back_home') }}</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePwd(id, iconId) {
            const p = document.getElementById(id), i = document.getElementById(iconId);
            p.type = p.type === 'password' ? 'text' : 'password';
            i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        }
    </script>
</body>

</html>