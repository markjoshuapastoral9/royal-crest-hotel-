<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication — The Royal Crest</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --gold:       #A6824A;
            --gold-light: #C9A87C;
            --gold-dark:  #7A5E32;
            --bg-dark:    #101111;
            --surface:    #1a1214;
            --text-pri:   #E6E2DA;
            --text-sec:   #B8AFA6;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; }
        body {
            background: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=90') center/cover no-repeat fixed;
            display: flex; position: relative; overflow: hidden;
        }
        .auth-bg { position: fixed; inset: 0; background: url('https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1920&q=90') center/cover no-repeat; z-index: 0; }
        .auth-overlay { position: fixed; inset: 0; background: linear-gradient(120deg, rgba(5,5,8,.85) 0%, rgba(10,8,5,.75) 50%, rgba(5,5,8,.88) 100%); z-index: 1; }
        .auth-container { position: relative; z-index: 2; width: 100%; display: flex; }
        .auth-left { flex: 1; padding: 60px 80px; display: flex; flex-direction: column; justify-content: space-between; }
        .auth-right { width: 480px; background: rgba(20,14,16,.92); backdrop-filter: blur(28px); -webkit-backdrop-filter: blur(28px); border-left: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; padding: 60px 50px; }

        /* Brand */
        .brand { display: flex; align-items: center; gap: 14px; margin-bottom: 60px; }
        .brand-icon { width: 48px; height: 48px; background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #000; font-size: 1.4rem; }
        .brand-text { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: #fff; font-weight: 600; letter-spacing: 1px; line-height: 1; }
        .brand-sub { font-size: .6rem; color: rgba(255,255,255,.4); letter-spacing: 4px; text-transform: uppercase; font-family: 'Inter', sans-serif; margin-top: 2px; }

        /* Left */
        .hero-title { font-family: 'Cormorant Garamond', serif; font-size: 3.2rem; color: #fff; line-height: 1.2; font-weight: 600; margin-bottom: 1rem; }
        .hero-title .gold { color: var(--gold); }
        .hero-sub { color: rgba(192,192,192,.85); font-size: 1.05rem; line-height: 1.8; max-width: 480px; }

        /* Form */
        .form-card { width: 100%; }
        .icon-wrap { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, rgba(166,130,74,.2), rgba(166,130,74,.05)); border: 2px solid rgba(166,130,74,.35); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--gold); font-size: 1.8rem; }
        .form-title { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; color: #fff; font-weight: 600; text-align: center; margin-bottom: .5rem; }
        .form-sub { font-size: .82rem; color: var(--text-sec); text-align: center; margin-bottom: 2rem; line-height: 1.7; }

        .f-group { margin-bottom: 1.2rem; }
        .f-label { display: block; font-size: .72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(192,192,192,.7); margin-bottom: .5rem; }
        .f-input-wrap { position: relative; }
        .f-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(184,175,166,.4); font-size: .95rem; pointer-events: none; }
        .f-input { width: 100%; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 10px; color: #E6E2DA; padding: 12px 14px 12px 44px; font-size: .88rem; outline: none; transition: all .25s; }
        .f-input:focus { border-color: var(--gold); background: rgba(255,255,255,.09); box-shadow: 0 0 0 3px rgba(166,130,74,.12); }
        .f-input::placeholder { color: rgba(184,175,166,.3); }

        /* OTP boxes */
        .otp-grid { display: flex; gap: 10px; justify-content: center; margin-bottom: 1.5rem; }
        .otp-box { width: 52px; height: 60px; text-align: center; font-size: 1.5rem; font-weight: 700; color: #E6E2DA; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12); border-radius: 10px; outline: none; transition: all .25s; }
        .otp-box:focus { border-color: var(--gold); background: rgba(255,255,255,.09); box-shadow: 0 0 0 3px rgba(166,130,74,.12); }

        .btn-primary { width: 100%; background: var(--gold); color: #101111; border: none; border-radius: 10px; padding: 14px; font-weight: 700; font-size: .92rem; cursor: pointer; transition: all .3s; font-family: 'Inter', sans-serif; }
        .btn-primary:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: 0 8px 25px rgba(166,130,74,.35); }

        .toggle-link { text-align: center; margin-top: 1.2rem; font-size: .82rem; color: var(--text-sec); }
        .toggle-link button { background: none; border: none; color: var(--gold); cursor: pointer; font-size: .82rem; font-weight: 600; padding: 0; text-decoration: underline; }

        .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: .78rem; color: rgba(192,192,192,.5); text-decoration: none; margin-top: 1.5rem; transition: color .2s; }
        .back-link:hover { color: var(--gold); }

        .alert-err { background: rgba(220,38,38,.12); border: 1px solid rgba(220,38,38,.3); border-radius: 10px; color: #fca5a5; padding: 10px 14px; font-size: .82rem; margin-bottom: 1.2rem; }
        .alert-info { background: rgba(166,130,74,.1); border: 1px solid rgba(166,130,74,.25); border-radius: 10px; color: var(--gold-light); padding: 10px 14px; font-size: .82rem; margin-bottom: 1.2rem; text-align: center; }

        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; border-left: none; padding: 40px 28px; }
        }
    </style>
</head>
<body>
    <div class="auth-bg"></div>
    <div class="auth-overlay"></div>

    <div class="auth-container">
        {{-- Left Panel --}}
        <div class="auth-left">
            <div>
                <div class="brand">
                    <div class="brand-icon"><i class="bi bi-gem"></i></div>
                    <div>
                        <div class="brand-text">THE ROYAL CREST</div>
                        <div class="brand-sub">HOTEL</div>
                    </div>
                </div>
                <h1 class="hero-title">Secure Your<br><span class="gold">Access</span></h1>
                <p class="hero-sub">Two-factor authentication adds an extra layer of security to your The Royal Crest account.</p>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,.06);padding-top:2rem;">
                <div style="display:flex;gap:24px;">
                    <div style="display:flex;align-items:center;gap:8px;font-size:.78rem;color:rgba(192,192,192,.55);">
                        <i class="bi bi-shield-check" style="color:rgba(166,130,74,.6);"></i> 256-bit SSL Secure
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;font-size:.78rem;color:rgba(192,192,192,.55);">
                        <i class="bi bi-lock" style="color:rgba(166,130,74,.6);"></i> 2FA Protected
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="auth-right">
            <div class="form-card">
                <div class="icon-wrap">
                    <i class="bi bi-shield-lock"></i>
                </div>

                <div class="form-title">Two-Factor Auth</div>
                <div class="form-sub" id="formDesc">
                    Enter the 6-digit code from your authenticator app to complete login.
                </div>

                @if($errors->any())
                <div class="alert-err">
                    @foreach($errors->all() as $e)
                    <div><i class="bi bi-exclamation-circle me-1"></i>{{ $e }}</div>
                    @endforeach
                </div>
                @endif

                {{-- OTP Code Form --}}
                <div id="codeSection">
                    <form method="POST" action="/two-factor-challenge" id="codeForm">
                        @csrf
                        <div class="f-group">
                            <label class="f-label" style="text-align:center;display:block;">Authentication Code</label>
                            <div class="otp-grid" id="otpGrid">
                                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autofocus>
                                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                                <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                            </div>
                            <input type="hidden" name="code" id="codeInput">
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-shield-check me-2"></i>Verify & Login
                        </button>
                    </form>
                    <div class="toggle-link">
                        <button onclick="toggleMode('recovery')" type="button">Use a recovery code instead</button>
                    </div>
                </div>

                {{-- Recovery Code Form --}}
                <div id="recoverySection" style="display:none;">
                    <form method="POST" action="/two-factor-challenge">
                        @csrf
                        <div class="f-group">
                            <label class="f-label">Recovery Code</label>
                            <div class="f-input-wrap">
                                <i class="bi bi-key f-icon"></i>
                                <input type="text" name="recovery_code" class="f-input" placeholder="Enter recovery code" autocomplete="off">
                            </div>
                        </div>
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-unlock me-2"></i>Verify with Recovery Code
                        </button>
                    </form>
                    <div class="toggle-link">
                        <button onclick="toggleMode('code')" type="button">Use authentication code instead</button>
                    </div>
                </div>

                <div style="text-align:center;">
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="bi bi-arrow-left"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // OTP box auto-advance
        const boxes = document.querySelectorAll('.otp-box');
        const codeInput = document.getElementById('codeInput');
        const codeForm = document.getElementById('codeForm');

        boxes.forEach((box, i) => {
            box.addEventListener('input', () => {
                if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
                updateCode();
            });
            box.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
            });
        });

        codeForm.addEventListener('submit', () => updateCode());

        function updateCode() {
            codeInput.value = Array.from(boxes).map(b => b.value).join('');
        }

        function toggleMode(mode) {
            const code = document.getElementById('codeSection');
            const recovery = document.getElementById('recoverySection');
            const desc = document.getElementById('formDesc');
            if (mode === 'recovery') {
                code.style.display = 'none';
                recovery.style.display = 'block';
                desc.textContent = 'Enter one of your emergency recovery codes to access your account.';
            } else {
                code.style.display = 'block';
                recovery.style.display = 'none';
                desc.textContent = 'Enter the 6-digit code from your authenticator app to complete login.';
            }
        }
    </script>
</body>
</html>
