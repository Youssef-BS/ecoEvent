<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #1C352D;
            --secondary-green: #2A4A3C;
            --accent-green: #3A7D5F;
            --light-green: #E8F5E9;
            --light-gray: #F8F9FA;
        }
        
        body {
            background-color: #f9fbfa;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(28, 53, 45, 0.08);
        }
        
        .card-header {
            background-color: var(--primary-green);
            color: white;
            border-bottom: none;
            padding: 1rem 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            padding: 0.5rem 1.25rem;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-green);
            border-color: var(--secondary-green);
        }
        
        .btn-outline-info {
            color: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        .btn-outline-info:hover {
            background-color: var(--primary-green);
            color: white;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--light-green);
            color: var(--primary-green);
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            padding: 1rem 0.75rem;
        }
        
        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr:hover {
            background-color: rgba(232, 245, 233, 0.4);
        }
        
        .search-container {
            position: relative;
        }
        
        .search-container i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-green);
        }
        
        .search-container input {
            padding-left: 40px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        
        .badge {
            padding: 0.4em 0.8em;
            font-weight: 500;
        }
        
        .badge-admin {
            background-color: var(--accent-green);
        }
        
        .badge-user {
            background-color: #6c757d;
        }
        
        .page-title {
            color: var(--primary-green);
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .action-buttons .btn {
            margin-right: 5px;
            border-radius: 6px;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ced4da;
        }
    </style>
</head>
@extends('admin.layouts.dashboard')

@section('content')
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Users List</h1>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i> Add New User
            </a>
        </div>

        {{-- Search Bar --}}
        <div class="search-container mb-4">
            <i class="bi bi-search"></i>
            <input type="text" class="form-control shadow-sm" placeholder="Search users by name, email, or role...">
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Users</h5>
                <span class="badge bg-light text-dark">{{ count($users) }} users</span>
            </div>
            <div class="card-body p-0">
                @if(count($users) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Role</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="text-center fw-bold">{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; background-color: var(--light-green) !important;">
                                            <span class="text-primary-green" style="color: var(--primary-green); font-weight: 600;">
                                                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-user' }}">
                                        {{ ucfirst($user->role ?? 'User') }}
                                    </span>
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="{{ route('users.showProfile', $user->id) }}" class="btn btn-sm btn-outline-info" title="View Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <h4>No users found</h4>
                    <p>Get started by adding your first user</p>
                    <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-person-plus me-2"></i> Add New User
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
</html>