@extends('errors.layout')
@section('title', '500 - Server Error')
@section('content')
    <div class="error-icon">
        <i class="fas fa-server"></i>
    </div>
    <div class="error-code">500</div>
    <h1 class="mb-4">Server Error</h1>
    <p class="lead mb-4">
        Something went wrong on our end. We're working to fix this issue.
        Please try again in a few minutes.
    </p>
    <div class="mt-4">
        <button onclick="window.location.reload()" class="btn btn-primary btn-modern">
            <i class="fas fa-sync-alt me-2"></i>Try Again
        </button>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-modern">
            <i class="fas fa-home me-2"></i>Return Home
        </a>
    </div>
    <div class="mt-5">
        <small class="text-muted">
            Report this issue: <a href="mailto:support@yourapp.com">support@yourapp.com</a>
        </small>
    </div>
@endsection
@section('scripts')
<script>
    // Auto-refresh after 30 seconds
    setTimeout(function() {
        window.location.reload();
    }, 30000);
</script>
@endsection