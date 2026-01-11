<?php
namespace App\Repositories\Contracts;

use App\Models\Transaction;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function updateById(int $id, array $data): bool;
    public function create(array $data): Transaction;
    public function delete(int $id): bool;
    public function todayTotal(): float;

    public function dailySummary(): Collection;
}
