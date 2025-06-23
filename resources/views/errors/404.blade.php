@extends('errors.layout')
@section('title', '404 - Page Not Found')
@section('content')
    <div class="error-icon">
        <i class="fas fa-search"></i>
    </div>
    <div class="error-code">404</div>
    <h1 class="mb-4">Page Not Found</h1>
    <p class="lead mb-4">
        Oops! The page you're looking for doesn't exist.
        It might have been moved, deleted, or you entered the wrong URL.
    </p>
    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-primary btn-modern">
            <i class="fas fa-home me-2"></i>Return Home
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-secondary btn-modern">
            <i class="fas fa-arrow-left me-2"></i>Go Back
        </a>
    </div>
    <div class="mt-5">
        <small class="text-muted">
            Error ID: {{ Str::random(8) }} |
            Time: {{ now()->format('Y-m-d H:i:s') }}
        </small>
    </div>
@endsection