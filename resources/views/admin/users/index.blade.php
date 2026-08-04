@extends('layouts.master')

@section('title', 'User Management')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">

                <i class="bi bi-people-fill text-primary me-2"></i>

                User Management

            </h2>

            <p class="text-muted mb-0">

                Manage all registered users.

            </p>

        </div>

    </div>

    {{-- Success Message --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    {{-- Error Message --}}

    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    {{-- Search & Filter --}}

    <div class="card shadow border-0 mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.users.index') }}">

                <div class="row g-3">

                    <div class="col-md-5">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search name or email..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-4">

                        <select
                            name="role"
                            class="form-select">

                            <option value="">

                                All Roles

                            </option>

                            <option value="admin"
                                {{ request('role')=='admin' ? 'selected' : '' }}>

                                Admin

                            </option>

                            <option value="landlord"
                                {{ request('role')=='landlord' ? 'selected' : '' }}>

                                Landlord

                            </option>

                            <option value="tenant"
                                {{ request('role')=='tenant' ? 'selected' : '' }}>

                                Tenant

                            </option>

                        </select>

                    </div>

                    <div class="col-md-3 d-grid">

                        <button class="btn btn-primary">

                            <i class="bi bi-search me-2"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- Users Table --}}

    <div class="card shadow border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>#</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Joined</th>

                            <th width="180">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            <tr>

                                <td>

                                    {{ $users->firstItem() + $loop->index }}

                                </td>

                                <td>

                                    <strong>

                                        {{ $user->name }}

                                    </strong>

                                </td>

                                <td>

                                    {{ $user->email }}

                                </td>

                                <td>

                                    @if($user->role=='admin')

                                        <span class="badge bg-danger">

                                            Admin

                                        </span>

                                    @elseif($user->role=='landlord')

                                        <span class="badge bg-success">

                                            Landlord

                                        </span>

                                    @else

                                        <span class="badge bg-primary">

                                            Tenant

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $user->created_at->format('d M Y') }}

                                </td>

                                <td>

                                    <a href="{{ route('admin.users.show',$user) }}"
                                       class="btn btn-info btn-sm">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <a href="{{ route('admin.users.edit',$user) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form
                                        action="{{ route('admin.users.destroy',$user) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this user?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    <i class="bi bi-people display-5 text-muted"></i>

                                    <p class="mt-3 mb-0">

                                        No users found.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $users->links() }}

            </div>

        </div>

    </div>

</div>

@endsection