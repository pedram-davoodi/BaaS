<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('jsonResponse')) {
    /**
     * Generate a JSON response based on the provided data, message, and status code.
     *
     * @param array|null $data The data to include in the response.
     * @param string|null $message The message to include in the response.
     * @param int $code The HTTP status code for the response (default: 200).
     * @return JsonResponse The JSON response.
     */
    function jsonResponse(array $data = null, string $message = null, int $code = 200): JsonResponse
    {
        $response = [];

        if (!is_null($data)) {
            $response['data'] = $data;
        }
        if (!is_null($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }

}

if (!function_exists('arrayJoin')) {
    /**
     * Joins two arrays based on specified keys and returns a combined array.
     *
     * @param array $array1 First array to be joined.
     * @param array $array2 Second array to be joined.
     * @param string $firstKey Key from the first array to compare.
     * @param string $secondKey Key from the second array to compare.
     * @param string $attrName Name for the attribute added from the second array.
     */
    function arrayJoin(array $array1, array $array2, string $firstKey, string $secondKey, string $attrName): array
    {
        $combinedArray = [];
        foreach ($array1 as $item1) {
            foreach ($array2 as $item2) {
                if ($item1[$firstKey] === $item2[$secondKey]) {
                    $combinedArray[] = array_merge($item1, [$attrName => $item2]);
                }
            }
        }

        return $combinedArray;
    }
}
