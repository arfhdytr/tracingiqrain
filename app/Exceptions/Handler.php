<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle throttle exceptions
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan. Silakan coba lagi dalam beberapa saat.',
                    'retry_after' => $retryAfter
                ], 429);
            }

            // Untuk web requests, redirect kembali dengan error message dan retry_after
            return back()
                ->withErrors([
                    'throttle' => 'Terlalu banyak percobaan login! Harap tunggu dan coba lagi dalam waktu yang ditentukan.'
                ])
                ->with('retry_after', $retryAfter)
                ->withInput($request->except('password'));
        });
    }
}
