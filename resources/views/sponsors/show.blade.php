<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Sponsor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>{{ $sponsor->name }}</h1>
        <p><strong>Contribution:</strong> {{ $sponsor->contribution->value }}</p>
        <p><strong>Email:</strong> {{ $sponsor->email }}</p>
        <p><strong>Phone:</strong> {{ $sponsor->phone }}</p>
        <p><strong>Website:</strong> {{ $sponsor->website }}</p>
        @if($sponsor->logo)
        <img src="{{ asset('storage/' . $sponsor->logo) }}" width="100" alt="logo">
        @endif
        <br><br>
        <a href="{{ route('sponsors.ListeSponsor') }}" class="btn btn-primary">Back to List</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>