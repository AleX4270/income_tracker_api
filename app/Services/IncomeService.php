<?php 

namespace App\Services;

use App\Interfaces\IncomeServiceInterface;
use App\Models\Income;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class IncomeService implements IncomeServiceInterface { 

    //TODO: Make sure those filters are implemented correctly.
    public function list(array $params): LengthAwarePaginator | bool {
        try {
            $query = Income::query()
            ->select(
                'income.id', 
                'users.name', 
                DB::raw('CONCAT(currency.symbol, " (", currency.short_symbol, ")") as currencySymbol'),
                'income.amount',
                'income.date_received',
                'income.description'
            )
            ->join('users', 'income.user_id', '=', 'users.id')
            ->join('currency', 'income.currency_id', '=', 'currency.id');

            if(!empty($params['userId'])) {
                $query->where('income.user_id', intval($params['userId']));
            }

            if(!empty($params['currencyId'])) {
                $query->where('income.currency_id', intval($params['currencyId']));
            }

            if(!empty($params['amountMin'])) {
                $query->where('income.amount', '>=', intval($params['amountMin']));
            }

            if(!empty($params['amountMax'])) {
                $query->where('income.amount', '<=', intval($params['amountMax']));
            }

            if(!empty($params['dateFrom'])) {
                $query->where('income.date_received', '>=', $params['dateFrom']);
            }

            if(!empty($params['dateTo'])) {
                $query->where('income.date_received', '<=', $params['dateTo']);
            }

            if(!empty($params['description'])) {
                $query->whereRaw('LOWER(income.description) = ?', [mb_strtolower($params['description'])]);
            }

            if(!empty($params['sortDir']) && !empty($params['sortColumn'])) {
                $query->orderBy($params['sortColumn'], $params['sortDir']);
            }

            $incomes = $query->paginate(intval($params['pageSize']));

            return $incomes;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function details(int $id): Income | bool{
        try {
            return Income::where('id', intval($id))->first();
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function create(): bool {

    }

    public function update(): bool {

    }

    public function delete(): bool {

    }
}