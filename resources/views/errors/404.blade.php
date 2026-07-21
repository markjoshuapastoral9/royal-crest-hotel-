<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | The Royal Crest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1a1214 0%, #0a0608 100%);
            color: #E6E2DA;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 40px 20px;
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #C9A84C;
            line-height: 1;
            margin-bottom: 20px;
            font-family: Georgia, serif;
            text-shadow: 0 0 40px rgba(201,168,76,.3);
        }
        .error-title {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 16px;
        }
        .error-message {
            font-size: 16px;
            color: #B8AFA6;
            line-height: 1.6;
            margin-bottom: 32px;
        }
        .btn-home {
            background: #C9A84C;
            color: #1a1214;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all .2s;
            border: none;
        }
        .btn-home:hover {
            background: #d4b357;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(201,168,76,.3);
            color: #1a1214;
        }
        .btn-back {
            background: rgba(255,255,255,.05);
            color: #E6E2DA;
            padding: 12px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all .2s;
            border: 1px solid rgba(255,255,255,.1);
            margin-left: 12px;
        }
        .btn-back:hover {
            background: rgba(255,255,255,.08);
            border-color: rgba(255,255,255,.2);
            color: #ffffff;
        }
        .icon {
            font-size: 80px;
            color: #C9A84C;
            margin-bottom: 24px;
            opacity: .6;
        }
    </style>
</head>
<body>
    <div class="error-container">
        @if(file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}" alt="The Royal Crest Logo" style="width:100px;height:100px;margin:0 auto 20px;display:block;border-radius:12px;">
        @endif
        <i class="bi bi-exclamation-triangle icon"></i>
        <div class="error-code">404</div>
        <div class="error-title">Page Not Found</div>
        <div class="error-message">
            The page you're looking for doesn't exist or may have been removed.<br>
            The booking, room, or resource you tried to access could not be found.
        </div>
        <div>
            @auth
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                    <a href="{{ route('admin.dashboard') }}" class="btn-home">
                        <i class="bi bi-house-door me-2"></i>Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('customer.dashboard') }}" class="btn-home">
                        <i class="bi bi-house-door me-2"></i>My Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('home') }}" class="btn-home">
                    <i class="bi bi-house-door me-2"></i>Go Home
                </a>
            @endauth
            <a href="javascript:history.back()" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i>Go Back
            </a>
        </div>
    </div>
</body>
</html>
