<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    /**
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'code' => $code
        ]);
    }

    /**
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($error, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => $error,
            'code' => $code
        ]);
    }
}
