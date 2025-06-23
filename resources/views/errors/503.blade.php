@extends('errors.layout')
@section('title', '503 - Maintenance Mode')
@section('content')
    <div class="error-icon">
        <i class="fas fa-tools"></i>
    </div>
    <div class="error-code">503</div>
    <h1 class="mb-4">Under Maintenance</h1>
    <p class="lead mb-4">
        We're currently performing scheduled maintenance.
        We'll be back shortly!
    </p>
    <div class="mt-4">
        <button onclick="window.location.reload()" class="btn btn-primary btn-modern">
            <i class="fas fa-sync-alt me-2"></i>Check Again
        </button>
    </div>
    <div class="mt-5">
        <small class="text-muted">
            Follow us: <a href="#" class="text-decoration-none">@yourapp</a> for updates
        </small>
    </div>
@endsection