<?php 

namespace App\Services;

use App\Interfaces\CurrencyServiceInterface;
use App\Models\Currency;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CurrencyService implements CurrencyServiceInterface {

    //TODO: Make sure those filters are implemented correctly.
    public function list(array $filterSet): LengthAwarePaginator | bool {
        try {
            $query = Currency::query()
            ->select(
                'currency.id',
                'currency.symbol',
                'currency.short_symbol',
            )
            ->where('currency.is_active', 1);

            if(!empty($filterSet['symbol'])) {
                $query->whereRaw('LOWER(currency.symbol) = ?', [mb_strtolower($filterSet['symbol'])]);
            }

            if(!empty($params['sortDir']) && !empty($params['sortColumn'])) {
                $query->orderBy($filterSet['sortColumn'], $filterSet['sortDir']);
            }

            $currencies = $query->paginate(intval($filterSet['pageSize']));

            return $currencies;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function details(int $currencyId): Currency | bool {
        try {
            $currency = Currency::where('id', intval($currencyId))->first();

            if(empty($currency)) {
                return false;
            }

            return $currency;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function create(array $fieldSet): int | bool {
        try {
            $currency = new Currency();
            $currency->symbol = $fieldSet['symbol'];
            
            if(!empty($fieldSet['shortSymbol'])) {
                $currency->short_symbol = $fieldSet['shortSymbol'];
            }
            
            if(!$currency->save()) {
                throw new Exception('Could not create a new currency entry.');
            }

            return $currency->id;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update(array $filterSet): int | bool {
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