<?php 

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ApiResponse implements Responsable {
    protected int $httpCode;
    protected array $data;
    protected string $errorMessage;

    public function __construct(array $data = [], int $httpCode = 200, string $errorMessage = 'An error occured.') {
        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->errorMessage = $errorMessage;
    }

    public function toResponse($request): JsonResponse {
        $response = [
            'status' => $this->httpCode,
        ];
        
        if($this->httpCode >= 400) {
            $response['error'] = $this->errorMessage;
        }
        else {
            $response['data'] = $this->data;
        }

        return response()->json($response);
    }
}