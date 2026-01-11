<?php
namespace App\Dao;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionDao
{
    public function find(int $id): Transaction
    {
        return Transaction::find($id);
    }
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function delete(int $id): bool
    {
        return Transaction::find($id)?->delete();
    }

    public function updateById(int $id, array $data): bool
    {
        return Transaction::findOrFail( $id)->update($data);
    }

    public function todayTotal(): float
    {
        return Transaction::whereDate('transaction_date', today())
            ->sum('total_amount');
    }

    public function dailySummary(): Collection
    {
        return Transaction::whereDate('transaction_date', today())
            ->select('payment_mode', DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_mode')
            ->get();
    }
}
