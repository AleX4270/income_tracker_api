<?php 

namespace App\Services;

use App\Interfaces\IncomeServiceInterface;
use App\Models\Income;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class IncomeService implements IncomeServiceInterface { 

    //TODO: Make sure those filters are implemented correctly.
    public function list(array $params): array | bool {
        try {
            $incomes = Income::with(['users', 'currency']);

            if(!empty($params['userId'])) {
                $incomes->where('income.user_id', intval($params['userId']));
            }

            if(!empty($params['currencyId'])) {
                $incomes->where('income.currency_id', intval($params['currencyId']));
            }

            if(!empty($params['amountMin'])) {
                $incomes->where('income.amount', '>=', intval($params['amountMin']));
            }

            if(!empty($params['amountMax'])) {
                $incomes->where('income.amount', '<=', intval($params['amountMax']));
            }

            if(!empty($params['dateFrom'])) {
                $incomes->where('income.date_received', '>=', intval($params['dateFrom']));
            }

            if(!empty($params['dateTo'])) {
                $incomes->where('income.date_received', '<=', intval($params['dateTo']));
            }

            if(!empty($params['description '])) {
                $incomes->where('income.description', $params['description']);
            }

            //TODO: Finish sorting and pagination

            $incomes->get()
            ->map(function ($income) {
                return [
                    'id' => $income->id,
                    'username' => $income->user->name,
                    'currencySymbol' => $income->currency->symbol . ' (' . $income->currency->short_symbol . ')',
                    'amount' => $income->amount,
                    'dateReceived' => $income->date_received,
                    'description' => $income->description
                ];
            });
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function details(): Income {

    }

    public function create(): bool {

    }

    public function update(): bool {

    }

    public function delete(): bool {

    }
}