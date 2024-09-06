<?php

namespace App\Interfaces;

use App\Models\Income;
use Illuminate\Pagination\LengthAwarePaginator;

interface IncomeServiceInterface {
    public function list(array $params): LengthAwarePaginator | bool;
    public function details(): Income;
    public function create(): bool;
    public function update(): bool;
    public function delete(): bool; 
}