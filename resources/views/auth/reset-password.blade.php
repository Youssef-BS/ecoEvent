<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Charitize</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Josefin+Sans:wght@600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="reset-container">
        <div class="reset-card">
            <h2>Reset Password</h2>
            <p>Enter your email and new password to reset your account.</p>

            @if(session('status'))
                <div class="success-message">{{ session('status') }}</div>
            @endif

            @error('email')
                <div class="input-error">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="input-error">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="inputBox">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                    <span>Email</span>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="inputBox">
                    <input id="password" type="password" name="password" required>
                    <span>New Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>

                <div class="inputBox">
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                    <span>Confirm Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                </div>

                <input type="submit" value="Reset Password">

                <div class="links">
                    <p>Remembered your password? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            if (toggleConfirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPassword.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>

    <style>
        :root {
            --primary-color: #3A6351;
            --secondary-color: #D9EAD3;
            --accent-color: #6AA84F;
            --hover-color: #4CAF50;
            --text-light: #555;
            --bg-main: #f8f9fa;
            --error-color: #ff4757;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Inter', sans-serif; }
        body { display:flex; justify-content:center; align-items:center; min-height:100vh; background: var(--bg-main); }

        .reset-container { width:100%; max-width:500px; padding:20px; }
        .reset-card {
            background:white; padding:40px 30px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .reset-card:hover { transform: translateY(-5px); box-shadow:0 15px 35px rgba(0,0,0,0.25); }

        h2 { text-align:center; margin-bottom:15px; color: var(--primary-color); font-size:28px; font-weight:600; }
        p { text-align:center; margin-bottom:25px; color: var(--text-light); }

        .inputBox { position:relative; margin-bottom:25px; }
        .inputBox input {
            width:100%; padding:15px 20px 15px 45px; font-size:16px; border:2px solid #e0e0e0;
            border-radius:8px; outline:none; transition: all 0.3s ease; background:#f9f9f9;
        }
        .inputBox input:focus { border-color: var(--primary-color); background:white; box-shadow:0 0 0 3px rgba(58,99,81,0.2); }
        .inputBox span {
            position:absolute; left:45px; top:50%; transform:translateY(-50%); color:#888; font-size:16px; pointer-events:none; transition:all 0.3s ease;
        }
        .inputBox input:focus ~ span,
        .inputBox input:not([value=""]) ~ span { top:-10px; left:20px; font-size:12px; background:white; padding:0 8px; color: var(--primary-color); font-weight:500; }
        .inputBox i { position:absolute; left:15px; top:50%; transform:translateY(-50%); color:#888; font-size:18px; transition: color 0.3s ease; }
        .inputBox input:focus ~ i { color: var(--primary-color); }
        .toggle-password { right:15px; cursor:pointer; }

        input[type="submit"] {
            width:100%; padding:15px; border:none; border-radius:8px;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            color:white; font-size:16px; font-weight:600; cursor:pointer; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(106,168,79,0.3);
        }
        input[type="submit"]:hover { background: linear-gradient(135deg, var(--primary-color), var(--hover-color)); transform:translateY(-2px); box-shadow:0 6px 20px rgba(106,168,79,0.4); }

        .links { text-align:center; margin-top:20px; color:var(--text-light); }
        .links a { color: var(--primary-color); text-decoration:none; font-weight:500; transition:color 0.3s ease; }
        .links a:hover { color: var(--accent-color); text-decoration:underline; }

        .input-error { background:#f8d7da; color:#721c24; font-size:13px; margin-top:5px; padding:5px 10px; border-radius:5px; border:1px solid #f5c6cb; display:block; }
        .success-message { background:#d4edda; color:#155724; font-size:14px; margin-bottom:15px; padding:8px 12px; border-radius:5px; border:1px solid #c3e6cb; text-align:center; }
    </style>
</body>

</html>
