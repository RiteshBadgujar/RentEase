@extends('layouts.master')

@section('title', 'Edit Property')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-warning text-dark">

                    <h3 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Property
                    </h3>

                </div>

                <div class="card-body">

                    <form action="{{ route('properties.update', $property->id) }}"
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