<?php

namespace Bits\Package\Exceptions;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Bits\Package\Responses\ApiResponse;

class BitsExeceptionHandler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return ApiResponse::error(
                'Unauthorized',
                $exception->getMessage(),
                403
            );
        }

        return parent::render($request, $exception);
    }
}