<?php

namespace App\Interfaces;

use App\Models\Income;

interface IncomeServiceInterface {
    public function list(array $params): array | bool;
    public function details(): Income;
    public function create(): bool;
    public function update(): bool;
    public function delete(): bool; 
}