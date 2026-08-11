@extends('layouts.master')

@section('title', 'Edit Property')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4">

                <!-- ==========================
                        Header
                =========================== -->

                <div class="card-header bg-warning text-dark">

                    <h3 class="mb-0">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Property

                    </h3>

                </div>


                <!-- ==========================
                        Form Body
                =========================== -->

                <div class="card-body p-4">

                    <!-- Validation Errors -->

                    @if($errors->any())

                        <div
                            class="alert alert-danger alert-dismissible fade show"
                            role="alert">

                            <strong>

                                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                                Please fix the following errors:

                            </strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>

                        </div>

                    @endif


                    <!-- Success Message -->

                    @if(session('success'))

                        <div
                            class="alert alert-success alert-dismissible fade show"
                            role="alert">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            {{ session('success') }}

                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>

                        </div>

                    @endif


                    <!-- Edit Property Form -->

                    <form
                        action="{{ route('properties.update', $property) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        @include('property._form')

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection