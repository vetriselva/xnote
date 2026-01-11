<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Service;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepositoryInterface $repo
    ) {}

    public function dashboard()
    {
        return view('dashboard', [
            'todayTotal' => $this->repo->todayTotal(),
            'summary' => $this->repo->dailySummary(),
        ]);
    }

    public function index()
    {
        return view('transactions.index', [
            'transactions' => Transaction::latest()->get()
        ]);
    }

    public function create()
    {
        return view('transactions.create', [
            'services' => Service::all()
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {
        $this->repo->create($request->validated());

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction saved');
    }

    public function update(Request $request, $id)
    {
        return $this->repo->updateById($id, $request->all());
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function recentTransactions(Request $request)
    {
        $query = Transaction::with('service')->orderBy('created_at', 'desc');

        // ✅ Filter by service
        if ($request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        // ✅ Filter by date range
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        // ✅ Pagination
        $transactions = $query->paginate(10);

        return response()->json($transactions);
    }

}

