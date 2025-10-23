<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($resource) ? 'Edit Resource' : 'Add Resource' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>{{ isset($resource) ? 'Edit Resource' : 'Add Resource' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($resource) ? route('resources.update', $resource->id) : route('resources.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($resource))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $resource->title ?? old('title') }}" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $resource->quantity ?? old('quantity', 0) }}" required>
        </div>

        <div class="mb-3">
            <label>Sponsor</label>
            <select name="sponsor_id" class="form-control" required>
                <option value="">Select Sponsor</option>
                @foreach($sponsors as $sponsor)
                    <option value="{{ $sponsor->id }}" {{ isset($resource) && $resource->sponsor_id == $sponsor->id ? 'selected' : '' }}>
                        {{ $sponsor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            @if(isset($resource) && $resource->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $resource->image) }}" width="100" alt="Resource Image">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">{{ isset($resource) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('resources.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
