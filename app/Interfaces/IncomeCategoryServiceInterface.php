<?php

namespace App\Interfaces;

use App\Models\IncomeCategory;
use Illuminate\Pagination\LengthAwarePaginator;

interface IncomeCategoryServiceInterface {
    public function list(array $filterSet): LengthAwarePaginator | bool;
    public function details(int $currencyId): IncomeCategory | bool;
    public function create(array $fieldSet): int | bool;
    public function update(array $fieldSet): int | bool;
    public function delete(int $id): bool;
}