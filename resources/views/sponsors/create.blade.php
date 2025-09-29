<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($sponsor) ? 'Edit Sponsor' : 'Add Sponsor' }}</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>{{ isset($sponsor) ? 'Edit Sponsor' : 'Add Sponsor' }}</h1>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form action="{{ isset($sponsor) ? route('sponsors.update', $sponsor->id) : route('sponsors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($sponsor)) @method('PUT') @endif

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $sponsor->name ?? old('name') }}">
            </div>

            <div class="mb-3">
                <label>Contribution</label>
                <select name="contribution" class="form-control">
                    @foreach(['financial','material','logistical'] as $type)
                    <option value="{{ $type }}"
                        {{ (isset($sponsor) && $sponsor->contribution->value == $type) ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                    @endforeach
                </select>

            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $sponsor->email ?? old('email') }}">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $sponsor->phone ?? old('phone') }}">
            </div>

            <div class="mb-3">
                <label>Website</label>
                <input type="url" name="website" class="form-control" value="{{ $sponsor->website ?? old('website') }}">
            </div>

            <div class="mb-3">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control">
                @if(isset($sponsor) && $sponsor->logo)
                <img src="{{ asset('storage/' . $sponsor->logo) }}" width="50" alt="logo">
                @endif
            </div>

            <button type="submit" class="btn btn-success">{{ isset($sponsor) ? 'Update' : 'Add' }}</button>
            <a href="{{ route('sponsors.ListeSponsor') }}" class="btn btn-secondary">Cancel</a>


        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>