<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Sponsors List</h1>
        <a href="{{ route('sponsors.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path d="M8 0a.5.5 0 0 1 .5.5v7h7a.5.5 0 0 1 0 1h-7v7a.5.5 0 0 1-1 0v-7H.5a.5.5 0 0 1 0-1h7V.5A.5.5 0 0 1 8 0z" />
            </svg>
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Contribution</th>
                    <th>Email</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sponsors as $sponsor)
                <tr>
                    <td>
                        @if($sponsor->logo)
                        <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="Logo {{ $sponsor->name }}"
                            class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                        @else
                        <span class="text-muted fst-italic">No logo</span>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $sponsor->name }}</td>
                    <td>{{ ucfirst($sponsor->contribution->value) }}</td>
                    <td>
                        <a href="mailto:{{ $sponsor->email }}" class="text-decoration-none text-primary">
                            {{ $sponsor->email }}
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Sponsor Actions">

                            <a href="{{ route('sponsors.show', $sponsor->id) }}" class="btn btn-link text-success" title="Voir les détails">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" fill="currentColor" viewBox="0 0 640 640">
                                    <path d="M320 96C239.2 96 174.5 132.8 127.4 176.6C80.6 220.1 49.3 272 34.4 307.7C31.1 315.6 31.1 324.4 34.4 332.3C49.3 368 80.6 420 127.4 463.4C174.5 507.1 239.2 544 320 544C400.8 544 465.5 507.2 512.6 463.4C559.4 419.9 590.7 368 605.6 332.3C608.9 324.4 608.9 315.6 605.6 307.7C590.7 272 559.4 220 512.6 176.6C465.5 132.9 400.8 96 320 96zM176 320C176 240.5 240.5 176 320 176C399.5 176 464 240.5 464 320C464 399.5 399.5 464 320 464C240.5 464 176 399.5 176 320zM320 256C320 291.3 291.3 320 256 320C244.5 320 233.7 317 224.3 311.6C223.3 322.5 224.2 333.7 227.2 344.8C240.9 396 293.6 426.4 344.8 412.7C396 399 426.4 346.3 412.7 295.1C400.5 249.4 357.2 220.3 311.6 224.3C316.9 233.6 320 244.4 320 256z" />
                                </svg>
                            </a>

                            <a href="{{ route('sponsors.edit', $sponsor->id) }}" class="btn btn-link text-warning" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" fill="currentColor" viewBox="0 0 512 512">
                                    <path d="M495.2 27.6c-18.7-18.7-49-18.7-67.7 0l-12.8 12.8L477.6 122.3l12.8-12.8c18.7-18.7 18.7-49 0-67.7l-12.8-12.8zm-155.6 156.4L188.7 334.9c-7.9 7.9-12.2 18.4-12.2 29.5L176.8 456l-98 19.6c-10.7 2.1-21.7-1.1-29.8-9.1s-11.2-18.8-9.1-29.8l19.6-98c.1-4.7 1-9.3 2.6-13.6c1.6-4.3 3.9-8.4 6.8-12.2L312.3 84.8c18.7-18.7 49-18.7 67.7 0s18.7 49 0 67.7L339.6 200.2zM216 480H40c-22.1 0-40-17.9-40-40V176c0-22.1 17.9-40 40-40h128c11 0 20-9 20-20s-9-20-20-20H40c-44.2 0-80 35.8-80 80V440c0 44.2 35.8 80 80 80h176c11 0 20-9 20-20s-9-20-20-20z" />
                                </svg>
                            </a>

                            <form action="{{ route('sponsors.destroy', $sponsor->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer ce sponsor ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" fill="currentColor" viewBox="0 0 448 512">
                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 30.9 27.2 53 58.6 53H336.2c31.3 0 57-22.1 58.6-53L416 128z" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center fst-italic py-4">No sponsors found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>