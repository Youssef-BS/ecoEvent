<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($sponsor) ? 'Edit Sponsor' : 'Add Sponsor' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #cbdf72;
            --bs-primary-rgb: 203, 223, 114;
            --bs-secondary: #12372A;
            --bs-secondary-rgb: 18, 55, 42;
        }

        .btn-primary,
        .card-header.bg-primary {
            color: var(--bs-secondary) !important;
            border-color: var(--bs-primary);
        }

        .btn-primary:hover {
            color: #fff !important;
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }

        .file-upload-area {
            border: 2px dashed var(--bs-primary);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-upload-area:hover {
            background-color: #e2ecc1;
        }

        .logo-preview img {
            max-height: 80px;
            border-radius: 6px;
        }

        .file-upload-area .fa-cloud-upload-alt {
            color: var(--bs-primary) !important;
        }

        .btn-outline-secondary {
            color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }

        .btn-outline-secondary:hover {
            color: #fff;
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }

        /* Error message style */
        .text-danger {
            font-size: 0.875em;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h2 class="mb-0">{{ isset($sponsor) ? 'Edit Sponsor' : 'Add Sponsor' }}</h2>
            </div>

            <div class="card-body p-4">

                <form action="{{ isset($sponsor) ? route('sponsors.update', $sponsor->id) : route('sponsors.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($sponsor)) @method('PUT') @endif

                    {{-- Name --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                            value="{{ old('name', $sponsor->name ?? '') }}">
                        <label for="name">Name</label>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contribution --}}
                    <div class="form-floating mb-3">
                        <select name="contribution" id="contribution" class="form-select">
                            @foreach (['financial','material','logistical'] as $type)
                            <option value="{{ $type }}"
                                {{ old('contribution', $sponsor->contribution ?? '') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                        <label for="contribution">Contribution</label>
                        @error('contribution')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                            value="{{ old('email', $sponsor->email ?? '') }}">
                        <label for="email">Email</label>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="form-floating mb-3">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone"
                            value="{{ old('phone', $sponsor->phone ?? '') }}">
                        <label for="phone">Phone</label>
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-globe form-icon"></i>Website</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                            <input type="url" name="website" class="form-control with-icon"
                                placeholder="https://www.example.com"
                                value="{{ old('website', $sponsor->website ?? '') }}">
                        </div>
                        @error('website')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-image form-icon"></i>Logo</label>
                        <div class="file-upload-area" id="fileUploadArea">
                            <div id="uploadContent">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h5>Drag & Drop your logo here</h5>
                                <p class="text-muted">or click to browse files</p>
                                <small class="text-muted">PNG, JPG, JPEG up to 2MB</small>
                            </div>
                            <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*">
                        </div>
                        @error('logo')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        {{-- Logo Preview --}}
                        <div id="logoPreview" class="mt-3 text-center">
                            @if(isset($sponsor) && $sponsor->logo)
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="{{ asset('storage/' . $sponsor->logo) }}" class="logo-preview" alt="Current Logo">
                                <div class="ms-3">
                                    <p class="mb-1">Current Logo</p>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeLogo">
                                        <i class="fas fa-trash me-1"></i>Remove
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('sponsors.ListeSponsor') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas {{ isset($sponsor) ? 'fa-save' : 'fa-plus' }} me-2"></i>
                            {{ isset($sponsor) ? 'Update' : 'Add Sponsor' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const fileUploadArea = document.getElementById('fileUploadArea');
        const logoInput = document.getElementById('logoInput');

        fileUploadArea.addEventListener('click', () => logoInput.click());
        fileUploadArea.addEventListener('dragover', e => e.preventDefault());
        fileUploadArea.addEventListener('drop', e => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                logoInput.files = e.dataTransfer.files;
            }
        });

        const removeBtn = document.getElementById('removeLogo');
        if (removeBtn) {
            removeBtn.addEventListener('click', () => {
                logoInput.value = '';
                document.getElementById('logoPreview').innerHTML = '';
            });
        }
    </script>
</body>

</html>