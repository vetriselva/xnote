<template>
    <div class="p-6 bg-gray-50 min-h-screen space-y-8">
        <!-- Toast -->
        <Toast ref="toast" />

        <!-- Add Transaction Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                Add Transaction
            </h2>
            <TransactionForm
                :services="services"
                :edit-transaction="selectedTransaction"
                @transaction-added-or-updated="onTransactionAddedOrUpdated"
            />
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-green-100 rounded-lg p-6 shadow flex flex-col justify-between"
            >
                <span class="text-gray-700 font-semibold">Today's Total</span>
                <span class="text-2xl font-bold mt-2">₹{{ todayTotal }}</span>
            </div>

            <div
                v-for="p in paymentSummary"
                :key="p.payment_mode"
                class="bg-blue-100 rounded-lg p-6 shadow flex flex-col justify-between"
            >
                <span class="text-gray-700 font-semibold">{{
                    p.payment_mode.toUpperCase()
                }}</span>
                <span class="text-xl font-bold mt-2">₹{{ p.total }}</span>
            </div>
        </div>

        <!-- Transactions Table with Filters -->
        <div
            class="bg-white rounded-lg shadow p-6 flex flex-col h-[calc(100vh-380px)]"
        >
            <!-- Title & Filter Button -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">
                    Recent Transactions
                </h3>
                <button
                    class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50"
                    v-if="!enableFilter"
                    @click="enableFilter = !enableFilter"
                >
                    Filter
                </button>
            </div>

            <!-- Filters -->
            <div
                v-if="enableFilter"
                class="mb-4 grid grid-cols-1 sm:grid-cols-6 gap-4 items-end"
            >
                <!-- Service -->
                <div class="flex flex-col">
                    <label class="text-gray-700 font-medium mb-1"
                        >Service</label
                    >
                    <select
                        v-model="filters.service_id"
                        class="border rounded px-3 py-2 shadow-sm"
                    >
                        <option value="">All Services</option>
                        <option v-for="s in services" :key="s.id" :value="s.id">
                            {{ s.name }}
                        </option>
                    </select>
                </div>

                <!-- From Date -->
                <div class="flex flex-col">
                    <label class="text-gray-700 font-medium mb-1">From</label>
                    <input
                        type="date"
                        v-model="filters.from_date"
                        class="border rounded px-3 py-2 shadow-sm"
                    />
                </div>

                <!-- To Date -->
                <div class="flex flex-col">
                    <label class="text-gray-700 font-medium mb-1">To</label>
                    <input
                        type="date"
                        v-model="filters.to_date"
                        class="border rounded px-3 py-2 shadow-sm"
                    />
                </div>

                <!-- Filter Button -->
                <div class="flex flex-col">
                    <button
                        @click="applyFilters"
                        class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700"
                    >
                        Filter
                    </button>
                </div>

                <!-- Reset Button -->
                <div class="flex flex-col">
                    <button
                        @click="resetFilters"
                        class="bg-gray-300 px-4 py-2 rounded shadow hover:bg-gray-400"
                    >
                        Reset
                    </button>
                </div>

                <!-- Close Filter -->
                <div class="flex flex-col" v-if="enableFilter">
                    <button
                        @click="enableFilter = !enableFilter"
                        class="bg-gray-300 px-4 py-2 rounded shadow hover:bg-gray-400"
                    >
                        Close Filter
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="flex-1 overflow-y-auto border rounded">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="text-left sticky top-0 bg-gray-100 z-10">
                        <tr>
                            <th class="px-4 py-2 border-b">Service</th>
                            <th class="px-4 py-2 border-b">Qty</th>
                            <th class="px-4 py-2 border-b">Total</th>
                            <th class="px-4 py-2 border-b">Mode</th>
                            <th class="px-4 py-2 border-b">Date</th>
                            <th class="px-4 py-2 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Transactions rows -->
                        <tr
                            v-for="t in recentTxns.data"
                            :key="t.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="px-4 py-2 border-b">
                                {{ t.service.name }}
                            </td>
                            <td class="px-4 py-2 border-b">{{ t.quantity }}</td>
                            <td class="px-4 py-2 border-b">
                                ₹{{ t.total_amount }}
                            </td>
                            <td class="px-4 py-2 border-b">
                                {{ t.payment_mode.toUpperCase() }}
                            </td>
                            <td class="px-4 py-2 border-b">
                                {{ t.created_at }}
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a
                                    class="text-blue-600 mr-2 cursor-pointer"
                                    @click="handleEdit(t)"
                                    >Edit</a
                                >
                                <a
                                    class="text-red-600 cursor-pointer"
                                    @click="handleDelete(t)"
                                    >Delete</a
                                >
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="recentTxns.data.length === 0">
                            <td colspan="6" class="py-10">
                                <div
                                    class="flex flex-col items-center justify-center text-gray-500"
                                >
                                    <!-- SVG -->
                                    <svg
                                        width="120"
                                        height="120"
                                        viewBox="0 0 200 200"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <circle
                                            cx="100"
                                            cy="100"
                                            r="90"
                                            fill="#F3F4F6"
                                        />
                                        <path
                                            d="M60 85h80v45H60z"
                                            fill="#E5E7EB"
                                        />
                                        <path
                                            d="M70 65h60v20H70z"
                                            fill="#D1D5DB"
                                        />
                                        <text
                                            x="100"
                                            y="150"
                                            text-anchor="middle"
                                            font-family="Segoe UI, Arial"
                                            font-size="12"
                                            fill="#6B7280"
                                        >
                                            No records yet
                                        </text>
                                    </svg>

                                    <p class="mt-2 font-medium">
                                        No transactions found
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 flex justify-center gap-2">
                <button
                    :disabled="!recentTxns.prev_page_url"
                    @click="fetchTransactions(recentTxns.current_page - 1)"
                    class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50"
                >
                    Prev
                </button>

                <span class="px-3 py-1"
                    >{{ recentTxns.current_page }} /
                    {{ recentTxns.last_page }}</span
                >

                <button
                    :disabled="!recentTxns.next_page_url"
                    @click="fetchTransactions(recentTxns.current_page + 1)"
                    class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

import TransactionForm from "./TransactionForm.vue";
import Toast from "./Toast.vue";

/* state */
const todayTotal = ref(0);
const paymentSummary = ref([
    { payment_mode: "Cash", total: 10 },
    { payment_mode: "UPI", total: 100 },
    { payment_mode: "Other", total: 100 },
]);
const serviceChart = ref([]);
const dayChart = ref([]);
const enableFilter = ref(false);
const selectedTransaction = ref(null);

const recentTxns = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    next_page_url: null,
    prev_page_url: null,
});

const services = ref([]);
const toast = ref(null);

const onTransactionAddedOrUpdated = (updateMode) => {
    updateMode
        ? toast.value.show("Transaction updated successfully")
        : toast.value.show("Transaction added successfully");
    refreshData();
};

/* methods */
const refreshData = () => {
    axios.get("/dashboard/data").then((res) => {
        todayTotal.value = res.data.todayTotal;
        paymentSummary.value = res.data.paymentSummary;
        serviceChart.value = res.data.serviceChart;
        dayChart.value = res.data.dayChart;
        services.value = res.data.services;
    });
    fetchTransactions(1);
    selectedTransaction.value = null;
};

const filters = ref({
    service_id: "",
    from_date: "",
    to_date: "",
});

const fetchTransactions = async (page = 1) => {
    const params = {
        page,
        service_id: filters.value.service_id,
        from_date: filters.value.from_date,
        to_date: filters.value.to_date,
    };
    const res = await axios.get("/transactions/recent-items", { params });
    recentTxns.value = res.data;
};

const applyFilters = () => {
    fetchTransactions(1);
};

const resetFilters = () => {
    filters.value = { service_id: "", from_date: "", to_date: "" };
    fetchTransactions();
};

const onload = () => {
    refreshData();
    fetchTransactions();
};
/* lifecycle */
onMounted(() => {
    onload();
});

const handleEdit = (transaction) => {
    selectedTransaction.value = transaction;
};

const handleDelete = async (transaction) => {
    await axios.delete(`/transactions/${transaction.id}`);
    onload();
};
</script>
