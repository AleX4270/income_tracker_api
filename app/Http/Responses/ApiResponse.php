<?php 

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ApiResponse implements Responsable {
    public int $status;
    public array $data;
    public string $message;

    public function __construct(array $data = [], int $status = 200, string $message = '') {
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }

    public function toResponse($request): JsonResponse {
        return response()->json([
            'data' => $this->data,
            'message' => $this->message
        ], $this->status);
    }
}