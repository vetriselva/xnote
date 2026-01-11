<x-app-layout>
    <div class="p-6">

        <h1 class="text-xl font-bold mb-4">Today Transactions</h1>

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th>Service</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr class="border-t">
                    <td>{{ $t->service->name }}</td>
                    <td>{{ $t->quantity }}</td>
                    <td>₹ {{ $t->total_amount }}</td>
                    <td>{{ strtoupper($t->payment_mode) }}</td>
                    <td>{{ $t->transaction_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
