<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($sponsor) ? 'Modifier Sponsor' : 'Ajouter Sponsor' }}</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        .file-upload-area {
            border: 2px dashed #0d6efd;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-upload-area:hover {
            background-color: #e9f2ff;
        }

        .logo-preview img {
            max-height: 80px;
            border-radius: 6px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h2 class="mb-0">{{ isset($sponsor) ? 'Modifier Sponsor' : 'Ajouter Sponsor' }}</h2>
            </div>

            <div class="card-body p-4">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ isset($sponsor) ? route('sponsors.update', $sponsor->id) : route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($sponsor)) @method('PUT') @endif

                    <!-- Name -->
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nom" value="{{ $sponsor->name ?? old('name') }}">
                        <label for="name">Nom</label>
                    </div>

                    <!-- Contribution -->
                    <div class="form-floating mb-3">
                        <select name="contribution" id="contribution" class="form-select">
                            @foreach(['financial','material','logistical'] as $type)
                            <option value="{{ $type }}" {{ (isset($sponsor) && ($sponsor->contribution->value ?? $sponsor->contribution) == $type) ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                        <label for="contribution">Contribution</label>
                    </div>

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ $sponsor->email ?? old('email') }}">
                        <label for="email">Email</label>
                    </div>

                    <!-- Phone -->
                    <div class="form-floating mb-3">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Téléphone" value="{{ $sponsor->phone ?? old('phone') }}">
                        <label for="phone">Téléphone</label>
                    </div>

                    <!-- Website -->
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-globe form-icon"></i>Site Web
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-globe"></i>
                            </span>
                            <input type="url" name="website" class="form-control with-icon" value="{{ $sponsor->website ?? old('website') }}" placeholder="https://www.exemple.com">
                        </div>
                    </div>

                    <!-- Logo -->
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-image form-icon"></i>Logo
                        </label>

                        <div class="file-upload-area" id="fileUploadArea">
                            <div id="uploadContent">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h5>Glissez-déposez votre logo ici</h5>
                                <p class="text-muted">ou cliquez pour parcourir vos fichiers</p>
                                <small class="text-muted">PNG, JPG, JPEG jusqu'à 2MB</small>
                            </div>
                            <input type="file" name="logo" id="logoInput" class="d-none" accept="image/*">
                        </div>

                        <!-- Logo Preview -->
                        <div id="logoPreview" class="mt-3 text-center">
                            @if(isset($sponsor) && $sponsor->logo)
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="{{ asset('storage/' . $sponsor->logo) }}" class="logo-preview" alt="Logo actuel">
                                <div class="ms-3">
                                    <p class="mb-1">Logo actuel</p>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeLogo">
                                        <i class="fas fa-trash me-1"></i>Supprimer
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('sponsors.ListeSponsor') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas {{ isset($sponsor) ? 'fa-save' : 'fa-plus' }} me-2"></i>
                            {{ isset($sponsor) ? 'Mettre à jour' : 'Ajouter le sponsor' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
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