<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    public function register() : void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        if (request()->is('api/*', 'platform/*')) {
            $this->renderable(function (ValidationException $e) {
                $errors = $e->errors();
                $ret    = [];
                foreach ($errors as $key => $value) {
                    if (isset($value[0])) {
                        $ret[$key] = $value[0];
                    }
                }
                return response()->json([
                    'code'    => 422,
                    'success' => false,
                    'message' => 'Validation Error',
                    'error'   => $ret,
                ], 200);
            });
        }
    }
}
