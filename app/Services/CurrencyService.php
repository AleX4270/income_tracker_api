<?php 

namespace App\Services;

use App\Interfaces\CurrencyServiceInterface;
use App\Models\Currency;
use App\Models\Income;
use App\Models\IncomeCategoryIncome;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyService implements CurrencyServiceInterface {

    //TODO: Make sure those filters are implemented correctly.
    public function list(array $params): LengthAwarePaginator | bool {
        try {
            // $query = Income::query()
            // ->select(
            //     'income.id', 
            //     'users.name', 
            //     DB::raw('CONCAT(currency.symbol, " (", currency.short_symbol, ")") as currencySymbol'),
            //     'income.amount',
            //     'income.date_received',
            //     'income.description'
            // )
            // ->join('users', 'income.user_id', '=', 'users.id')
            // ->join('currency', 'income.currency_id', '=', 'currency.id')
            // ->where('income.is_active', 1);

            // if(!empty($params['userId'])) {
            //     $query->where('income.user_id', intval($params['userId']));
            // }

            // if(!empty($params['currencyId'])) {
            //     $query->where('income.currency_id', intval($params['currencyId']));
            // }

            // if(!empty($params['amountMin'])) {
            //     $query->where('income.amount', '>=', intval($params['amountMin']));
            // }

            // if(!empty($params['amountMax'])) {
            //     $query->where('income.amount', '<=', intval($params['amountMax']));
            // }

            // if(!empty($params['dateFrom'])) {
            //     $query->where('income.date_received', '>=', $params['dateFrom']);
            // }

            // if(!empty($params['dateTo'])) {
            //     $query->where('income.date_received', '<=', $params['dateTo']);
            // }

            // if(!empty($params['description'])) {
            //     $query->whereRaw('LOWER(income.description) = ?', [mb_strtolower($params['description'])]);
            // }

            // if(!empty($params['sortDir']) && !empty($params['sortColumn'])) {
            //     $query->orderBy($params['sortColumn'], $params['sortDir']);
            // }

            // $incomes = $query->paginate(intval($params['pageSize']));

            // return $incomes;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function details(int $id): Currency | bool {
        try {
            // return Income::where('id', intval($id))->first();
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function create(array $params): int | bool {
        try {
            // $income = new Income();
            // $income->user_id = auth()->user()->id;
            // $income->currency_id = $params['currencyId'];
            // $income->amount = $params['amount'];
            // $income->date_received = $params['dateReceived'];
            // $income->description = $params['description'];
            // $income->save();

            // foreach(explode(",", $params['categoryIds']) as $categoryId) {
            //     $incomeCategoryIncome = new IncomeCategoryIncome();
            //     $incomeCategoryIncome->income_id = $income->id;
            //     $incomeCategoryIncome->income_category_id = intval($categoryId);
            //     $incomeCategoryIncome->save();
            // }

            // return $income->id;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update(array $params): int | bool {
        try {
            // $income = Income::where('id', $params['id'])->first();
            // $income->user_id = auth()->user()->id;
            // $income->currency_id = $params['currencyId'];
            // $income->amount = $params['amount'];
            // $income->date_received = $params['dateReceived'];
            // $income->description = $params['description'];
            // $income->save();

            // IncomeCategoryIncome::where('income_id', $income->id)->delete();
            // foreach(explode(",", $params['categoryIds']) as $categoryId) {
            //     $incomeCategoryIncome = new IncomeCategoryIncome();
            //     $incomeCategoryIncome->income_id = $income->id;
            //     $incomeCategoryIncome->income_category_id = intval($categoryId);
            //     $incomeCategoryIncome->save();
            // }

            // return $income->id;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            // $income = Income::where('id', $id)->first();
            // $income->is_active = 0;
            // $income->save();

            // return true;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}