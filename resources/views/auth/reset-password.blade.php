<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Reset Password') }} — The Royal Crest</title>
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
        .form-card{width:100%;max-width:460px;background:rgba(20,20,22,.92);backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.08);border-radius:20px;padding:50px}
        .brand{display:flex;align-items:center;justify-content:center;gap:14px;margin-bottom:2rem}
        .brand-icon{width:48px;height:48px;background:linear-gradient(135deg,var(--gold) 0%,var(--gold-dark) 100%);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#000;font-size:1.4rem}
        .brand-text{font-family:'Cormorant Garamond',serif;font-size:1.6rem;color:#fff;font-weight:600;letter-spacing:1px;line-height:1}
        .brand-sub{font-size:.6rem;color:rgba(255,255,255,.4);letter-spacing:4px;text-transform:uppercase;margin-top:2px;text-align:center}
        .card-title{font-family:'Cormorant Garamond',serif;font-size:2rem;color:#fff;text-align:center;margin-bottom:.8rem}
        .card-subtitle{color:rgba(192,192,192,.75);font-size:.88rem;line-height:1.7;text-align:center;margin-bottom:2rem}
        .f-group{margin-bottom:1.2rem}
        .f-label{display:block;font-size:.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:rgba(192,192,192,.7);margin-bottom:.5rem;font-family:'Inter',sans-serif}
        .f-input-wrap{position:relative}
        .f-input{width:100%;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:10px;color:#fff;padding:12px 14px;font-size:.88rem;font-family:'Inter',sans-serif;outline:none;transition:all .25s}
        .f-input:focus{border-color:var(--gold);background:rgba(255,255,255,.09);box-shadow:0 0 0 3px rgba(166,130,74,.12)}
        .f-input::placeholder{color:rgba(192,192,192,.35)}
        .pwd-toggle{position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--gold);cursor:pointer;font-size:.9rem;padding:4px;z-index:1}
        .btn-primary{width:100%;background:var(--gold);color:#101111;border:none;border-radius:10px;padding:14px;font-weight:700;font-size:.92rem;cursor:pointer;transition:all .3s;font-family:'Inter',sans-serif;letter-spacing:.3px}
        .btn-primary:hover{background:var(--gold-light);transform:translateY(-2px);box-shadow:0 8px 25px rgba(166,130,74,.35)}
        .back-link{display:inline-flex;align-items:center;gap:6px;font-size:.82rem;color:rgba(192,192,192,.5);text-decoration:none;margin-top:1.5rem;transition:color .2s}
        .back-link:hover{color:var(--gold)}
        .alert-err{background:rgba(220,38,38,.12);border:1px solid rgba(220,38,38,.3);border-radius:10px;color:#fca5a5;padding:10px 14px;font-size:.82rem;margin-bottom:1.2rem}
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

            <h2 class="card-title">{{ __('Reset Password') }}</h2>
            <p class="card-subtitle">{{ __('Enter your new password below.') }}</p>

            @if($errors->any())
            <div class="alert-err">
                @foreach($errors->all() as $e)
                <div><i class="bi bi-exclamation-circle me-1"></i>{{ $e }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="f-group">
                    <label class="f-label">{{ __('Email Address') }}</label>
                    <input type="email" name="email" class="f-input" value="{{ old('email', $request->email) }}" placeholder="your@email.com" required autofocus readonly>
                </div>

                <div class="f-group">
                    <label class="f-label">{{ __('New Password') }}</label>
                    <div class="f-input-wrap">
                        <input type="password" name="password" id="pwd1" class="f-input" placeholder="••••••••" required>
                        <button type="button" class="pwd-toggle" onclick="togglePwd('pwd1','icon1')"><i class="bi bi-eye" id="icon1"></i></button>
                    </div>
                </div>

                <div class="f-group">
                    <label class="f-label">{{ __('Confirm Password') }}</label>
                    <div class="f-input-wrap">
                        <input type="password" name="password_confirmation" id="pwd2" class="f-input" placeholder="••••••••" required>
                        <button type="button" class="pwd-toggle" onclick="togglePwd('pwd2','icon2')"><i class="bi bi-eye" id="icon2"></i></button>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="bi bi-key me-2"></i>{{ __('Reset Password') }}
                </button>
            </form>

            <div class="text-center">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> {{ __('Back to Login') }}
                </a>
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
