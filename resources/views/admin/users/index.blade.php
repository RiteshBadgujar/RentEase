@extends('layouts.admin')

@section('title', 'User Management')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">

                    <i class="bi bi-people-fill text-primary me-2"></i>

                    User Management

                </h4>

                <small class="text-muted">

                    Manage all registered users from one place.

                </small>

            </div>

            <span class="badge bg-primary fs-6">

                {{ $users->count() }} Users

            </span>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle datatable">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>User</th>

                            <th>Email</th>

                            <th>Role</th>

                            <th>Joined</th>

                            <th width="190">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($users as $user)

                            @php

                                $badge = [

                                    'admin' => 'danger',

                                    'landlord' => 'success',

                                    'tenant' => 'primary'

                                ];

                            @endphp

                            <tr>

                                <td>

                                    {{ $user->id }}

                                </td>

                                <td>

                                    <div class="d-flex align-items-center">

                                        <div
                                            class="rounded-circle bg-primary text-white fw-bold d-flex justify-content-center align-items-center me-3"
                                            style="width:40px;height:40px;">

                                            {{ strtoupper(substr($user->name,0,1)) }}

                                        </div>

                                        <div>

                                            <div class="fw-bold">

                                                {{ $user->name }}

                                            </div>

                                            <small class="text-muted">

                                                User #{{ $user->id }}

                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>

                                    {{ $user->email }}

                                </td>

                                <td>

                                    <span class="badge bg-{{ $badge[$user->role] ?? 'secondary' }}">

                                        {{ ucfirst($user->role) }}

                                    </span>

                                </td>

                                <td>

                                    {{ $user->created_at->format('d M Y') }}

                                </td>

                                <td>

                                    <div class="btn-group" role="group">

                                        <a
                                            href="{{ route('admin.users.show', $user) }}"
                                            class="btn btn-info btn-sm"
                                            title="View">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a
                                            href="{{ route('admin.users.edit', $user) }}"
                                            class="btn btn-warning btn-sm"
                                            title="Edit">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>

                                        @if(auth()->id() != $user->id)

                                            <form
                                                action="{{ route('admin.users.destroy', $user) }}"
                                                method="POST"
                                                class="delete-form d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-danger btn-sm"
                                                    title="Delete">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        @else

                                            <button
                                                class="btn btn-secondary btn-sm"
                                                disabled
                                                title="Current User">

                                                <i class="bi bi-lock-fill"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <i class="bi bi-people display-1 text-secondary"></i>

                                    <h4 class="mt-3">

                                        No Registered Users

                                    </h4>

                                    <p class="text-muted">

                                        There are currently no users available.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection