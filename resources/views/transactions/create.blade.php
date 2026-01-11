<x-app-layout>
    <div class="max-w-xl mx-auto p-6">

        <h1 class="text-xl font-bold mb-4">Add Transaction</h1>

        <form method="POST" action="{{ route('transactions.store') }}">
            @csrf

            <div class="mb-3">
                <label>Service</label>
                <select name="service_id" class="w-full border rounded">
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" name="quantity" class="w-full border rounded" value="1">
            </div>

            <div class="mb-3">
                <label>Unit Price</label>
                <input type="number" step="0.01" name="unit_price" class="w-full border rounded">
            </div>

            <div class="mb-3">
                <label>Payment Mode</label>
                <select name="payment_mode" class="w-full border rounded">
                    <option value="cash">Cash</option>
                    <option value="upi">UPI</option>
                    <option value="card">Card</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Date</label>
                <input type="date" name="transaction_date" class="w-full border rounded"
                       value="{{ date('Y-m-d') }}">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Transaction
            </button>

        </form>

    </div>
</x-app-layout>
