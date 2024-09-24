<?php 

namespace App\Services;

use App\Interfaces\IncomeCategoryServiceInterface;
use App\Models\IncomeCategory;
use App\Models\IncomeCategoryTranslation;
use App\Models\Language;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
            ->where('language.symbol', app()->getLocale())
            ->where('language.is_active', 1)
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

    public function details(int $incomeCategoryId): IncomeCategory | bool {
        try {
            $incomeCategory = IncomeCategory::where('id', intval($incomeCategoryId))->first();

            if(empty($incomeCategory)) {
                return false;
            }

            return $incomeCategory;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    //This probably can be secured from creating an identical category.
    public function create(array $fieldSet): int | bool {
        DB::beginTransaction();
        try {
            $incomeCategory = new IncomeCategory();
            $incomeCategory->symbol = str()->random(24);
            if(!$incomeCategory->save()) {
                throw new Exception('Could not create a new income category entry.');
            }
            
            $currentLanguage = Language::where('symbol', app()->getLocale())->firstOrFail();

            $incomeCategoryTranslation = new IncomeCategoryTranslation();
            $incomeCategoryTranslation->income_category_id = $incomeCategory->id;
            $incomeCategoryTranslation->name = $fieldSet['name'];
            $incomeCategoryTranslation->description = $fieldSet['description'];
            $incomeCategoryTranslation->language_id = $currentLanguage->id;
            
            if(!$incomeCategoryTranslation->save()) {
                throw new Exception('Could not save an income category translation entry.');
            }

            DB::commit();
            return $incomeCategory->id;
        }
        catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function update(array $fieldSet): int | bool {
        DB::beginTransaction();
        try {
            //Strange. Maybe there is some other way to update the dates.
            $incomeCategory = IncomeCategory::where('id', $fieldSet['id'])->firstOrFail();
            if(!$incomeCategory->save()) {
                throw new Exception('Could not update an existing income category entry.');
            }

            $incomeCategoryTranslation = IncomeCategoryTranslation::where('income_category_id', $incomeCategory->id)->first();
            
            if(empty($incomeCategoryTranslation)) {
                $incomeCategoryTranslation = new IncomeCategoryTranslation();
            }

            $currentLanguage = Language::where('symbol', app()->getLocale())->firstOrFail();
            $incomeCategoryTranslation->income_category_id = $incomeCategory->id;
            $incomeCategoryTranslation->name = $fieldSet['name'];
            $incomeCategoryTranslation->description = $fieldSet['description'];
            $incomeCategoryTranslation->language_id = $currentLanguage->id;

            if(!$incomeCategoryTranslation->save()) {
                throw new Exception('Could not save an income category translation entry.');
            }

            DB::commit();
            return $incomeCategory->id;
        }
        catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            $incomeCategory = IncomeCategory::where('id', $id)->firstOrFail();
            $incomeCategory->is_active = 0;
            
            if(!$incomeCategory->save()) {
                throw new Exception('Could not update an income category entry.');
            }

            return true;
        }
        catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}