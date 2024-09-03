<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Interfaces\IncomeServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeListRequest;
use Symfony\Component\HttpFoundation\Response;

class IncomeController extends Controller {
    public function __construct(
        protected IncomeServiceInterface $incomeService
    ) {}

    public function list(IncomeListRequest $request): ApiResponse {
        $response = new ApiResponse();
        $params = $request->validated();

        $result = $this->incomeService->list($params);

        if(!empty($result)) {
            $response->data = [
                'count' => count($result),
                'items' => $result
            ];
            $response->message = 'Income list loaded successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to load the income list.';
        }

        return $response;
    }
}
