<?php

namespace Bits\Package\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Bits\Package\Responses\ApiResponse;

class BitsValidationHandler
{
    public static function validate(Request $request, array $rules, array $messages = [])
    {
        try {
            return $request->validate($rules, $messages);
        } catch (ValidationException $e) {
            throw new HttpResponseException(
                ApiResponse::error('Validation failed', $e->errors(), 422)
            );
        } catch (\Exception $e) {
            throw new HttpResponseException(
                ApiResponse::error('An unexpected error occurred', ['error' => $e->getMessage()], 500)
            );
        }
    }
}
