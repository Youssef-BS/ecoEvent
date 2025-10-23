<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
        :root {
            --color-primary: #008080;
            --color-secondary: #006666;
            --color-light-background: #f0f4f8;
            --color-lighter-background: #d9e2ec;
            --color-white: #fff;
            --color-error: #ff4757;
        }

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

        .register:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }

        .register h2 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--color-primary);
            font-size: 28px;
            font-weight: 600;
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
            background: #f9f9f9;
            transition: all 0.3s ease;
        }

        .inputBox input:focus {
            border-color: var(--color-primary);
            background: var(--color-white);
            box-shadow: 0 0 0 3px rgba(0, 128, 128, 0.1);
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

        .inputBox input:focus ~ span,
        .inputBox input:not([value=""]) ~ span,
        .inputBox input[type="file"]:not(:placeholder-shown) ~ span {
            top: -10px;
            left: 20px;
            font-size: 12px;
            background: var(--color-white);
            padding: 0 8px;
            color: var(--color-primary);
            font-weight: 500;
        }

        .inputBox i:first-of-type {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .inputBox input:focus ~ i:first-of-type {
            color: var(--color-primary);
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
            width: 16px;
            height: 16px;
        }

        .terms a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .terms a:hover {
            color: var(--color-secondary);
            text-decoration: underline;
        }

        .register input[type="submit"] {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--color-secondary), var(--color-primary));
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 128, 128, 0.3);
        }

        .register input[type="submit"]:hover {
            background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 128, 128, 0.4);
        }

        .links {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .links a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .links a:hover {
            color: var(--color-secondary);
            text-decoration: underline;
        }

        .map-container {
            height: 300px;
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        .input-error {
            background: #f8d7da;
            color: #721c24;
            font-size: 13px;
            margin-top: 5px;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            display: block;
        }

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
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register">
            <h2>Create Account</h2>

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="registerForm">
                @csrf

                <div class="inputBox">
                    <input name="first_name" value="{{ old('first_name') }}">
                    <span>First Name</span>
                    <i class="fas fa-user"></i>
                    @error('first_name') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div class="inputBox">
                    <input name="last_name" value="{{ old('last_name') }}">
                    <span>Last Name</span>
                    <i class="fas fa-user"></i>
                    @error('last_name') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div class="inputBox">
                    <input type="email" name="email" value="{{ old('email') }}">
                    <span>Email Address</span>
                    <i class="fas fa-envelope"></i>
                    @error('email') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div class="inputBox">
                    <input name="phone" value="{{ old('phone') }}">
                    <span>Phone Number</span>
                    <i class="fas fa-phone"></i>
                    @error('phone') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div class="inputBox">
                    <input type="file" name="image">
                    <span>Profile Image</span>
                    <i class="fas fa-image"></i>
                    @error('image') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div class="inputBox">
                    <input name="bio" value="{{ old('bio') }}">
                    <span>Bio</span>
                    <i class="fa-regular fa-file-lines"></i>
                    @error('bio') <div class="input-error">{{ $message }}</div> @enderror
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

                @error('password') <div class="input-error">{{ $message }}</div> @enderror

                <div class="inputBox">
                    <input type="password" name="password_confirmation" id="confirmPassword">
                    <span>Confirm Password</span>
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                </div>

                <label><strong>Select your location (Optional):</strong></label>
                <div id="map" class="map-container"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                @error('latitude') <div class="input-error">{{ $message }}</div> @enderror
                @error('longitude') <div class="input-error">{{ $message }}</div> @enderror

                <div class="terms">
                    <label>
                        <input type="checkbox" name="terms" id="terms_checkbox" {{ old('terms') ? 'checked' : '' }}>
                        I agree to the <a href="#">Terms & Conditions</a>
                    </label>
                    @error('terms') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <input type="submit" value="Register">

                <div class="links">
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([36.8065, 10.1815], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        let marker;
        map.on('click', e => {
            const { lat, lng } = e.latlng;
            if (marker) map.removeLayer(marker);
            marker = L.marker([lat, lng]).addTo(map);
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
        });
    </script>

    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const strengthBar = document.getElementById('strengthBar');

        togglePassword.addEventListener('click', () => {
            password.type = password.type === 'password' ? 'text' : 'password';
            togglePassword.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', () => {
            confirmPassword.type = confirmPassword.type === 'password' ? 'text' : 'password';
            toggleConfirmPassword.classList.toggle('fa-eye-slash');
        });

        password.addEventListener('input', () => {
            const val = password.value;
            let strength = 0;
            if (/^[A-Z]/.test(val)) strength++;
            if (val.length >= 6) strength++;
            if (/\d/.test(val)) strength++;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(val)) strength++;
            const percent = (strength / 4) * 100;
            strengthBar.style.width = percent + '%';
            strengthBar.style.backgroundColor =
                percent <= 25 ? 'red' :
                percent <= 50 ? 'orange' :
                percent <= 75 ? 'yellow' : 'green';
        });
    </script>
</body>
</html>
