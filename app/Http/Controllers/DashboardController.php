<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'payment_mode' => 'required|in:cash,upi,card',
        ]);

        $total = $request->quantity * $request->unit_price;

        $txn = Transaction::create([
            'service_id' => $request->service_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $total,
            'payment_mode' => $request->payment_mode,
            'transaction_date' => now(),
        ]);

        return response()->json(['success' => true, 'transaction' => $txn]);
    }

    public function data()
    {
        $today = today()->toDateString();

        $todayTotal = Transaction::whereDate('transactions.created_at', $today)
            ->sum('total_amount');

        $paymentSummary = Transaction::whereDate('transactions.created_at', $today)
            ->select('payment_mode', DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_mode')
            ->get();

        $serviceChart = Transaction::whereDate('transactions.created_at', $today)
            ->join('services', 'services.id', '=', 'transactions.service_id')
            ->select('services.name', DB::raw('SUM(total_amount) as total'))
            ->groupBy('services.name')
            ->get();

        $dayChart = Transaction::whereMonth('transactions.created_at', now()->month)
            ->select(
                DB::raw('DATE(transactions.created_at) as day'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();

            $services = Service::all();

        return response()->json(compact(
            'services',
            'todayTotal',
            'paymentSummary'
        ));
    }
}
