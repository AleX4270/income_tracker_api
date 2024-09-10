<?php

namespace App\Interfaces;

use App\Models\Currency;
use Illuminate\Pagination\LengthAwarePaginator;

interface CurrencyServiceInterface {
    public function list(array $params): LengthAwarePaginator | bool;
    public function details(int $id): Currency | bool;
    public function create(array $params): int | bool;
    public function update(array $params): int | bool;
    public function delete(int $id): bool; 
}