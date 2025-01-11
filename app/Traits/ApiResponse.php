<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api ApiResponse Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  int|null  $code
     */
    protected function success($data, ?string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  array|string|null  $data
     */
    protected function error(?string $message, int $code, $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
