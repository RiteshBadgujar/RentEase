@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')

    <div class="container-fluid py-4">

        <!-- Header -->

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold">

                    <i class="bi bi-gear-fill text-primary me-2"></i>

                    System Settings

                </h2>

                <p class="text-muted mb-0">

                    Manage website information, branding and contact details.

                </p>

            </div>

        </div>

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-primary text-white">

                <h4 class="mb-0">

                    <i class="bi bi-sliders me-2"></i>

                    Website Configuration

                </h4>

            </div>

            <div class="card-body">

                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">

                                Website Name

                            </label>

                            <input type="text" name="website_name"
                                class="form-control @error('website_name') is-invalid @enderror"
                                value="{{ old('website_name', $setting->website_name) }}" required>

                            @error('website_name')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">

                                Contact Email

                            </label>

                            <input type="email" name="contact_email"
                                class="form-control @error('contact_email') is-invalid @enderror"
                                value="{{ old('contact_email', $setting->contact_email) }}">

                            @error('contact_email')

                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">

                                Contact Phone

                            </label>

                            <input type="text" name="contact_phone" class="form-control"
                                value="{{ old('contact_phone', $setting->contact_phone) }}">

                        </div>

                        <div class="col-md-6 mb-4">

                            <label class="form-label fw-bold">

                                Footer Text

                            </label>

                            <input type="text" name="footer_text" class="form-control"
                                value="{{ old('footer_text', $setting->footer_text) }}">
                            <div class="col-12 mb-4">

                                <label class="form-label fw-bold">

                                    Address

                                </label>

                                <textarea name="address" rows="3"
                                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $setting->address) }}</textarea>

                                @error('address')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <hr class="my-4">

                            <h5 class="fw-bold text-primary mb-4">

                                <i class="bi bi-share-fill me-2"></i>

                                Social Media Links

                            </h5>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Facebook URL

                                </label>

                                <input type="url" name="facebook"
                                    class="form-control @error('facebook') is-invalid @enderror"
                                    value="{{ old('facebook', $setting->facebook) }}"
                                    placeholder="https://facebook.com/yourpage">

                                @error('facebook')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Instagram URL

                                </label>

                                <input type="url" name="instagram"
                                    class="form-control @error('instagram') is-invalid @enderror"
                                    value="{{ old('instagram', $setting->instagram) }}"
                                    placeholder="https://instagram.com/yourpage">

                                @error('instagram')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    LinkedIn URL

                                </label>

                                <input type="url" name="linkedin"
                                    class="form-control @error('linkedin') is-invalid @enderror"
                                    value="{{ old('linkedin', $setting->linkedin) }}"
                                    placeholder="https://linkedin.com/in/yourprofile">

                                @error('linkedin')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Twitter / X URL

                                </label>

                                <input type="url" name="twitter" class="form-control @error('twitter') is-invalid @enderror"
                                    value="{{ old('twitter', $setting->twitter) }}"
                                    placeholder="https://twitter.com/username">

                                @error('twitter')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <hr class="my-4">

                            <h5 class="fw-bold text-primary mb-4">

                                <i class="bi bi-image-fill me-2"></i>

                                Branding

                            </h5>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Website Logo

                                </label>

                                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">

                                @error('logo')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                                @if($setting->logo)

                                    <div class="mt-3">

                                        <img src="{{ asset('storage/' . $setting->logo) }}" class="img-thumbnail shadow-sm"
                                            style="max-height:120px;">

                                    </div>

                                @endif

                            </div>

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-bold">

                                    Website Favicon

                                </label>

                                <input type="file" name="favicon"
                                    class="form-control @error('favicon') is-invalid @enderror">

                                @error('favicon')

                                    <div class="invalid-feedback">

                                        {{ $message }}

                                    </div>

                                @enderror

                                @if($setting->favicon)

                                    <div class="mt-3">

                                        <img src="{{ asset('storage/' . $setting->favicon) }}" class="img-thumbnail shadow-sm"
                                            style="max-height:70px;">

                                    </div>

                                @endif

                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">

                                    <i class="bi bi-arrow-left me-2"></i>

                                    Back to Dashboard

                                </a>

                                <div>

                                    <button type="reset" class="btn btn-outline-dark me-2">

                                        <i class="bi bi-arrow-clockwise me-2"></i>

                                        Reset

                                    </button>

                                    <button type="submit" class="btn btn-primary">

                                        <i class="bi bi-check-circle-fill me-2"></i>

                                        Save Settings

                                    </button>

                                </div>

                            </div>

                        </div>

                </form>

            </div>

        </div>

    </div>

@endsection