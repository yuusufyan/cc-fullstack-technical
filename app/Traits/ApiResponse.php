<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
  protected function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
  {
    return response()->json([
      'status' => 'success',
      'code' => $code,
      'message' => $message,
      'data' => $data,
    ], $code);
  }

  protected function error(string $message = 'Error', int $code = 500, $data = null): JsonResponse
  {
    return response()->json([
      'status' => 'error',
      'code' => $code,
      'message' => $message,
      'data' => $data,
    ], $code);
  }
}
