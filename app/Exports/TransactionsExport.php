<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function __construct(
        private ?int $serviceId,
        private ?string $fromDate,
        private ?string $toDate
    ) {}

    public function collection()
    {
        $query = Transaction::with('service');

        if ($this->serviceId) {
            $query->where('service_id', $this->serviceId);
        }

        if ($this->fromDate && $this->toDate) {
            $query->whereDate('created_at', '>=', $this->fromDate)
                  ->whereDate('created_at', '<=', $this->toDate);
        }

        return $query->latest()->get()->map(function ($transaction) {
            return [
                'Service'       => $transaction->service->name,
                'Quantity'      => $transaction->quantity,
                'Total Amount'  => $transaction->total_amount,
                'Payment Mode'  => ucfirst($transaction->payment_mode),
                'Date'          => Date::parse($transaction->created_at)->format('d-m-Y H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Service',
            'Quantity',
            'Total Amount',
            'Payment Mode',
            'Date',
        ];
    }
}