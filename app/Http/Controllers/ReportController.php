<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class ReportController extends Controller {
    public function charts()
    {
        $monthlySales = Transaction::where('tenant_id', auth()->user()->tenant_id)
            ->selectRaw("
                DATE_FORMAT('%Y-%m', created_at) as month,
                SUM(total_amount) as total
            ")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $salesLabels = $monthlySales->map(function ($row) {
            return Carbon::createFromFormat('Y-m', $row->month)->format('M Y');
        });

        $services = Transaction::selectRaw('services.name as service, SUM(transactions.total_amount) as total')
            ->join('services', 'services.id', '=', 'transactions.service_id')
            ->groupBy('services.name')
            ->orderBy('total', 'desc')
            ->get();

        return view('reports.charts', [
            'serviceLabels' => $services->pluck('service'),
            'serviceValues' => $services->pluck('total'),
            'labels' => $salesLabels,
            'values' => $monthlySales->pluck('total'),
        ]);
    }
}