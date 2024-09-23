<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Interfaces\IncomeServiceInterface;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeListRequest;
use App\Http\Requests\IncomeFormRequest;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class IncomeController extends Controller {
    public function __construct(protected IncomeServiceInterface $incomeService) {}

    public function index(Request $request): ApiResponse {
        $id = $request->query("id");
        if (!empty($id)) {
            return $this->details($id);
        } 
        else {
            $validatedData = $request->validate(
                (new IncomeListRequest())->rules()
            );
            $incomeListRequest = new IncomeListRequest($validatedData);
            return $this->list($incomeListRequest);
        }
    }

    //Think about a better way to return data with the paginator response.
    private function list(IncomeListRequest $request): ApiResponse {
        $response = new ApiResponse();
        $params = $request->input();

        $result = $this->incomeService->list($params);

        if (!empty($result)) {
            $response->data = [
                "count" => count($result),
                "items" => $result,
            ];
            $response->message = "Income list loaded successfully.";
        } 
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message =
                "An error occured while trying to load the income list.";
        }

        return $response;
    }

    private function details($id): ApiResponse {
        $response = new ApiResponse();

        if (empty($id)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message =
                "Invalid arguments. Income id must be provided.";
            return $response;
        }

        $income = $this->incomeService->details($id);

        if (!empty($income)) {
            $response->data = [
                "id" => $income->id,
                "username" => $income->user->name,
                "currencySymbol" => $income->currency->symbol,
                "amount" => $income->amount,
                "date_received" => $income->date_received,
                "description" => $income->description,
                "date_creation" => $income->created_at,
                "categorySymbols" => $income->categories->map(function ($item) {
                    //TODO: Get symbol for now. In the future determine the language id.
                    return $item->symbol;
                }),
            ];
            $response->message = "Income details loaded successfully.";
        } 
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message =
                "An error occured while trying to load the income details.";
        }

        return $response;
    }

    public function form(IncomeFormRequest $request): ApiResponse {
        $response = new ApiResponse();
        $params = $request->validated();

        if (!empty($params["id"]) && $request->isMethod(Request::METHOD_PUT)) {
            return $this->update($params);
        } 
        elseif (empty($params["id"]) && $request->isMethod(Request::METHOD_POST)) {
            return $this->create($params);
        } 
        else {
            $response->status = Response::HTTP_METHOD_NOT_ALLOWED;
            $response->message = "Invalid method.";
            return $response;
        }
    }

    public function create(array $params): ApiResponse {
        $response = new ApiResponse();

        if (empty($params)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = "Invalid arguments. Params must be provided.";
            return $response;
        }

        $id = $this->incomeService->create($params);

        if (!empty($id)) {
            $response->data = [
                "id" => $id,
            ];
            $response->message = "Income created successfully.";
        } 
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message =
                "An error occured while trying to create an income entry.";
        }

        return $response;
    }

    public function update(array $params): ApiResponse {
        $response = new ApiResponse();

        if (empty($params)) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message = "Invalid arguments. Params must be provided.";
            return $response;
        }

        $id = $this->incomeService->update($params);

        if (!empty($id)) {
            $response->data = [
                "id" => $id,
            ];
            $response->message = "Income updated successfully.";
        } 
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message =
                "An error occured while trying to update an income entry.";
        }

        return $response;
    }

    public function delete(Request $request): ApiResponse {
        $response = new ApiResponse();
        $validator = Validator::make($request->all(), [
            "id" => ["required", "numeric"],
        ]);

        if ($validator->fails()) {
            $response->status = Response::HTTP_BAD_REQUEST;
            $response->message =
                "Invalid arguments. Numeric id must be provided.";
            return $response;
        }

        $validatedData = $validator->validated();
        $isDeleted = $this->incomeService->delete($validatedData["id"]);

        if (!empty($isDeleted)) {
            $response->message = "Income deleted successfully.";
        } 
        else {
            $response->status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message =
                "An error occured while trying to delete an income entry.";
        }

        return $response;
    }
}
