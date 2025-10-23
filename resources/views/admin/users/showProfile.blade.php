@extends('admin.layouts.dashboard')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://via.placeholder.com/150' }}" 
                 class="rounded-circle mb-3" width="150" height="150" alt="User Image">

            <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
            <p class="text-muted">{{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p><strong>Role:</strong> <span class="badge bg-secondary">{{ ucfirst($user->role ?? 'User') }}</span></p>
            <p><strong>Location:</strong> {{ $user->location ?? 'Not specified' }}</p>
            <p class="mt-3"><strong>Bio:</strong><br>{{ $user->bio ?? 'No bio available.' }}</p>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="{{ route('users.listUsers') }}" class="btn btn-outline-secondary">Back</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                    Edit Profile
                </button>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('users.edit', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body row g-3">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input name="first_name" value="{{ $user->first_name }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input name="last_name" value="{{ $user->last_name }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input name="email" type="email" value="{{ $user->email }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input name="phone" value="{{ $user->phone }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Location</label>
                <input name="location" value="{{ $user->location }}" class="form-control">
            </div>
            <div class="col-12">
                <label class="form-label">Bio</label>
                <textarea name="bio" class="form-control" rows="3">{{ $user->bio }}</textarea>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
