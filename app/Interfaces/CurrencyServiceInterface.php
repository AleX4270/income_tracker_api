<?php

namespace App\Interfaces;

use App\Models\Currency;
use Illuminate\Pagination\LengthAwarePaginator;

interface CurrencyServiceInterface {
    public function list(array $filterSet): LengthAwarePaginator | bool;
    public function details(int $currencyId): Currency | bool;
    public function create(array $fieldSet): int | bool;
    public function update(array $fieldSet): int | bool;
    public function delete(int $id): bool; 
}