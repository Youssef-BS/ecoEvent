<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login">
            <h2>Welcome Back</h2>
            <form action="" method="POST">
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
                    <p>Don't have an account? <a href="/register">Sign Up</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.login-container {
    width: 100%;
    max-width: 500px;
    padding: 20px;
}

.login {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;

}


.login h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #2a5298;
    font-size: 28px;
    font-weight: 600;
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

/* Responsive design */
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
}
</style>
</html>
