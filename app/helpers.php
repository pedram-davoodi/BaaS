<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('jsonResponse')) {
    /**
     * Generate a JSON response based on the provided data, message, and status code.
     *
     * @param  array|null  $data The data to include in the response.
     * @param  string|null  $message The message to include in the response.
     * @param  int  $code The HTTP status code for the response (default: 200).
     * @return JsonResponse The JSON response.
     */
    function jsonResponse(array $data = null, string $message = null, int $code = 200): JsonResponse
    {
        $response = [];

        if (! is_null($data)) {
            $response['data'] = $data;
        }
        if (! is_null($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

}
