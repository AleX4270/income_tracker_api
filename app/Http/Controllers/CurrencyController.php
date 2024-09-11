<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyFormRequest;
use App\Http\Requests\CurrencyListRequest;
use App\Interfaces\CurrencyServiceInterface;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller {
    public function __construct(
        protected CurrencyServiceInterface $currencyService
    ) {}
    
    public function index(Request $request): ApiResponse {
        $id = $request->query('id');
        if(!empty($id)) {
            return $this->details($id);
        }
        else {
            $validatedData = $request->validate((new CurrencyListRequest())->rules());
            $currencyListRequest = new CurrencyListRequest($validatedData);
            return $this->list($currencyListRequest);
        }
    }

    //Think about a better way to return data with the paginator response.
    private function list(CurrencyListRequest $request): ApiResponse {
        $response = new ApiResponse();
        $filterSet = $request->input();

        $result = $this->currencyService->list($filterSet);

        if(!empty($result)) {
            $response->data = [
                'count' => count($result),
                'items' => $result
            ];
            $response->message = 'Currency list loaded successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to load the currency list.';
        }

        return $response;
    }

    private function details($id): ApiResponse {
        $response = new ApiResponse();

        if(empty($id)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid arguments. Currency id must be provided.';
            return $response;
        }

        $currency = $this->currencyService->details($id);

        if(!empty($currency)) {
            $response->data = [
                'id' => $currency->id,
                'symbol' => $currency->symbol,
                'shortSymbol' => $currency->short_symbol
            ];
            $response->message = 'Currency details loaded successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to load the currency details or there is no currency with such id.';
        }

        return $response;
    }

    public function form(CurrencyFormRequest $request): ApiResponse {
        $params = $request->validated();

        if(!empty($params['id'])) {
            return $this->update($params);
        }
        else {
            return $this->create($params);
        }
    }

    public function create(array $params): ApiResponse {
        $response = new ApiResponse();

        if(empty($params)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid arguments. Params must be provided.';
            return $response;
        }

        $id = $this->currencyService->create($params);

        if(!empty($id)) {
            $response->data = [
                'id' => $id
            ];
            $response->message = 'Currency created successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to create a currency entry.';
        }

        return $response;
    }

    public function update(array $params): ApiResponse {
        $response = new ApiResponse();

        if(empty($params)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid arguments. Params must be provided.';
            return $response;
        }

        $id = $this->currencyService->update($params);

        if(!empty($id)) {
            $response->data = [
                'id' => $id
            ];
            $response->message = 'Currency updated successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to update a currency entry.';
        }

        return $response;
    }

    public function delete(Request $request): ApiResponse {
        $response = new ApiResponse();
        $id = $request->input('id');

        if(empty($id)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = 'Invalid arguments. Id must be provided.';
            return $response;
        }

        $isDeleted = $this->currencyService->delete($id);

        if(!empty($isDeleted)) {
            $response->message = 'Currency deleted successfully.';
        }
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'An error occured while trying to delete a currency entry.';
        }

        return $response;
    }
}
