<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Charitize</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Josefin+Sans:wght@600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login">
            <div class="login-header">
                <h2>Login</h2>
                <p>Sign in to continue making a difference</p>
            </div>

            {{-- Show status messages (password reset success, etc.) --}}
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="inputBox">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    <span>Email</span>
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="inputBox">
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                    <span>Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>

                <div class="remember-forgot">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <input type="submit" value="Login">

                <div class="links">
                    <p>Don't have an account? <a href="{{ route('register') }}">Join Our Cause</a></p>
                </div>
            </form>
        </div>

        <div class="login-background">
            <div class="background-overlay"></div>
            <div class="background-content">
                <h1>Together for a Better Tomorrow</h1>
                <p>We believe in creating opportunities and empowering communities through education, healthcare, and sustainable development.</p>
                <div class="background-buttons">
                    <a class="btn btn-primary" href="#">Donate Now</a>
                    <a class="btn btn-secondary" href="{{ route('register') }}">Join Us Now</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const password = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

<style>
    :root {
        --primary-color: #3A6351;
        --secondary-color: #D9EAD3;
        --accent-color: #6AA84F;
        --hover-color: #4CAF50;
        --text-light: #555;
        --bg-main: #f8f9fa;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: var(--bg-main);
    }

    .login-container {
        width: 100%;
        max-width: 1200px;
        height: 700px;
        display: flex;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .login {
        background: white;
        padding: 50px 40px;
        width: 45%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .login h2 {
        color: var(--primary-color);
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .login-header p {
        color: #6c757d;
        font-size: 16px;
    }

    .inputBox {
        position: relative;
        margin-bottom: 25px;
    }

    .inputBox input {
        width: 100%;
        padding: 15px 20px 15px 45px;
        font-size: 16px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        outline: none;
        transition: all 0.3s ease;
        background: #f9f9f9;
    }

    .inputBox input:focus {
        border-color: var(--primary-color);
        background: white;
        box-shadow: 0 0 0 3px rgba(58, 99, 81, 0.2);
    }

    .inputBox span {
        position: absolute;
        left: 45px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 16px;
        pointer-events: none;
        transition: all 0.3s ease;
    }

    .inputBox input:focus~span,
    .inputBox input:valid~span {
        top: -10px;
        left: 20px;
        font-size: 12px;
        background: white;
        padding: 0 8px;
        color: var(--primary-color);
        font-weight: 500;
    }

    .inputBox i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    .inputBox input:focus~i {
        color: var(--primary-color);
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .toggle-password:hover {
        color: var(--primary-color);
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .remember-forgot label {
        display: flex;
        align-items: center;
        color: var(--text-light);
        cursor: pointer;
    }

    .remember-forgot input {
        margin-right: 5px;
        accent-color: var(--accent-color);
    }

    .remember-forgot a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .remember-forgot a:hover {
        color: var(--accent-color);
        text-decoration: underline;
    }

    input[type="submit"] {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(106, 168, 79, 0.3);
    }

    input[type="submit"]:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--hover-color));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(106, 168, 79, 0.4);
    }

    .links {
        text-align: center;
        margin-top: 20px;
        color: var(--text-light);
    }

    .links a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .links a:hover {
        color: var(--accent-color);
        text-decoration: underline;
    }

    .login-background {
        width: 55%;
        background: linear-gradient(rgba(58, 99, 81, 0.8), rgba(35, 70, 57, 0.9)),
            url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1470&q=80');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        color: white;
        padding: 40px;
    }

    .background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
    }

    .background-content {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 600px;
    }

    .background-content h1 {
        font-family: 'Josefin Sans', sans-serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .background-content p {
        font-size: 18px;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .background-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-primary {
        background: white;
        color: var(--primary-color);
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background: transparent;
        color: white;
        border: 2px solid white;
    }

    .btn-secondary:hover {
        background: var(--accent-color);
        color: white;
        border-color: var(--accent-color);
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .login-container {
            flex-direction: column;
            height: auto;
            max-width: 500px;
        }

        .login,
        .login-background {
            width: 100%;
        }

        .login-background {
            padding: 40px 20px;
            min-height: 400px;
        }

        .background-content h1 {
            font-size: 32px;
        }

        .background-content p {
            font-size: 16px;
        }
    }
</style>

</html>
