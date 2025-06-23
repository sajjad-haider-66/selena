<?php
namespace App\Exceptions;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler {
    /**
     * A list of exception types with their corresponding custom log levels.
     * @var array<class-string<Throwable>, Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];
    /**
     * A list of the exception types that are not reported.
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];
    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    /**
     * Register the exception handling callbacks for the application.
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        // Handle HTTP exceptions
        $this->renderable(function (HttpException $e, Request $request) {
            return $this->handleHttpException($e, $request);
        });
        // Handle 404 specifically
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            return $this->handleNotFoundException($e, $request);
        });
        // Handle general exceptions
        $this->renderable(function (Throwable $e, Request $request) {
            return $this->handleGeneralException($e, $request);
        });
    }
    /**
     * Handle HTTP exceptions
     */
    protected function handleHttpException(HttpException $e, Request $request)
    {
        $statusCode = $e->getStatusCode();
        // Return JSON for API requests
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => $this->getHttpExceptionMessage($statusCode),
                'status_code' => $statusCode,
                'errors' => ['error' => [$e->getMessage() ?: $this->getHttpExceptionMessage($statusCode)]]
            ], $statusCode);
        }
        // Check if custom error view exists
        if (view()->exists("errors.{$statusCode}")) {
            return response()->view("errors.{$statusCode}", [
                'exception' => $e,
                'statusCode' => $statusCode
            ], $statusCode);
        }
        // Fallback to default Laravel error handling
        return null;
    }
    /**
     * Handle 404 exceptions specifically
     */
    protected function handleNotFoundException(NotFoundHttpException $e, Request $request)
    {
        // Log 404 errors for analytics
        Log::channel('daily')->info('404 Error', [
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'referrer' => $request->header('referer')
        ]);
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Resource not found',
                'status_code' => 404,
                'errors' => ['error' => ['The requested resource was not found']]
            ], 404);
        }
        return response()->view('errors.404', [
            'exception' => $e
        ], 404);
    }
    /**
     * Handle general exceptions
     */
    protected function handleGeneralException(Throwable $e, Request $request)
    {
        // Don't handle in debug mode
        if (config('app.debug')) {
            return null;
        }
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Server Error',
                'status_code' => 500,
                'errors' => ['error' => ['An unexpected error occurred']]
            ], 500);
        }
        return response()->view('errors.500', [
            'exception' => $e
        ], 500);
    }
    /**
     * Get user-friendly message for HTTP status codes
     */
    protected function getHttpExceptionMessage($statusCode) {
        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            419 => 'Page Expired',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            503 => 'Service Unavailable'
        ];
        return $messages[$statusCode] ?? 'HTTP Error';
    }
}