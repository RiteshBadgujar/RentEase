@extends('layouts.admin')

@section('title', 'Activity Details')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-clock-history text-primary me-2"></i>

                    Activity Details

                </h2>

                <p class="text-muted mb-0">

                    View complete information about this activity log.

                </p>

            </div>

            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left me-2"></i>

                Back

            </a>

        </div>

        <div class="row">

            <!-- User Information -->

            <div class="col-lg-4 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-primary text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-person-fill me-2"></i>

                            User Information

                        </h5>

                    </div>

                    <div class="card-body text-center">

                        <div class="rounded-circle bg-primary text-white fw-bold d-inline-flex justify-content-center align-items-center mb-3"
                            style="width:90px;height:90px;font-size:34px;">

                            {{ strtoupper(substr($activityLog->user->name ?? 'U', 0, 1)) }}

                        </div>

                        <h5>

                            {{ $activityLog->user->name ?? 'Unknown User' }}

                        </h5>

                    </div>

                </div>

            </div>

            <!-- Activity Information -->

            <div class="col-lg-8 mb-4">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-header bg-dark text-white">

                        <h5 class="mb-0">

                            <i class="bi bi-info-circle me-2"></i>

                            Activity Information

                        </h5>

                    </div>

                    <div class="card-body">

                        <table class="table table-borderless">

                            <tr>

                                <th width="30%">

                                    Activity ID

                                </th>

                                <td>

                                    #{{ $activityLog->id }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Module

                                </th>

                                <td>

                                    <span class="badge bg-info">

                                        {{ ucfirst($activityLog->module) }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Action

                                </th>

                                <td>

                                    <span class="badge bg-success">

                                        {{ ucfirst($activityLog->action) }}

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    IP Address

                                </th>

                                <td>

                                    {{ $activityLog->ip_address ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Browser

                                </th>

                                <td>

                                    {{ $activityLog->browser ?? 'N/A' }}

                                </td>

                            </tr>

                            <tr>

                                <th>

                                    Created

                                </th>

                                <td>

                                    {{ $activityLog->created_at->format('d M Y h:i A') }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-3">

                    <i class="bi bi-card-text me-2"></i>

                    Description

                </h5>

                <div class="alert alert-light border">

                    {{ $activityLog->description }}

                </div>
                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">

                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-2"></i>

                        Back to Activity Logs

                    </a>

                    <form action="{{ route('admin.activity-logs.destroy', $activityLog) }}" method="POST"
                        class="delete-form d-inline">

                        @csrf

                        @method('DELETE')

                        <button type="submit" class="btn btn-danger">

                            <i class="bi bi-trash me-2"></i>

                            Delete Activity

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection