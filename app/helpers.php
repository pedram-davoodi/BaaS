<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

if (!function_exists('jsonResponse')) {
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

        if (!is_null($data)) {
            $response['data'] = $data;
        }
        if (!is_null($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}

if (!function_exists('saveBase64Files')) {
    /**
     * Save a base64-encoded file string to a file.
     *
     * @param string $base64String The base64-encoded image string.
     * @param string $destinationPath The destination path where the image will be saved.
     *
     * @return string An associative array containing the 'path', 'url', and 'mime' of the saved image.
     */
    function saveBase64Files(string $base64String, string $destinationPath = 'images/' , string $disk = 'public'): string
    {

        list(, $base64Data) = explode(';', $base64String);
        list(, $base64Data) = explode(',', $base64Data);


        list(, $extension) = explode('/', explode(':', substr($base64String, 0, strpos($base64String, ';')))[1]);
        // Decode the base64 string


        $imageData = base64_decode($base64Data);

        // Generate a unique filename for the image
        $filename = uniqid() . '.' . $extension;

        // Save the image to the storage disk
        Storage::disk($disk)->put($destinationPath . $filename, $imageData);

        // Return an associative array with path, url, and mime
        return $destinationPath . $filename;
    }
}
