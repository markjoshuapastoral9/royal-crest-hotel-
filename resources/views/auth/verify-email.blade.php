<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Verify Email') }} — The Royal Crest</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root{--gold:#A6824A;--gold-light:#C9A87C;--gold-dark:#7A5E32;--bg-dark:#101111;--surface:#1a1214}
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html,body{height:100%;font-family:'Inter',sans-serif}
        body{display:flex;position:relative;overflow:hidden}
        .auth-bg{position:fixed;inset:0;background:url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=90') center/cover no-repeat;z-index:0}
        .auth-overlay{position:fixed;inset:0;background:linear-gradient(120deg,rgba(5,5,8,.85) 0%,rgba(10,8,5,.75) 50%,rgba(5,5,8,.88) 100%);z-index:1}
        .auth-container{position:relative;z-index:2;width:100%;display:flex;align-items:center;justify-content:center;padding:40px 20px}
        .form-card{width:100%;max-width:520px;background:rgba(20,20,22,.92);backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.08);border-radius:20px;padding:50px}
        .brand{display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:2rem}
        .brand-icon{width:48px;height:48px;background:linear-gradient(135deg,var(--gold) 0%,var(--gold-dark) 100%);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#000;font-size:1.4rem}
        .brand-text{font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:#fff;font-weight:600;letter-spacing:1px;line-height:1}
        .brand-sub{font-size:.6rem;color:rgba(255,255,255,.4);letter-spacing:4px;text-transform:uppercase;margin-top:2px;text-align:center}
        .card-icon{width:80px;height:80px;background:rgba(166,130,74,.12);border:1px solid rgba(166,130,74,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:2.5rem;margin:0 auto 1.5rem}
        .card-title{font-family:'Cormorant Garamond',serif;font-size:2rem;color:#fff;text-align:center;margin-bottom:.8rem}
        .card-subtitle{color:rgba(192,192,192,.75);font-size:.88rem;line-height:1.7;text-align:center;margin-bottom:2rem}
        .btn-primary{width:100%;background:var(--gold);color:#101111;border:none;border-radius:10px;padding:14px;font-weight:700;font-size:.92rem;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif;letter-spacing:.3px;display:inline-block;text-align:center;text-decoration:none}
        .btn-primary:hover{background:var(--gold-light);transform:translateY(-2px);box-shadow:0 8px 25px rgba(166,130,74,.35);color:#101111}
        .btn-secondary{width:100%;background:rgba(255,255,255,.06);color:rgba(255,255,255,.8);border:1px solid rgba(255,255,255,.12);border-radius:10px;padding:14px;font-weight:600;font-size:.88rem;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif;display:inline-block;text-align:center;text-decoration:none}
        .btn-secondary:hover{background:rgba(255,255,255,.09);border-color:rgba(255,255,255,.2);color:#fff}
        .back-link{display:inline-flex;align-items:center;gap:6px;font-size:.82rem;color:rgba(192,192,192,.5);text-decoration:none;margin-top:1.5rem;transition:color .2s}
        .back-link:hover{color:var(--gold)}
        .alert-success{background:rgba(21,66,48,.2);border:1px solid rgba(21,66,48,.5);color:#6ee7b7;border-radius:10px;padding:10px 14px;font-size:.82rem;margin-bottom:1.5rem}
        .divider{display:flex;align-items:center;gap:1rem;margin:1.5rem 0}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:rgba(255,255,255,.1)}
        .divider span{color:rgba(192,192,192,.5);font-size:.8rem}
        @media(max-width:576px){.form-card{padding:40px 30px}.card-title{font-size:1.6rem}}
    </style>
</head>
<body>
    <div class="auth-bg"></div>
    <div class="auth-overlay"></div>
    <div class="auth-container">
        <div class="form-card">
            <div class="brand">
                <div class="brand-icon"><i class="bi bi-gem"></i></div>
                <div>
                    <div class="brand-text">THE ROYAL CREST</div>
                    <div class="brand-sub">HOTEL</div>
                </div>
            </div>

            <div class="card-icon"><i class="bi bi-envelope-check"></i></div>
            <h2 class="card-title">{{ __('Verify Your Email') }}</h2>
            <p class="card-subtitle">{{ __('Before continuing, please verify your email address by clicking on the link we sent to you. If you didn\'t receive the email, we will gladly send you another.') }}</p>

            @if(session('status') == 'verification-link-sent')
            <div class="alert-success">
                <i class="bi bi-check-circle me-1"></i>{{ __('A new verification link has been sent to your email address.') }}
            </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary">
                    <i class="bi bi-envelope me-2"></i>{{ __('Resend Verification Email') }}
                </button>
            </form>

            <div class="divider"><span>OR</span></div>

            <div style="display:flex;gap:10px;">
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> {{ __('Back to Home') }}
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
