@extends('layouts.master')

@section('title', 'Activity Details')

@section('content')

<div class="container py-4">

    <div class="card shadow">

        <div class="card-header">

            <h4>

                Activity Details

            </h4>

        </div>

        <div class="card-body">

            <table class="table">

                <tr>

                    <th>User</th>

                    <td>{{ $activityLog->user->name ?? 'Unknown' }}</td>

                </tr>

                <tr>

                    <th>Module</th>

                    <td>{{ $activityLog->module }}</td>

                </tr>

                <tr>

                    <th>Action</th>

                    <td>{{ $activityLog->action }}</td>

                </tr>

                <tr>

                    <th>Description</th>

                    <td>{{ $activityLog->description }}</td>

                </tr>

                <tr>

                    <th>IP Address</th>

                    <td>{{ $activityLog->ip_address }}</td>

                </tr>

                <tr>

                    <th>Browser</th>

                    <td>{{ $activityLog->browser }}</td>

                </tr>

                <tr>

                    <th>Created</th>

                    <td>{{ $activityLog->created_at }}</td>

                </tr>

            </table>

            <a
                href="{{ route('admin.activity-logs.index') }}"
                class="btn btn-secondary">

                Back

            </a>

        </div>

    </div>

</div>

@endsection