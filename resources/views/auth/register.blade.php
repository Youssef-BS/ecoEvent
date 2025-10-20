<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Leaflet for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* Définition des nouvelles couleurs primaires TEAL */
        :root {
            --color-primary: #008080;
            /* Teal - Aqueux */
            --color-secondary: #006666;
            /* Darker Teal - Pour les gradients et le hover */
            --color-light-background: #f0f4f8;
            --color-lighter-background: #d9e2ec;
            --color-white: white;
            --color-error: #ff4757;
        }

        /* General Reset and Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Body Background with Subtle Gradient */
            background: var(--color-light-background);
            background: linear-gradient(135deg, var(--color-light-background) 0%, var(--color-lighter-background) 100%);
        }

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .register {
            background: var(--color-white);
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Enhanced Card Hover Effect */
        .register:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }

        .register h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--color-primary);
            /* Teal */
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
            border-color: var(--color-primary);
            /* Teal */
            background: var(--color-white);
            box-shadow: 0 0 0 3px rgba(0, 128, 128, 0.1);
            /* Teal Shadow */
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

        /* Float label up when input is focused, has text, or is a file input */
        .register .inputBox input:focus~span,
        .register .inputBox input:not([value=""])~span,
        .register .inputBox input[type="file"]:not(:placeholder-shown)~span {
            top: -10px;
            left: 20px;
            font-size: 12px;
            background: var(--color-white);
            padding: 0 8px;
            color: var(--color-primary);
            /* Teal */
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

        .register .inputBox input:focus~i:first-of-type {
            color: var(--color-primary);
            /* Teal */
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
            color: var(--color-primary);
            /* Teal */
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

        .terms input[type="checkbox"] {
            margin-right: 8px;
            accent-color: var(--color-primary);
            /* Teal */
            /* Default size */
            width: 16px;
            height: 16px;
        }

        .terms a {
            color: var(--color-primary);
            /* Teal */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .terms a:hover {
            color: var(--color-secondary);
            /* Darker Teal */
            text-decoration: underline;
        }

        .register input[type="submit"] {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            /* TEAL GRADIENT */
            background: linear-gradient(135deg, var(--color-secondary), var(--color-primary));
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 128, 128, 0.3);
            /* Teal Shadow */
        }

        .register input[type="submit"]:hover {
            /* REVERSED TEAL GRADIENT */
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 128, 128, 0.4);
            /* Darker Teal Shadow */
        }

        .register .links {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .register .links a {
            color: var(--color-primary);
            /* Teal */
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .register .links a:hover {
            color: var(--color-secondary);
            /* Darker Teal */
            text-decoration: underline;
        }

        /* Password Strength Indicator */
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

        /* Map container */
        .map-container {
            height: 300px;
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        .register label strong {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: var(--color-primary);
            /* Teal */
            border-left: 3px solid var(--color-primary);
            /* Teal Accent */
            padding-left: 10px;
        }

        /* --- Error styles (Ensuring prominent RED display) --- */
        .input-error {
            background: #f8d7da;
            color: #721c24;
            font-size: 13px;
            margin-top: 5px;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            animation: fadeIn 0.3s ease-in-out;
            /* Ensure it is displayed as a block below the input */
            display: block;
        }

        /* Ensure input border turns red when it has an error class (mismatch/server) */
        .register .inputBox input.is-error {
            border-color: var(--color-error) !important;
        }

        /* Icon turns red when input has an error */
        .register .inputBox input.is-error~i:first-of-type {
            color: var(--color-error);
        }

        /* General fade-in animation for errors */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-2px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        .password-rules {
            list-style: none;
            padding: 5px 0 0 0;
        }

        .password-rules li {
            font-size: 12px;
            color: red;
            transition: color 0.3s;
        }

        .password-rules li.valid {
            color: green;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register">
            <h2>Create Account</h2>


            <form action="/register" method="POST" enctype="multipart/form-data" id="registerForm">
                @csrf
                <div class="inputBox">
                    <input name="first_name" id="firstName" value="{{ old('first_name') }}">
                    <span>First Name</span>
                    <i class="fas fa-user"></i>
                    @error('first_name')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="inputBox">

                    <input name="last_name" id="lastName" value="{{ old('last_name') }}">
                    <span>Last Name</span>
                    <i class="fas fa-user"></i>
                    @error('last_name')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="inputBox">

                    <input type="email" name="email" id="email" value="{{ old('email') }}">
                    <span>Email Address</span>
                    <i class="fas fa-envelope"></i>
                    @error('email')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="inputBox">
                    <input name="phone" id="phone" value="{{ old('phone') }}">
                    <span>Phone Number</span>
                    <i class="fas fa-phone"></i>
                    @error('phone')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="inputBox">
                    <input type="file" name="image" id="image">
                    <span>Profile Image</span>
                    <i class="fas fa-image"></i>
                    @error('image')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="inputBox">
                    <input name="bio" id="bio" value="{{ old('bio') }}">
                    <span>Bio</span>
                    <i class="fa-regular fa-file-lines"></i>
                    @error('bio')
                    <div class="input-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="inputBox">
                    <input type="password" name="password" id="password">
                    <span>Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                </div>

                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>

                <ul class="password-rules">
                    <li id="rule-uppercase">✅ Starts with uppercase</li>
                    <li id="rule-minlength">✅ Minimum 6 characters</li>
                    <li id="rule-digit">✅ At least one digit</li>
                    <li id="rule-special">✅ At least one special character</li>
                </ul>

                @error('password')
                <div class="input-error">{{ $message }}</div>
                @enderror
                <br>
                <div class="inputBox">

                    <input type="password" name="password_confirmation" id="confirmPassword">
                    <span>Confirm Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                    <div id="passwordMismatchError" class="input-error" style="display: none;">
                        Passwords do not match.
                    </div>
                </div>

                <label><strong>Select your location (Optional):</strong></label>
                <div id="map" class="map-container"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                @error('latitude')
                <div class="input-error">{{ $message }}</div>
                @enderror
                @error('longitude')
                <div class="input-error">{{ $message }}</div>
                @enderror

                <div class="terms">
                    <label>
                        <input type="checkbox" name="terms" id="terms_checkbox" {{ old('terms') ? 'checked' : '' }}>
                        I agree to the <a href="#">Terms & Conditions</a>
                    </label>

                    @error('terms')
                    <div class="input-error">{{ $message }}</div>
                    @enderror

                    <div id="terms-error" class="input-error" style="display: none;">
                        You must accept the terms and conditions!
                    </div>
                </div>


                <input type="submit" value="Register">

                <div class="links">

                    <p>Already have an account? <a href="/login">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            if (password && confirmPassword) {
                confirmPassword.addEventListener('input', function() {
                    confirmPassword.style.borderColor = (password.value !== confirmPassword.value) ? '#ff4757' : '#2a5298';
                });
            }
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (password.value !== confirmPassword.value) {
                        alert('Passwords do not match!');
                        e.preventDefault();
                    }
                    const terms = document.querySelector('input[name="terms"]');
                    const termsErrorDiv = document.getElementById('terms-error');
                    if (terms && !terms.checked) {
                        termsErrorDiv.textContent = 'You must accept the terms and conditions!';
                        termsErrorDiv.style.display = 'block';
                        hasError = true;
                    } else {
                        termsErrorDiv.style.display = 'none';
                    }
                });
            }
        });
    </script> <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([36.8065, 10.1815], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);
        var marker;
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        });
    </script>
    <script>
        const password = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');

        const rules = {
            uppercase: document.getElementById('rule-uppercase'),
            minlength: document.getElementById('rule-minlength'),
            digit: document.getElementById('rule-digit'),
            special: document.getElementById('rule-special'),
        };

        password.addEventListener('input', () => {
            const val = password.value;
            let strength = 0;
            if (/^[A-Z]/.test(val)) {
                rules.uppercase.style.color = 'green';
                strength += 1;
            } else {
                rules.uppercase.style.color = 'red';
            }


            if (val.length >= 6) {
                rules.minlength.style.color = 'green';
                strength += 1;
            } else {
                rules.minlength.style.color = 'red';
            }

            if (/\d/.test(val)) {
                rules.digit.style.color = 'green';
                strength += 1;
            } else {
                rules.digit.style.color = 'red';
            }

            if (/[!@#$%^&*(),.?":{}|<>]/.test(val)) {
                rules.special.style.color = 'green';
                strength += 1;
            } else {
                rules.special.style.color = 'red';
            }

            // Met à jour la barre de force
            const percent = (strength / 4) * 100;
            strengthBar.style.width = percent + '%';
            if (percent <= 25) strengthBar.style.backgroundColor = 'red';
            else if (percent <= 50) strengthBar.style.backgroundColor = 'orange';
            else if (percent <= 75) strengthBar.style.backgroundColor = 'yellow';
            else strengthBar.style.backgroundColor = 'green';
        });

        // Toggle visibility
        const togglePassword = document.getElementById('togglePassword');
        togglePassword.addEventListener('click', () => {
            const type = password.type === 'password' ? 'text' : 'password';
            password.type = type;
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>

    <style>
        .password-strength {
            width: 100%;
            height: 5px;
            background: #ddd;
            margin-top: 5px;
            border-radius: 3px;
        }

        .strength-bar {
            height: 5px;
            width: 0%;
            background: red;
            border-radius: 3px;
            transition: width 0.3s;
        }

        .password-rules {
            list-style: none;
            padding: 5px 0 0 0;
        }

        .password-rules li {
            font-size: 12px;
            color: red;
        }
    </style>
</body>




</html>