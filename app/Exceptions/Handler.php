<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    }

    public function render($request, Throwable $exception)
    {
        $path = $request->path();

        if (strpos($path, 'api') === 0) {


            // return un authenticated user
            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'status' => 401,
                    'error' => 'Unauthenticated',
                    'message' => 'Login to continue using the app'
                ], 401);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => 404,
                    'error' => 'Not Found',
                    'message' => __('The requested resource was not found')
                ], 404);
            }
        }

        if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
            return response()->view('panel.errors-404', [], 404);
        }

        return parent::render($request, $exception);
    }
}
