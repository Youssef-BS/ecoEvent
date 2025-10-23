@extends('layouts.app')

@section('content')
    <div class="profile-wrapper">
        <div class="container py-5">
            <!-- Page Header with Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </nav>

            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold gradient-text mb-2">My Profile</h1>
                <p class="text-muted fs-5">Manage your personal information, security, and preferences</p>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fs-4 me-3"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fs-4 me-3"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-circle fs-4 me-3 mt-1"></i>
                        <ul class="mb-0 ps-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Profile Sidebar -->
                <div class="col-lg-4">
                    <!-- Profile Card -->
                    <div class="card profile-card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="profile-header"></div>
                        <div class="card-body text-center p-4 position-relative">
                            <!-- Profile Image -->
                            <div class="profile-image-wrapper mb-3">
                                @if($user->has_profile_image)
                                    <img src="{{ $user->profile_image_url }}"
                                         alt="{{ $user->first_name }}"
                                         class="profile-image"
                                         id="currentProfileImage"
                                         onerror="handleSidebarImageError(this)">
                                    <div class="profile-image profile-initials" id="sidebarInitials" style="display: none;">
                                    <span class="initials-text">
                                        {{ $user->initials }}
                                    </span>
                                    </div>
                                @else
                                    <div class="profile-image profile-initials" id="currentProfileImage">
                                    <span class="initials-text">
                                        {{ $user->initials }}
                                    </span>
                                    </div>
                                @endif
                                <div class="profile-status-badge">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>

                            <h4 class="fw-bold mb-2">{{ $user->first_name }} {{ $user->last_name }}</h4>

                            <div class="profile-info mb-3">
                                <p class="text-muted mb-2 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    <span class="text-truncate">{{ $user->email }}</span>
                                </p>
                                @if($user->phone)
                                    <p class="text-muted mb-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-phone me-2 text-primary"></i>{{ $user->phone }}
                                    </p>
                                @endif
                                @if($user->location)
                                    <p class="text-muted mb-0 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $user->location }}
                                    </p>
                                @endif
                            </div>

                            <span class="badge bg-gradient-primary fs-6 mb-3 px-3 py-2">
                            <i class="fas fa-user-tag me-1"></i>{{ ucfirst($user->role ?? 'Member') }}
                        </span>

                            <div class="member-since">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <small>Member since {{ $user->created_at->format('F Y') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary mb-4">
                                <i class="fas fa-chart-line me-2"></i>Activity Overview
                            </h5>
                            <div class="stat-item">
                                <div class="stat-icon bg-danger-subtle">
                                    <i class="fas fa-heart text-danger"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Donations</div>
                                    <div class="stat-value">{{ $user->donations()->count() }}</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon bg-info-subtle">
                                    <i class="fas fa-file-alt text-info"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Posts Created</div>
                                    <div class="stat-value">{{ $user->posts()->count() }}</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon bg-success-subtle">
                                    <i class="fas fa-calendar text-success"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Events</div>
                                    <div class="stat-value">{{ $user->events()->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="col-lg-8">
                    <!-- Edit Profile -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class="fas fa-user-edit me-2"></i>Personal Information
                            </h5>
                            <small class="text-muted">Update your personal details and profile picture</small>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                                @csrf
                                @method('PUT')

                                <!-- Profile Image Upload -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-image me-2 text-primary"></i>Profile Picture
                                    </label>
                                    <div class="image-upload-wrapper">
                                        <div class="image-preview" id="imagePreviewContainer" onclick="document.getElementById('imageUpload').click()">
                                            @if($user->has_profile_image)
                                                <img src="{{ $user->profile_image_url }}"
                                                     id="imagePreview"
                                                     alt="Profile Preview"
                                                     onerror="handleImageError(this)">
                                            @else
                                                <div class="preview-placeholder" id="imagePreview">
                                                    <i class="fas fa-camera"></i>
                                                    <p>Click to upload</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file"
                                               class="form-control d-none @error('image') is-invalid @enderror"
                                               name="image"
                                               id="imageUpload"
                                               accept="image/*">
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="document.getElementById('imageUpload').click()">
                                            <i class="fas fa-upload me-2"></i>Choose Image
                                        </button>
                                        @if($user->has_profile_image)
                                            <button type="button" class="btn btn-outline-danger btn-sm mt-2 ms-2" id="removeImageBtn">
                                                <i class="fas fa-times me-2"></i>Remove Image
                                            </button>
                                            <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                                        @endif
                                        @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-info-circle me-1"></i>Accepted: JPG, PNG, GIF — Max 2MB
                                        </small>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user me-2 text-primary"></i>First Name
                                        </label>
                                        <input type="text"
                                               class="form-control custom-input @error('first_name') is-invalid @enderror"
                                               name="first_name"
                                               value="{{ old('first_name', $user->first_name) }}"
                                               required>
                                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-user me-2 text-primary"></i>Last Name
                                        </label>
                                        <input type="text"
                                               class="form-control custom-input @error('last_name') is-invalid @enderror"
                                               name="last_name"
                                               value="{{ old('last_name', $user->last_name) }}"
                                               required>
                                        @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                                        </label>
                                        <input type="email"
                                               class="form-control custom-input @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email', $user->email) }}"
                                               required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-phone me-2 text-primary"></i>Phone Number
                                        </label>
                                        <input type="tel"
                                               class="form-control custom-input @error('phone') is-invalid @enderror"
                                               name="phone"
                                               value="{{ old('phone', $user->phone) }}"
                                               placeholder="+216 12 345 678">
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Location -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>Location
                                        </label>
                                        <input type="text"
                                               class="form-control custom-input @error('location') is-invalid @enderror"
                                               name="location"
                                               value="{{ old('location', $user->location) }}"
                                               placeholder="City, Country">
                                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Bio -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-info-circle me-2 text-primary"></i>Bio
                                        </label>
                                        <textarea class="form-control custom-input @error('bio') is-invalid @enderror"
                                                  name="bio"
                                                  rows="4"
                                                  placeholder="Tell us about yourself..."
                                                  maxlength="500">{{ old('bio', $user->bio) }}</textarea>
                                        <small class="text-muted">
                                            <span id="bioCount">{{ strlen($user->bio ?? '') }}</span>/500 characters
                                        </small>
                                        @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('home') }}" class="btn btn-light px-4">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4" id="saveProfileBtn">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-warning">
                                <i class="fas fa-lock me-2"></i>Security Settings
                            </h5>
                            <small class="text-muted">Keep your account secure with a strong password</small>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('profile.password') }}" method="POST" id="passwordForm">
                                @csrf
                                @method('PUT')

                                <!-- Current Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-key me-2"></i>Current Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control custom-input @error('current_password') is-invalid @enderror"
                                               name="current_password"
                                               id="currentPassword"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                            <i class="fas fa-eye" id="currentPasswordIcon"></i>
                                        </button>
                                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-lock me-2"></i>New Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control custom-input @error('new_password') is-invalid @enderror"
                                               name="new_password"
                                               id="newPassword"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                                        </button>
                                        @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Password Strength Indicator -->
                                    <div class="password-strength mt-2" id="passwordStrengthContainer" style="display: none;">
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar" id="passwordStrengthBar" role="progressbar"></div>
                                        </div>
                                        <small class="text-muted mt-1 d-block" id="passwordStrengthText"></small>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-check-circle me-2"></i>Confirm New Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                               class="form-control custom-input"
                                               name="new_password_confirmation"
                                               id="confirmPassword"
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted mt-1 d-block" id="passwordMatchText"></small>
                                </div>

                                <!-- Password Requirements -->
                                <div class="alert alert-info border-0 mb-4">
                                    <h6 class="alert-heading mb-2">
                                        <i class="fas fa-info-circle me-2"></i>Password Requirements
                                    </h6>
                                    <ul class="mb-0 ps-4 small">
                                        <li>At least 8 characters long</li>
                                        <li>Contains uppercase and lowercase letters</li>
                                        <li>Contains at least one number</li>
                                        <li>Contains at least one special character</li>
                                    </ul>
                                </div>

                                <button type="submit" class="btn btn-warning px-4" id="updatePasswordBtn">
                                    <i class="fas fa-shield-alt me-2"></i>Update Password
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="card border-danger shadow-sm">
                        <div class="card-header bg-danger bg-opacity-10 border-danger py-3">
                            <h5 class="mb-0 fw-bold text-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                            </h5>
                            <small class="text-muted">Irreversible actions</small>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-3">
                                Once you delete your account, there is no going back. All your data will be permanently removed.
                            </p>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                <i class="fas fa-trash-alt me-2"></i>Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-danger text-white">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-3">Are you absolutely sure?</h6>
                    <p class="text-muted mb-3">
                        This action cannot be undone. This will permanently delete your account and remove all your data from our servers.
                    </p>
                    <div class="alert alert-warning border-0 mb-3">
                        <small>
                            <i class="fas fa-info-circle me-2"></i>
                            Type <strong>DELETE</strong> to confirm
                        </small>
                    </div>
                    <input type="text" class="form-control mb-3" id="deleteConfirmation" placeholder="Type DELETE to confirm">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('profile.delete') }}" method="POST" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="confirmation" id="confirmationInput">
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                            <i class="fas fa-trash me-2"></i>Delete My Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --primary-light: #e7f1ff;
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #198754;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-600: #6c757d;
            --shadow: 0 2px 8px rgba(0,0,0,0.08);
            --shadow-lg: 0 4px 20px rgba(0,0,0,0.12);
        }

        .profile-wrapper {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary), #20c997);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
        }

        /* Custom Alerts */
        .custom-alert {
            border: none;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Cards */
        .card {
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg) !important;
        }

        .card-header {
            border-bottom: 2px solid var(--gray-200);
        }

        /* Profile Card */
        .profile-card {
            overflow: visible;
        }

        .profile-header {
            height: 80px;
            background: linear-gradient(135deg, var(--primary), #20c997);
        }

        .profile-image-wrapper {
            margin-top: -60px;
            position: relative;
            display: inline-block;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: var(--shadow-lg);
            object-fit: cover;
            background: linear-gradient(135deg, var(--primary), #20c997);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-initials {
            background: linear-gradient(135deg, var(--primary), #20c997);
        }

        .initials-text {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .profile-status-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--success);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
            box-shadow: var(--shadow);
        }

        .member-since {
            color: var(--gray-600);
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            background: var(--gray-100);
            border-radius: 0.5rem;
            display: inline-block;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary), #20c997);
            border: none;
        }

        /* Stats */
        .stat-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin-bottom: 0.75rem;
            background: var(--gray-100);
            border-radius: 0.75rem;
            transition: all 0.3s;
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }

        .stat-item:hover {
            background: white;
            box-shadow: var(--shadow);
            transform: translateX(5px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
        }

        /* Image Upload */
        .image-upload-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-preview {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            border: 3px dashed var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .image-preview:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-placeholder {
            text-align: center;
            color: var(--gray-600);
        }

        .preview-placeholder i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
            color: var(--primary);
        }

        .preview-placeholder p {
            margin: 0;
            font-size: 0.875rem;
        }

        /* Custom Inputs */
        .custom-input {
            border: 2px solid var(--gray-200);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .custom-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
            outline: none;
        }

        .custom-input:hover {
            border-color: var(--primary-dark);
        }

        /* Buttons */
        .btn {
            border-radius: 0.75rem;
            padding: 0.625rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        }

        .btn-light {
            background: var(--gray-100);
            border-color: var(--gray-200);
        }

        .btn-light:hover {
            background: var(--gray-200);
        }

        /* Password Strength */
        .password-strength {
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .progress {
            background: var(--gray-200);
            border-radius: 10px;
        }

        .progress-bar {
            transition: all 0.3s;
        }

        /* Input Groups */
        .input-group .btn-outline-secondary {
            border: 2px solid var(--gray-200);
            border-left: none;
        }

        .input-group .custom-input:focus + .btn-outline-secondary {
            border-color: var(--primary);
        }

        /* Modal */
        .modal-content {
            border-radius: 1rem;
        }

        .modal-header {
            border-radius: 1rem 1rem 0 0;
        }

        /* Loading State */
        .btn.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn.loading::after {
            content: "";
            display: inline-block;
            width: 16px;
            height: 16px;
            margin-left: 8px;
            border: 2px solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .profile-card {
                position: static !important;
            }

            .sticky-top {
                position: static !important;
            }
        }

        @media (max-width: 768px) {
            .profile-image {
                width: 100px;
                height: 100px;
            }

            .initials-text {
                font-size: 2rem;
            }

            .stat-item {
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image Upload Preview
            const imageUpload = document.getElementById('imageUpload');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const removeImageBtn = document.getElementById('removeImageBtn');
            const removeImageInput = document.getElementById('removeImageInput');

            if (imageUpload) {
                imageUpload.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file size (2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('File size must be less than 2MB');
                            this.value = '';
                            return;
                        }

                        // Validate file type
                        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (!validTypes.includes(file.type)) {
                            alert('Please upload a valid image (JPG, PNG, or GIF)');
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            let imagePreview = document.getElementById('imagePreview');

                            if (imagePreview && imagePreview.tagName === 'IMG') {
                                imagePreview.src = e.target.result;
                            } else {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.id = 'imagePreview';
                                img.alt = 'Profile Preview';
                                imagePreviewContainer.innerHTML = '';
                                imagePreviewContainer.appendChild(img);
                            }

                            // Show remove button
                            if (removeImageBtn) {
                                removeImageBtn.style.display = 'inline-block';
                            }
                            if (removeImageInput) {
                                removeImageInput.value = '0';
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Remove image functionality
            if (removeImageBtn && removeImageInput) {
                removeImageBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent triggering the container click

                    // Reset file input
                    if (imageUpload) {
                        imageUpload.value = '';
                    }

                    // Show placeholder
                    const placeholder = `
                <div class="preview-placeholder" id="imagePreview">
                    <i class="fas fa-camera"></i>
                    <p>Click to upload</p>
                </div>
            `;
                    imagePreviewContainer.innerHTML = placeholder;

                    // Set remove flag
                    removeImageInput.value = '1';
                    removeImageBtn.style.display = 'none';

                    // Update sidebar to show initials
                    const sidebarImage = document.getElementById('currentProfileImage');
                    const sidebarInitials = document.getElementById('sidebarInitials');
                    if (sidebarImage && sidebarImage.tagName === 'IMG') {
                        sidebarImage.style.display = 'none';
                        if (sidebarInitials) {
                            sidebarInitials.style.display = 'flex';
                        }
                    }
                });
            }

            // Bio Character Counter
            const bioTextarea = document.querySelector('textarea[name="bio"]');
            const bioCount = document.getElementById('bioCount');

            if (bioTextarea && bioCount) {
                bioTextarea.addEventListener('input', function() {
                    bioCount.textContent = this.value.length;

                    if (this.value.length > 450) {
                        bioCount.style.color = 'var(--warning)';
                    } else if (this.value.length >= 500) {
                        bioCount.style.color = 'var(--danger)';
                    } else {
                        bioCount.style.color = 'var(--gray-600)';
                    }
                });

                // Initialize count
                bioCount.textContent = bioTextarea.value.length;
            }

            // Password Strength Checker
            const newPasswordInput = document.getElementById('newPassword');
            const strengthContainer = document.getElementById('passwordStrengthContainer');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrengthText');

            if (newPasswordInput) {
                newPasswordInput.addEventListener('input', function() {
                    const password = this.value;

                    if (password.length === 0) {
                        strengthContainer.style.display = 'none';
                        return;
                    }

                    strengthContainer.style.display = 'block';

                    let strength = 0;
                    const checks = {
                        length: password.length >= 8,
                        uppercase: /[A-Z]/.test(password),
                        lowercase: /[a-z]/.test(password),
                        number: /\d/.test(password),
                        special: /[^a-zA-Z\d]/.test(password)
                    };

                    // Calculate strength
                    if (checks.length) strength++;
                    if (checks.uppercase && checks.lowercase) strength++;
                    if (checks.number) strength++;
                    if (checks.special) strength++;

                    const colors = ['bg-danger', 'bg-warning', 'bg-info', 'bg-success'];
                    const texts = ['Weak - Add more characters', 'Fair - Add numbers or symbols', 'Good - Almost there!', 'Strong - Great password!'];
                    const widths = [25, 50, 75, 100];

                    strengthBar.className = `progress-bar ${colors[strength]}`;
                    strengthBar.style.width = widths[strength] + '%';
                    strengthText.textContent = texts[strength];
                    strengthText.className = `text-muted mt-1 d-block text-${colors[strength].replace('bg-', '')}`;
                });
            }

            // Password Match Checker
            const confirmPasswordInput = document.getElementById('confirmPassword');
            const passwordMatchText = document.getElementById('passwordMatchText');

            if (confirmPasswordInput && newPasswordInput) {
                function checkPasswordMatch() {
                    if (confirmPasswordInput.value.length === 0) {
                        passwordMatchText.textContent = '';
                        return;
                    }

                    if (newPasswordInput.value === confirmPasswordInput.value) {
                        passwordMatchText.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i>Passwords match';
                        passwordMatchText.className = 'text-success mt-1 d-block';
                    } else {
                        passwordMatchText.innerHTML = '<i class="fas fa-times-circle text-danger me-1"></i>Passwords do not match';
                        passwordMatchText.className = 'text-danger mt-1 d-block';
                    }
                }

                confirmPasswordInput.addEventListener('input', checkPasswordMatch);
                newPasswordInput.addEventListener('input', checkPasswordMatch);
            }

            // Form Submission Loading State
            const profileForm = document.getElementById('profileForm');
            const saveProfileBtn = document.getElementById('saveProfileBtn');

            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.classList.add('was-validated');
                        return;
                    }

                    saveProfileBtn.disabled = true;
                    saveProfileBtn.classList.add('loading');
                    saveProfileBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                });
            }

            const passwordForm = document.getElementById('passwordForm');
            const updatePasswordBtn = document.getElementById('updatePasswordBtn');

            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    if (!this.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        this.classList.add('was-validated');
                        return;
                    }

                    // Check if passwords match
                    if (newPasswordInput.value !== confirmPasswordInput.value) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        return;
                    }

                    updatePasswordBtn.disabled = true;
                    updatePasswordBtn.classList.add('loading');
                    updatePasswordBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                });
            }

            // Delete Account Modal
            const deleteConfirmation = document.getElementById('deleteConfirmation');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const confirmationInput = document.getElementById('confirmationInput');

            if (deleteConfirmation && confirmDeleteBtn && confirmationInput) {
                deleteConfirmation.addEventListener('input', function() {
                    if (this.value === 'DELETE') {
                        confirmDeleteBtn.disabled = false;
                        confirmationInput.value = 'DELETE';
                    } else {
                        confirmDeleteBtn.disabled = true;
                        confirmationInput.value = '';
                    }
                });

                confirmDeleteBtn.addEventListener('click', function(e) {
                    if (deleteConfirmation.value !== 'DELETE') {
                        e.preventDefault();
                        alert('Please type DELETE to confirm account deletion.');
                        return;
                    }

                    this.disabled = true;
                    this.classList.add('loading');
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Deleting...';
                });
            }

            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Smooth scroll for form errors
            const invalidInputs = document.querySelectorAll('.is-invalid');
            if (invalidInputs.length > 0) {
                invalidInputs[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                invalidInputs[0].focus();
            }
        });

        // Toggle Password Visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Handle Image Errors
        function handleImageError(img) {
            const container = img.parentElement;
            const placeholder = `
        <div class="preview-placeholder" id="imagePreview">
            <i class="fas fa-camera"></i>
            <p>Click to upload</p>
        </div>
    `;
            container.innerHTML = placeholder;
        }

        function handleSidebarImageError(img) {
            img.style.display = 'none';
            const sidebarInitials = document.getElementById('sidebarInitials');
            if (sidebarInitials) {
                sidebarInitials.style.display = 'flex';
            }
        }

        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endsection
