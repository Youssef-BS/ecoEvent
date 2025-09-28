<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="register-container">
        <div class="register">
            <h2>Create Account</h2>
            <form action="/register" method="POST">
                @csrf
                <div class="inputBox">
                    <input type="text" name="name" required="required">
                    <span>Full Name</span>
                    <i class="fas fa-user"></i>
                </div>
                <div class="inputBox">
                    <input type="email" name="email" required="required">
                    <span>Email Address</span>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="inputBox">
                    <input type="tel" name="phone" required="required">
                    <span>Phone Number</span>
                    <i class="fas fa-phone"></i>
                </div>
                <div class="inputBox">
                    <input type="password" name="password" required="required" id="password">
                    <span>Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>
                <div class="inputBox">
                    <input type="password" name="password_confirmation" required="required" id="confirmPassword">
                    <span>Confirm Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                </div>
                <div class="terms">
                    <label>
                        <input type="checkbox" name="terms" required>
                        I agree to the <a href="#">Terms & Conditions</a>
                    </label>
                </div>
                <input type="submit" value="Register">
                <div class="links">
                    <p>Already have an account? <a href="/">Login</a></p>
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

.register-container {
    width: 100%;
    max-width: 500px;
    padding: 20px;
}

.register {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}


.register h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #2a5298;
    font-size: 28px;
    font-weight: 600;
}

.register .inputBox {
    position: relative;
    margin-bottom: 25px;
}

.register .inputBox input {
    width: 100%;
    padding: 15px 20px 15px 45px;
    font-size: 16px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease;
    background: #f9f9f9;
}

.register .inputBox input:focus {
    border-color: #2a5298;
    background: white;
    box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.1);
}

.register .inputBox span {
    position: absolute;
    left: 45px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 16px;
    pointer-events: none;
    transition: all 0.3s ease;
}

.register .inputBox input:focus ~ span,
.register .inputBox input:valid ~ span {
    top: -10px;
    left: 20px;
    font-size: 12px;
    background: white;
    padding: 0 8px;
    color: #2a5298;
    font-weight: 500;
}

.register .inputBox i:first-of-type {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #888;
    font-size: 18px;
    transition: color 0.3s ease;
}

.register .inputBox input:focus ~ i:first-of-type {
    color: #2a5298;
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
    color: #2a5298;
}

.terms {
    margin-bottom: 25px;
    font-size: 14px;
}

.terms label {
    display: flex;
    align-items: center;
    color: #555;
    cursor: pointer;
}

.terms input {
    margin-right: 8px;
    accent-color: #2a5298;
}

.terms a {
    color: #2a5298;
    text-decoration: none;
    transition: color 0.3s ease;
}

.terms a:hover {
    color: #1e3c72;
    text-decoration: underline;
}

.register input[type="submit"] {
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

.register input[type="submit"]:hover {
    background: linear-gradient(135deg, #2a5298, #1e3c72);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(42, 82, 152, 0.4);
}

.register .links {
    text-align: center;
    margin-top: 20px;
    color: #555;
}

.register .links a {
    color: #2a5298;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.register .links a:hover {
    color: #1e3c72;
    text-decoration: underline;
}

/* Password strength indicator */
.password-strength {
    margin-top: 5px;
    height: 5px;
    border-radius: 5px;
    background: #f0f0f0;
    overflow: hidden;
}

.strength-bar {
    height: 100%;
    width: 0;
    transition: width 0.3s ease, background 0.3s ease;
}

/* Responsive design */
@media (max-width: 480px) {
    .register-container {
        padding: 10px;
    }

    .register {
        padding: 30px 20px;
    }

    .terms label {
        font-size: 13px;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');

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

    // Password confirmation validation
    if (password && confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.style.borderColor = '#ff4757';
            } else {
                confirmPassword.style.borderColor = '#2a5298';
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let valid = true;

            // Check if passwords match
            if (password.value !== confirmPassword.value) {
                valid = false;
                alert('Passwords do not match!');
                e.preventDefault();
            }

            // Check if terms are accepted
            const terms = document.querySelector('input[name="terms"]');
            if (terms && !terms.checked) {
                valid = false;
                alert('You must accept the terms and conditions!');
                e.preventDefault();
            }

            return valid;
        });
    }
});
</script>
</html>
