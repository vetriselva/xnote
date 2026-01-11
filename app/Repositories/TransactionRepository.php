<?php
namespace App\Repositories;

use App\Dao\TransactionDao;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Support\Collection;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function __construct(
        private TransactionDao $dao
    ) {}

    public function updateById(int $id, array $data): bool
    {
        $data['total_amount'] = $data['quantity'] * $data['unit_price'];
        return $this->dao->updateById($id, $data);
    }
    public function create(array $data): Transaction
    {
        $data['total_amount'] = $data['quantity'] * $data['unit_price'];
        return $this->dao->create($data);
    }

    public function delete(int $id): bool
    {
        return $this->dao->delete($id);
    }

    public function todayTotal(): float
    {
        return $this->dao->todayTotal();
    }

    public function dailySummary(): Collection
    {
        return $this->dao->dailySummary();
    }
}
