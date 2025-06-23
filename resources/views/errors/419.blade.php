@extends('errors.layout')
@section('title', '419 - Page Expired')
@section('content')
    <div class="error-icon">
        <i class="fas fa-clock"></i>
    </div>
    <div class="error-code">419</div>
    <h1 class="mb-4">Page Expired</h1>
    <p class="lead mb-4">
        Your session has expired due to inactivity.
        Please refresh the page and try again.
    </p>
    <div class="mt-4">
        <button onclick="window.location.reload()" class="btn btn-primary btn-modern">
            <i class="fas fa-sync-alt me-2"></i>Refresh Page
        </button>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-modern">
            <i class="fas fa-home me-2"></i>Return Home
        </a>
    </div>
@endsection