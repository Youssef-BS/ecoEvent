@php
$isEdit = isset($resource);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Resource' : 'Add Resource' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-primary: #cbdf72;
            --bs-secondary: #12372A;
        }

        body {
            background-color: #f8f9fa;
        }

        .card-header.bg-primary {
            color: var(--bs-secondary) !important;
        }

        .btn-primary {
            color: var(--bs-secondary) !important;
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

        .file-upload-area .fa-cloud-upload-alt {
            color: var(--bs-primary) !important;
        }

        .logo-preview img {
            max-height: 100px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="card shadow-sm rounded-3">
            <div class="card-header  text-center py-3" style="background-color: #cbdf72;">
                <h2 class="mb-0">{{ $isEdit ? 'Edit Resource' : 'Add Resource' }}</h2>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ $isEdit ? route('resources.update', $resource->id) : route('resources.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($isEdit)
                    @method('PUT')
                    @endif

                    <div class="form-floating mb-3">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                            value="{{ old('title', $isEdit ? $resource->title : '') }}">
                        <label for="title">Title</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Quantity"
                            value="{{ old('quantity', $isEdit ? $resource->quantity : 0) }}">
                        <label for="quantity">Quantity</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select name="sponsor_id" id="sponsor_id" class="form-select">
                            <option value="">Select Sponsor</option>
                            @foreach($sponsors as $sponsor)
                            <option value="{{ $sponsor->id }}"
                                {{ old('sponsor_id', $isEdit ? $resource->sponsor_id : '') == $sponsor->id ? 'selected' : '' }}>
                                {{ $sponsor->name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="sponsor_id">Sponsor</label>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Image</label>
                        <div class="file-upload-area" id="fileUploadArea">
                            <div id="uploadContent">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                                <h5>Drag & drop your image here</h5>
                                <p class="text-muted">or click to browse files</p>
                                <small class="text-muted">PNG, JPG, JPEG up to 5MB</small>
                            </div>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                        </div>
                        <div id="imagePreview" class="mt-3 text-center">
                            @if ($isEdit && $resource->image)
                            <img src="{{ asset('storage/'.$resource->image) }}" class="logo-preview" alt="Preview">
                            @endif
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('resources.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas {{ $isEdit ? 'fa-save' : 'fa-plus' }} me-2"></i>{{ $isEdit ? 'Update Resource' : 'Create Resource' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const fileUploadArea = document.getElementById('fileUploadArea');
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        function previewImage(file) {
            const reader = new FileReader();
            reader.onload = e => {
                imagePreview.innerHTML = `<img src="${e.target.result}" class="logo-preview" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        }

        fileUploadArea.addEventListener('click', () => imageInput.click());
        fileUploadArea.addEventListener('dragover', e => e.preventDefault());
        fileUploadArea.addEventListener('drop', e => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                imageInput.files = e.dataTransfer.files;
                previewImage(e.dataTransfer.files[0]);
            }
        });

        imageInput.addEventListener('change', () => {
            if (imageInput.files.length) {
                previewImage(imageInput.files[0]);
            }
        });
    </script>
</body>

</html>