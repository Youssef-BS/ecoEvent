<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white text-center py-4">
                <h2 class="mb-0">{{ $sponsor->name }}</h2>
            </div>

            <div class="card-body p-4">
                <div class="row g-4 align-items-center">

                    <!-- Logo -->
                    <div class="col-md-4 text-center">
                        @if($sponsor->logo)
                        <img src="{{ asset('storage/' . $sponsor->logo) }}"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 180px;"
                            alt="Logo {{ $sponsor->name }}">
                        @else
                        <div class="bg-secondary text-white rounded p-5">
                            No Logo
                        </div>
                        @endif
                    </div>

                    <!-- Infos sous forme de liste -->
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Contribution</span>
                                <span class="fw-semibold">{{ ucfirst($sponsor->contribution->value ?? $sponsor->contribution) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Email</span>
                                <span>
                                    @if($sponsor->email)
                                    <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none">
                                        {{ $sponsor->email }}
                                    </a>
                                    @else
                                    <span class="text-muted">Non défini</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Phone</span>
                                <span>{{ $sponsor->phone ?? 'Non défini' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Website</span>
                                <span>
                                    @if($sponsor->website)
                                    <a href="{{ $sponsor->website }}" target="_blank" class="text-decoration-none">
                                        {{ $sponsor->website }}
                                    </a>
                                    @else
                                    <span class="text-muted">Non défini</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="text-muted">Créé le</span>
                                <span>{{ $sponsor->created_at->format('d/m/Y H:i') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-light text-center">
                <a href="{{ route('sponsors.ListeSponsor') }}" class="btn btn-outline-primary">
                    ← Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>