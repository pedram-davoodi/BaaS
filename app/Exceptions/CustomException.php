<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CustomException
 *
 * Abstract base exception class for custom exceptions.
 *
 * @package App\Exceptions
 */
abstract class CustomException extends HttpException
{
    /**
     * Get the JSON response for the exception.
     *
     * @return JsonResponse
     */
    public function getResponse(): JsonResponse
    {
        return response()->json(['message' => $this->getMessage()], $this->getStatusCode() ?? 500);
    }
}
