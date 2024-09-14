<?php 

namespace App\Services;

use App\Interfaces\IncomeCategoryServiceInterface;
use App\Models\IncomeCategory;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class IncomeCategoryService implements IncomeCategoryServiceInterface {

    //TODO: Make sure those filters are implemented correctly.
    public function list(array $filterSet): LengthAwarePaginator | bool {
        try {
            $query = IncomeCategory::query()
            ->select(
                'income_category.id',
                'income_category.symbol',
                'income_category_translation.name',
                'income_category_translation.description'
            )
            ->join('income_category_translation', 'income_category_translation.income_category_id', '=', 'income_category.id')
            ->join('language', 'language.id', '=', 'income_category_translation.language_id')
            ->where('language.id', $filterSet['languageId'])
            ->where('income_category.is_active', 1);

            if(!empty($filterSet['symbol'])) {
                $query->whereRaw('LOWER(income_category.symbol) = ?', [mb_strtolower($filterSet['symbol'])]);
            }

            if(!empty($filterSet['name'])) {
                $query->whereRaw('LOWER(income_category_translation.name) = ?', [mb_strtolower($filterSet['name'])]);
            }

            if(!empty($filterSet['description'])) {
                $query->whereRaw('LOWER(income_category_translation.description) = ?', [mb_strtolower($filterSet['description'])]);
            }

            if(!empty($params['sortDir']) && !empty($params['sortColumn'])) {
                $query->orderBy($filterSet['sortColumn'], $filterSet['sortDir']);
            }

            $incomeCategories = $query->paginate(intval($filterSet['pageSize']));

            return $incomeCategories;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function details(int $currencyId): IncomeCategory | bool {
        try {
            // $currency = Currency::where('id', intval($currencyId))->first();

            // if(empty($currency)) {
            //     return false;
            // }

            // return $currency;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function create(array $fieldSet): int | bool {
        try {
            // $currency = new Currency();
            // $currency->symbol = $fieldSet['symbol'];
            
            // if(!empty($fieldSet['shortSymbol'])) {
            //     $currency->short_symbol = $fieldSet['shortSymbol'];
            // }
            
            // if(!$currency->save()) {
            //     throw new Exception('Could not create a new currency entry.');
            // }

            // return $currency->id;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update(array $fieldSet): int | bool {
        try {
            // $currency = Currency::where('id', $fieldSet['id'])->first();
            // if(empty($currency)) {
            //     throw new Exception('A currency with provided id does not exist.');
            // }

            // $currency->symbol = $fieldSet['symbol'];
            
            // if(!empty($fieldSet['shortSymbol'])) {
            //     $currency->short_symbol = $fieldSet['shortSymbol'];
            // }

            // if(!$currency->save()) {
            //     throw new Exception('Could not update a currency entry.');
            // }

            // return $currency->id;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            // $currency = Currency::where('id', $id)->first();
            // if(empty($currency)) {
            //     throw new Exception('A currency with provided id does not exist.');
            // }

            // $currency->is_active = 0;
            
            // if(!$currency->save()) {
            //     throw new Exception('Could not update a currency entry.');
            // }

            // return true;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}