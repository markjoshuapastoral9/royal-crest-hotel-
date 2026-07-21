<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('site.auth_tab_login') }} — The Royal Crest</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --gold:#A6824A;--gold-light:#C9A87C;--gold-dark:#7A5E32;--bg-dark:#101111;--surface:#1a1214;--text-pri:#E6E2DA;--text-sec:#B8AFA6; }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%;font-family:'Inter',sans-serif}
        body{display:flex;position:relative;overflow:hidden}
        .auth-bg{position:fixed;inset:0;background:url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=90') center/cover no-repeat;z-index:0}
        .auth-overlay{position:fixed;inset:0;background:linear-gradient(120deg,rgba(5,5,8,.85) 0%,rgba(10,8,5,.75) 50%,rgba(5,5,8,.88) 100%);z-index:1}
        .auth-container{position:relative;z-index:2;width:100%;display:flex}
        .auth-left{flex:1;padding:60px 80px;display:flex;flex-direction:column;justify-content:space-between}
        .auth-right{width:480px;background:rgba(20,20,22,.92);backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);border-left:1px solid rgba(255,255,255,.08);display:flex;align-items:center;padding:60px 50px}
        .brand{display:flex;align-items:center;gap:14px;margin-bottom:60px}
        .brand-icon{width:48px;height:48px;background:linear-gradient(135deg,var(--gold) 0%,var(--gold-dark) 100%);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#000;font-size:1.4rem}
        .brand-text{font-family:'Cormorant Garamond',serif;font-size:1.8rem;color:#fff;font-weight:600;letter-spacing:1px;line-height:1}
        .brand-sub{font-size:.6rem;color:rgba(255,255,255,.4);letter-spacing:4px;text-transform:uppercase;font-family:'Inter',sans-serif;margin-top:2px}
        .hero-title{font-family:'Cormorant Garamond',serif;font-size:3.2rem;color:#fff;line-height:1.2;font-weight:600;margin-bottom:1rem}
        .hero-title .gold{color:var(--gold)}
        .hero-sub{color:rgba(192,192,192,.85);font-size:1.05rem;line-height:1.8;max-width:480px;margin-bottom:2.5rem}
        .features{display:flex;flex-direction:column;gap:16px;margin-bottom:3rem}
        .feat-item{display:flex;align-items:center;gap:12px}
        .feat-icon{width:42px;height:42px;background:rgba(166,130,74,.12);border:1px solid rgba(166,130,74,.25);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:1.1rem;flex-shrink:0}
        .feat-text{color:rgba(255,255,255,.8);font-size:.92rem}
        .widgets{display:flex;gap:20px;flex-wrap:wrap}
        .widget{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:14px 18px;display:flex;align-items:center;gap:12px}
        .widget-icon{color:var(--gold);font-size:1.3rem}
        .widget-text{font-size:.8rem;color:rgba(255,255,255,.5);line-height:1.3}
        .widget-value{font-size:1rem;color:#fff;font-weight:600}
        .trust-badges{display:flex;gap:32px;margin-top:2rem;padding-top:2rem;border-top:1px solid rgba(255,255,255,.06)}
        .trust-item{display:flex;align-items:center;gap:10px}
        .trust-icon{color:rgba(166,130,74,.6);font-size:1.1rem}
        .trust-label{font-size:.78rem;color:rgba(192,192,192,.65)}
        .form-card{width:100%}
        .tabs{display:flex;gap:0;margin-bottom:2rem;border-bottom:1px solid rgba(255,255,255,.1)}
        .tab{flex:1;padding:12px;text-align:center;font-size:.95rem;font-weight:600;color:rgba(255,255,255,.5);cursor:pointer;transition:all .3s;border-bottom:2px solid transparent;font-family:'Inter',sans-serif}
        .tab.active{color:#fff;border-bottom-color:var(--gold)}
        .tab:hover{color:rgba(255,255,255,.8)}
        .f-group{margin-bottom:1.2rem;position:relative}
        .f-label{display:block;font-size:.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:rgba(192,192,192,.7);margin-bottom:.5rem;font-family:'Inter',sans-serif}
        .f-input-wrap{position:relative}
        .f-icon{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--gold);font-size:.95rem;z-index:1;pointer-events:none}
        .f-input{width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:10px;color:#fff;padding:12px 14px 12px 44px;font-size:.88rem;font-family:'Inter',sans-serif;outline:none;transition:all .25s}
        .f-input:focus{border-color:var(--gold);background:rgba(255,255,255,.09);box-shadow:0 0 0 3px rgba(166,130,74,.12)}
        .f-input::placeholder{color:rgba(192,192,192,.35)}
        .pwd-toggle{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--gold);cursor:pointer;font-size:.9rem;padding:4px;z-index:1}
        .check-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.2rem;font-size:.82rem}
        .check-row label{display:flex;align-items:center;gap:8px;color:rgba(192,192,192,.75);cursor:pointer}
        .check-row input[type=checkbox]{accent-color:var(--gold);width:16px;height:16px}
        .check-row a{color:var(--gold);text-decoration:none}
        .btn-primary{width:100%;background:var(--gold);color:#101111;border:none;border-radius:10px;padding:14px;font-weight:700;font-size:.92rem;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif;letter-spacing:.3px}
        .btn-primary:hover{background:var(--gold-light);transform:translateY(-2px);box-shadow:0 8px 25px rgba(166,130,74,.35)}
        .back-link{display:inline-flex;align-items:center;gap:6px;font-size:.78rem;color:rgba(192,192,192,.5);text-decoration:none;margin-top:1.2rem;transition:color .2s}
        .back-link:hover{color:var(--gold)}
        .alert-err{background:rgba(220,38,38,.12);border:1px solid rgba(220,38,38,.3);border-radius:10px;color:#fca5a5;padding:10px 14px;font-size:.82rem;margin-bottom:1.2rem}
        @media(max-width:1024px){.auth-left{padding:40px 50px}.auth-right{width:420px;padding:40px 35px}.hero-title{font-size:2.6rem}}
        @media(max-width:768px){.auth-left{display:none}.auth-right{width:100%;border-left:none}}
    </style>
</head>
<body>
    <div class="auth-bg"></div>
    <div class="auth-overlay"></div>
    <div class="auth-container">
        <div class="auth-left">
            <div>
                <div class="brand">
                    <img src="{{ asset('images/logo.png') }}" alt="The Royal Crest" style="width:80px;height:80px;border-radius:12px;object-fit:cover;">
                    <div>
                        <div class="brand-text">THE ROYAL CREST</div>
                        <div class="brand-sub">HOTEL</div>
                    </div>
                </div>
                <h1 class="hero-title">{{ __('site.auth_welcome_back') }}<br><span class="gold">The Royal Crest</span></h1>
                <p class="hero-sub">{{ __('site.auth_signin_sub') }}</p>
                <div class="features">
                    <div class="feat-item"><div class="feat-icon"><i class="bi bi-gem"></i></div><div class="feat-text">{{ __('site.auth_best_rate') }}</div></div>
                    <div class="feat-item"><div class="feat-icon"><i class="bi bi-star"></i></div><div class="feat-text">{{ __('site.auth_member_benefits') }}</div></div>
                    <div class="feat-item"><div class="feat-icon"><i class="bi bi-calendar-check"></i></div><div class="feat-text">{{ __('site.auth_manage_bookings') }}</div></div>
                </div>
            </div>
            <div>
                <div class="widgets">
                    <div class="widget"><div class="widget-icon"><i class="bi bi-cloud-sun"></i></div><div><div class="widget-text">{{ __('site.auth_weather') }}</div><div class="widget-value">28°C</div></div></div>
                    <div class="widget"><div class="widget-icon"><i class="bi bi-clock"></i></div><div><div class="widget-text">{{ __('site.auth_local_time') }}</div><div class="widget-value" id="localTime">--:--</div></div></div>
                    <div class="widget"><div class="widget-icon"><i class="bi bi-geo-alt"></i></div><div><div class="widget-text">{{ __('site.auth_hotel_location') }}</div><div class="widget-value">Calasiao, PH</div></div></div>
                </div>
                <div class="trust-badges">
                    <div class="trust-item"><div class="trust-icon"><i class="bi bi-shield-check"></i></div><div class="trust-label">{{ __('site.auth_ssl') }}</div></div>
                    <div class="trust-item"><div class="trust-icon"><i class="bi bi-people"></i></div><div class="trust-label">{{ __('site.auth_trusted') }}</div></div>
                </div>
            </div>
        </div>

        <div class="auth-right">
            <div class="form-card">
                <div class="tabs">
                    <div class="tab active">{{ __('site.auth_tab_login') }}</div>
                    <div class="tab" onclick="window.location.href='{{ route('register') }}'">{{ __('site.auth_tab_register') }}</div>
                </div>

                @if($errors->any())
                <div class="alert-err">@foreach($errors->all() as $e)<div><i class="bi bi-exclamation-circle me-1"></i>{{ $e }}</div>@endforeach</div>
                @endif

                @if(session('resend_verification'))
                <form method="POST" action="{{ route('verification.resend.guest') }}" style="margin-bottom:1rem;">
                    @csrf
                    <input type="hidden" name="email" value="{{ old('email') }}">
                    <div style="background:rgba(166,130,74,.08);border:1px solid rgba(166,130,74,.25);border-radius:10px;padding:10px 14px;font-size:.82rem;color:#C9A87C;display:flex;align-items:center;justify-content:space-between;gap:10px;">
                        <span><i class="bi bi-envelope me-1"></i>{{ __('site.auth_not_verified') }}</span>
                        <button type="submit" style="background:none;border:none;color:#A6824A;font-weight:700;cursor:pointer;font-size:.82rem;white-space:nowrap;padding:0;">{{ __('site.auth_resend_link') }}</button>
                    </div>
                </form>
                @endif

                @if(session('status'))
                <div style="background:rgba(21,66,48,.2);border:1px solid rgba(21,66,48,.5);color:#6ee7b7;border-radius:10px;padding:10px 14px;font-size:.82rem;margin-bottom:1.2rem;">
                    <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="f-group">
                        <label class="f-label">{{ __('site.auth_email') }}</label>
                        <div class="f-input-wrap">
                            <i class="bi bi-envelope f-icon"></i>
                            <input type="email" name="email" class="f-input" value="{{ old('email') }}" placeholder="admin@theroyalcrest.com" required autofocus>
                        </div>
                    </div>
                    <div class="f-group">
                        <label class="f-label">{{ __('site.auth_password') }}</label>
                        <div class="f-input-wrap">
                            <i class="bi bi-lock f-icon"></i>
                            <input type="password" name="password" id="pwd" class="f-input" placeholder="••••••••" required>
                            <button type="button" class="pwd-toggle" onclick="togglePwd()"><i class="bi bi-eye" id="pwdIcon"></i></button>
                        </div>
                    </div>
                    <div class="check-row">
                        <label><input type="checkbox" name="remember"> {{ __('site.auth_remember') }}</label>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('site.auth_forgot') }}</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('site.auth_signin_btn') }}
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="back-link"><i class="bi bi-arrow-left"></i> {{ __('site.auth_back_home') }}</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePwd() {
            const p = document.getElementById('pwd'), i = document.getElementById('pwdIcon');
            p.type = p.type === 'password' ? 'text' : 'password';
            i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        }
        function updateTime() {
            const now = new Date();
            document.getElementById('localTime').textContent = now.toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit',hour12:true});
        }
        updateTime(); setInterval(updateTime,1000);
    </script>
</body>
</html>
