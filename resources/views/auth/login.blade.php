<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | Utility App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #002970;
            --primary-dark: #001a4d;
            --accent: #00baf2;
            --text-dark: #1A1A1A;
            --text-muted: #718096;
            --white: #ffffff;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e8f4ff 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 41, 112, 0.15);
            overflow: hidden;
            max-width: 1100px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 620px;
        }

        /* Left */
        .login-left {
            background: linear-gradient(135deg, var(--primary) 0%, #0057b8 100%);
            padding: 40px;
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 200px; height: 200px;
            background: rgba(0, 186, 242, 0.1);
            border-radius: 50%;
        }

        .login-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -40px;
            width: 180px; height: 180px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .brand-icon {
            width: 48px; height: 48px;
            background: rgba(0, 186, 242, 0.2);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 18px;
            border: 1px solid rgba(0, 186, 242, 0.3);
            position: relative; z-index: 2;
        }

        .login-left h1 {
            font-size: 28px; margin-bottom: 10px;
            font-weight: 800; line-height: 1.2;
            color: var(--white); position: relative; z-index: 2;
        }

        .login-left h1 span { color: var(--accent); }

        .login-left > p {
            font-size: 14px; line-height: 1.6;
            margin-bottom: 28px;
            color: rgba(255,255,255,0.75);
            position: relative; z-index: 2;
        }

        .feature-list { list-style: none; position: relative; z-index: 2; }

        .feature-list li {
            padding: 7px 0;
            display: flex; align-items: center; gap: 12px;
            font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 500;
        }

        .feature-list li i {
            background: rgba(0, 186, 242, 0.2);
            width: 24px; height: 24px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 50%; font-size: 11px; color: var(--accent); flex-shrink: 0;
        }

        /* Right */
        .login-right {
            padding: 40px;
            display: flex; flex-direction: column; justify-content: center;
            background: white;
        }

        .login-header { text-align: center; margin-bottom: 28px; }

        .login-header h2 {
            font-size: 26px; color: var(--primary);
            margin-bottom: 5px; font-weight: 800; letter-spacing: -0.5px;
        }

        .login-header p { color: var(--text-muted); font-size: 14px; font-weight: 500; opacity: 0.8; }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block; margin-bottom: 8px;
            color: var(--text-dark); font-weight: 600; font-size: 13px;
        }

        .input-wrapper { position: relative; }

        .input-wrapper input {
            width: 100%;
            padding: 12px 15px 12px 42px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif;
            color: var(--text-dark); background: #fdfdfd;
            transition: all 0.3s; outline: none;
        }

        .input-wrapper input.is-invalid {
            border-color: #ef4444;
        }

        .input-wrapper i.field-icon {
            position: absolute; left: 15px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted); font-size: 14px;
        }

        .input-wrapper input:focus {
            border-color: var(--accent); background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 186, 242, 0.1);
        }

        .toggle-password {
            position: absolute; right: 15px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer; color: var(--text-muted);
        }

        .invalid-feedback {
            color: #ef4444; font-size: 12px; margin-top: 5px; display: block;
        }

        .alert-info {
            background: rgba(0, 186, 242, 0.1);
            border: 1px solid rgba(0, 186, 242, 0.3);
            color: var(--primary);
            padding: 10px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 18px;
        }

        .login-btn {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--primary) 0%, #0057b8 100%);
            color: white; border: none; border-radius: 10px;
            font-size: 15px; font-weight: 700; font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            margin-top: 8px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 41, 112, 0.25);
        }

        .footer-note {
            text-align: center; margin-top: 20px;
            font-size: 12px; color: var(--text-muted); line-height: 1.6;
        }

        @media (max-width: 768px) {
            .login-container { grid-template-columns: 1fr; max-width: 440px; }
            .login-left { display: none; }
            .login-right { padding: 35px 25px; }
        }
    </style>
</head>
<body>
    <div class="login-container">

        <!-- Left -->
        <div class="login-left">
            <div class="brand-icon">
                <img src="{{ asset('images/logo.png') }}" alt="Utility App" style="width:100%;height:100%;object-fit:contain;border-radius:8px;" onerror="this.style.display='none';this.parentElement.innerHTML='<i class=\'fas fa-bolt\'></i>'">
            </div>
            <h1>Utility App<br><span>Admin Panel</span></h1>
            <p>Complete control over users, payments, recharges, bills, and bus bookings.</p>
            <ul class="feature-list">
                <li><i class="fas fa-users"></i> User Management & KYC</li>
                <li><i class="fas fa-money-bill-transfer"></i> Wallet & Transaction Control</li>
                <li><i class="fas fa-mobile-screen"></i> Recharge & DTH Management</li>
                <li><i class="fas fa-bus"></i> Bus Booking & Cancellations</li>
                <li><i class="fas fa-chart-pie"></i> Revenue Reports & API Logs</li>
            </ul>
        </div>

        <!-- Right -->
        <div class="login-right">
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="Utility App" style="height:65px;object-fit:contain;margin-bottom:15px;filter:drop-shadow(0 4px 6px rgba(0,41,112,0.1));" onerror="this.style.display='none'">
                <h2>Welcome Back</h2>
                <p>Sign in to access the Utility Admin Console</p>
            </div>

            @if(session()->has('message'))
                <div class="alert-info">{{ session()->get('message') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Admin Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" name="email" id="email"
                               placeholder="admin@utilityapp.in"
                               value="{{ old('email') }}"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               required autocomplete="email" autofocus>
                    </div>
                    @if($errors->has('email'))
                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" id="password"
                               placeholder="••••••••"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                               required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                    @if($errors->has('password'))
                        <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div style="text-align:right; margin-bottom: 4px;">
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:13px;font-weight:600;color:var(--accent);text-decoration:none;">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <span>Sign In</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <p class="footer-note">© {{ date('Y') }} Utility App. All rights reserved.</p>
            </form>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('loginBtn').closest('form').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<span>Verifying...</span> <i class="fas fa-spinner fa-spin"></i>';
            btn.style.opacity = '0.7';
            btn.disabled = true;
        });
    </script>
</body>
</html>
