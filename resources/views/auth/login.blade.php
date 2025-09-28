<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Charitize</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login">
            <div class="login-header">
                <h1 class="logo">Charitize</h1>
                <h2>Welcome Back</h2>
                <p>Sign in to continue making a difference</p>
            </div>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="inputBox">
                    <input type="text" name="email" required="required">
                    <span>Email</span>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="inputBox">
                    <input type="password" name="password" required="required">
                    <span>Password</span>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox">
                        Remember me
                    </label>
                    <a href="#">Forgot Password?</a>
                </div>
                <input type="submit" value="Login">
                <div class="links">
                    <p>Don't have an account? <a href="/register">Join Our Cause</a></p>
                </div>
            </form>
        </div>
        <div class="login-background">
            <div class="background-overlay"></div>
            <div class="background-content">
                <h1>Together for a Better Tomorrow</h1>
                <p>We believe in creating opportunities and empowering communities through education, healthcare, and sustainable development.</p>
                <div class="background-buttons">
                    <a class="btn btn-primary" href="#!">Donate Now</a>
                    <a class="btn btn-secondary" href="#!">Join Us Now</a>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Open Sans', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #f8f9fa;
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

.logo {
    font-family: 'Josefin Sans', sans-serif;
    font-weight: 700;
    color: #2a5298;
    font-size: 36px;
    margin-bottom: 15px;
}

.login h2 {
    color: #2a5298;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 10px;
}

.login-header p {
    color: #6c757d;
    font-size: 16px;
}

.login .inputBox {
    position: relative;
    margin-bottom: 25px;
}

.login .inputBox input {
    width: 100%;
    padding: 15px 20px 15px 45px;
    font-size: 16px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease;
    background: #f9f9f9;
}

.login .inputBox input:focus {
    border-color: #2a5298;
    background: white;
    box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
}

.login .inputBox span {
    position: absolute;
    left: 45px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 16px;
    pointer-events: none;
    transition: all 0.3s ease;
}

.login .inputBox input:focus ~ span,
.login .inputBox input:valid ~ span {
    top: -10px;
    left: 20px;
    font-size: 12px;
    background: white;
    padding: 0 8px;
    color: #2a5298;
    font-weight: 500;
}

.login .inputBox i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 18px;
    transition: color 0.3s ease;
}

.login .inputBox input:focus ~ i {
    color: #2a5298;
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
    color: #555;
    cursor: pointer;
}

.remember-forgot input {
    margin-right: 5px;
    accent-color: #2a5298;
}

.remember-forgot a {
    color: #2a5298;
    text-decoration: none;
    transition: color 0.3s ease;
}

.remember-forgot a:hover {
    color: #1e3c72;
    text-decoration: underline;
}

.login input[type="submit"] {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(42, 82, 152, 0.3);
}

.login input[type="submit"]:hover {
    background: linear-gradient(135deg, #2a5298, #1e3c72);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(42, 82, 152, 0.4);
}

.login .links {
    text-align: center;
    margin-top: 20px;
    color: #555;
}

.login .links a {
    color: #2a5298;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.login .links a:hover {
    color: #1e3c72;
    text-decoration: underline;
}

/* Background Section */
.login-background {
    width: 55%;
    background: linear-gradient(rgba(42, 82, 152, 0.8), rgba(30, 60, 114, 0.9)), url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
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
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-primary {
    background: white;
    color: #2a5298;
}

.btn-primary:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid white;
}

.btn-secondary:hover {
    background: white;
    color: #2a5298;
    transform: translateY(-2px);
}

/* Responsive design */
@media (max-width: 992px) {
    .login-container {
        flex-direction: column;
        height: auto;
        max-width: 500px;
    }

    .login, .login-background {
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

@media (max-width: 480px) {
    .login-container {
        padding: 10px;
    }

    .login {
        padding: 30px 20px;
    }

    .remember-forgot {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .background-buttons {
        flex-direction: column;
        align-items: center;
    }

    .btn {
        width: 100%;
        max-width: 200px;
    }
}
</style>
</html>
