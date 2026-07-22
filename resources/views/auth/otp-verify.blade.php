<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('site.otp_title') }} — Royal Crest Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root{--gold:#A6824A;--gold-light:#C9A87C;--gold-dark:#7A5E32}
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
        .brand-sub{font-size:.6rem;color:rgba(255,255,255,.4);letter-spacing:4px;text-transform:uppercase;margin-top:2px}
        .hero-title{font-family:'Cormorant Garamond',serif;font-size:3.2rem;color:#fff;line-height:1.2;font-weight:600;margin-bottom:1rem}
        .hero-title .gold{color:var(--gold)}
        .hero-sub{color:rgba(192,192,192,.85);font-size:1.05rem;line-height:1.8;max-width:480px;margin-bottom:2.5rem}
        .step-list{display:flex;flex-direction:column;gap:18px;margin-bottom:3rem}
        .step-item{display:flex;align-items:flex-start;gap:14px}
        .step-num{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;flex-shrink:0}
        .step-num.done{background:rgba(34,197,94,.15);border:1px solid rgba(34,197,94,.3);color:#22c55e}
        .step-num.active{background:rgba(166,130,74,.2);border:1px solid rgba(166,130,74,.4);color:var(--gold)}
        .step-num.pending{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);color:rgba(255,255,255,.3)}
        .step-text{padding-top:6px}
        .step-text strong{display:block;color:#fff;font-size:.9rem;margin-bottom:2px}
        .step-text span{color:rgba(192,192,192,.6);font-size:.8rem}
        .widgets{display:flex;gap:20px;flex-wrap:wrap}
        .widget{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:14px 18px;display:flex;align-items:center;gap:12px}
        .widget-icon{color:var(--gold);font-size:1.3rem}
        .widget-text{font-size:.8rem;color:rgba(255,255,255,.5);line-height:1.3}
        .form-wrapper{width:100%}
        .otp-icon-box{width:80px;height:80px;background:linear-gradient(135deg,rgba(166,130,74,.2),rgba(166,130,74,.05));border:2px solid rgba(166,130,74,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem}
        .otp-icon-box i{font-size:2rem;color:var(--gold)}
        .form-title{font-family:'Cormorant Garamond',serif;font-size:2rem;color:#fff;font-weight:700;margin-bottom:.4rem;text-align:center}
        .form-sub{color:rgba(192,192,192,.7);font-size:.88rem;line-height:1.6;margin-bottom:2rem;text-align:center}
        .form-sub strong{color:var(--gold)}
        .otp-inputs{display:flex;gap:12px;justify-content:center;margin-bottom:1.5rem}
        .otp-box{width:52px;height:60px;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.15);border-radius:10px;color:#fff;font-size:1.6rem;font-weight:700;text-align:center;font-family:'Courier New',monospace;transition:all .2s;outline:none}
        .otp-box:focus{border-color:var(--gold);background:rgba(166,130,74,.08);box-shadow:0 0 0 3px rgba(166,130,74,.15)}
        .otp-box.filled{border-color:rgba(166,130,74,.5);background:rgba(166,130,74,.06)}
        #otp-hidden{display:none}
        .btn-gold{background:linear-gradient(135deg,var(--gold) 0%,var(--gold-dark) 100%);color:#000;border:none;font-weight:700;font-size:.95rem;letter-spacing:.5px;border-radius:10px;padding:14px;transition:all .3s;width:100%}
        .btn-gold:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(166,130,74,.35)}
        .countdown{text-align:center;font-size:.85rem;color:rgba(192,192,192,.6);margin:1rem 0}
        .countdown #timer{color:var(--gold);font-weight:700}
        .countdown .resend-link{color:var(--gold);cursor:pointer;text-decoration:underline;display:none}
        .countdown .resend-link.visible{display:inline}
        .divider{display:flex;align-items:center;gap:12px;margin:1.2rem 0}
        .divider hr{flex:1;border-color:rgba(255,255,255,.08)}
        .divider span{color:rgba(192,192,192,.4);font-size:.75rem}
        .back-login{text-align:center;font-size:.85rem;color:rgba(192,192,192,.5)}
        .back-login a{color:var(--gold);text-decoration:none;font-weight:600}
        .alert-success-dark{background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.25);color:#86efac;border-radius:10px;padding:.9rem 1rem;font-size:.85rem;margin-bottom:1.2rem}
        .alert-error-dark{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#fca5a5;border-radius:10px;padding:.9rem 1rem;font-size:.85rem;margin-bottom:1.2rem}
        @media(max-width:992px){.auth-left{display:none}.auth-right{width:100%;border-left:none;padding:40px 30px;justify-content:center}}
        @media(max-width:576px){.auth-right{padding:30px 20px}.otp-box{width:42px;height:50px;font-size:1.3rem}}
    </style>
</head>
<body>
    <div class="auth-bg"></div>
    <div class="auth-overlay"></div>

    <div class="auth-container" style="min-height:100vh;">
        <div class="auth-left">
            <div>
                <div class="brand">
                    <div class="brand-icon"><i class="bi bi-building"></i></div>
                    <div><div class="brand-text">Royal Crest</div><div class="brand-sub">Luxury Hotel</div></div>
                </div>
                <h1 class="hero-title">{{ __('site.otp_secure_access') }}<br><span class="gold">{{ __('site.otp_access') }}</span></h1>
                <p class="hero-sub">{{ __('site.otp_hero_sub') }}</p>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-num done"><i class="bi bi-check-lg"></i></div>
                        <div class="step-text"><strong>{{ __('site.otp_step1_title') }}</strong><span>{{ __('site.otp_step1_sub') }}</span></div>
                    </div>
                    <div class="step-item">
                        <div class="step-num active">2</div>
                        <div class="step-text"><strong>{{ __('site.otp_step2_title') }}</strong><span>{{ __('site.otp_step2_sub') }}</span></div>
                    </div>
                    <div class="step-item">
                        <div class="step-num pending">3</div>
                        <div class="step-text"><strong>{{ __('site.otp_step3_title') }}</strong><span>{{ __('site.otp_step3_sub') }}</span></div>
                    </div>
                </div>
            </div>
            <div class="widgets">
                <div class="widget"><div class="widget-icon"><i class="bi bi-shield-lock"></i></div><div class="widget-text">SSL Encrypted<br><strong style="color:#fff;">{{ __('site.otp_ssl') }}</strong></div></div>
                <div class="widget"><div class="widget-icon"><i class="bi bi-clock-history"></i></div><div class="widget-text">Code expires in<br><strong style="color:#fff;">{{ __('site.otp_expires') }}</strong></div></div>
                <div class="widget"><div class="widget-icon"><i class="bi bi-envelope-check"></i></div><div class="widget-text">Sent to<br><strong style="color:#fff;">{{ __('site.otp_sent_to') }}</strong></div></div>
            </div>
        </div>

        <div class="auth-right">
            <div class="form-wrapper">
                <div class="otp-icon-box"><i class="bi bi-shield-lock-fill"></i></div>
                <h2 class="form-title">{{ __('site.otp_verify_title') }}</h2>
                <p class="form-sub">{!! __('site.otp_verify_sub') !!}</p>

                @if(session('status'))
                    <div class="alert-success-dark"><i class="bi bi-check-circle me-2"></i>{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert-error-dark"><i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form">
                    @csrf
                    <input type="hidden" name="otp" id="otp-hidden">
                    <div class="otp-inputs">
                        @for($i = 1; $i <= 6; $i++)
                        <input type="text" maxlength="1" class="otp-box" id="otp-{{ $i }}" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        @endfor
                    </div>
                    <button type="submit" class="btn-gold" id="submit-btn">
                        <i class="bi bi-check-circle me-2"></i>{{ __('site.otp_verify_btn') }}
                    </button>
                </form>

                <div class="countdown" id="countdown-area">
                    <span id="timer-text">{{ __('site.otp_resend_in') }} <span id="timer">60</span>s</span>
                    <form method="POST" action="{{ route('otp.resend') }}" id="resend-form" style="display:inline;">
                        @csrf
                        <button type="submit" class="resend-link" id="resend-btn" style="background:none;border:none;padding:0;">
                            {{ __('site.otp_resend') }}
                        </button>
                    </form>
                </div>

                <div class="divider"><hr><span>or</span><hr></div>
                <div class="back-login">
                    <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>{{ __('site.otp_back_login') }}</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const boxes = document.querySelectorAll('.otp-box');
        const hiddenInput = document.getElementById('otp-hidden');
        const form = document.getElementById('otp-form');
        boxes.forEach((box, idx) => {
            box.addEventListener('input', (e) => {
                const val = e.target.value.replace(/\D/g, '');
                e.target.value = val;
                if (val && idx < 5) boxes[idx + 1].focus();
                box.classList.toggle('filled', !!val);
                updateHidden();
            });
            box.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !box.value && idx > 0) {
                    boxes[idx - 1].focus(); boxes[idx - 1].value = ''; boxes[idx - 1].classList.remove('filled'); updateHidden();
                }
            });
            box.addEventListener('paste', (e) => {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
                paste.split('').forEach((char, i) => { if (boxes[i]) { boxes[i].value = char; boxes[i].classList.add('filled'); } });
                if (boxes[paste.length - 1]) boxes[paste.length - 1].focus();
                updateHidden();
            });
        });
        function updateHidden() { hiddenInput.value = Array.from(boxes).map(b => b.value).join(''); }
        form.addEventListener('input', () => { if (Array.from(boxes).map(b => b.value).join('').length === 6) setTimeout(() => form.submit(), 300); });
        boxes[0].focus();
        let seconds = 60;
        const timerEl = document.getElementById('timer');
        const timerText = document.getElementById('timer-text');
        const resendBtn = document.getElementById('resend-btn');
        const countdown = setInterval(() => {
            seconds--;
            timerEl.textContent = seconds;
            if (seconds <= 0) { clearInterval(countdown); timerText.style.display = 'none'; resendBtn.style.display = 'inline'; resendBtn.classList.add('visible'); }
        }, 1000);
        setInterval(() => fetch('{{ route("login") }}', {method:'HEAD',credentials:'same-origin'}), 60000);
    </script>
</body>
</html>
