<template>
    <form
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 bg-white p-4 rounded shadow"
    >
        <!-- Service -->
        <div class="flex flex-col col-span-1">
            <label class="text-sm text-gray-600 mb-1">Service</label>
            <select
                v-model="form.service_id"
                class="border rounded px-2 py-1"
                required
            >
                <option value="" disabled>Select service</option>
                <option v-for="s in services" :key="s.id" :value="s.id">
                    {{ s.name }} <span v-if="s.is_default">(Default)</span>
                </option>
            </select>
        </div>

        <!-- Quantity -->
        <div class="flex flex-col col-span-1">
            <label class="text-sm text-gray-600 mb-1">Quantity</label>
            <input
                v-model.number="form.quantity"
                type="number"
                min="1"
                class="border rounded px-2 py-1"
            />
        </div>

        <!-- Unit Price -->
        <div class="flex flex-col col-span-1">
            <label class="text-sm text-gray-600 mb-1">Unit Price</label>
            <input
                v-model.number="form.unit_price"
                type="number"
                min="0"
                class="border rounded px-2 py-1"
            />
        </div>

        <!-- Payment Mode -->
        <div class="flex flex-col col-span-1">
            <label class="text-sm text-gray-600 mb-1">Payment Mode</label>
            <select
                v-model="form.payment_mode"
                class="border rounded px-2 py-1"
            >
                <option value="cash">Cash</option>
                <option value="upi">UPI</option>
                <option value="card">Card</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex items-end col-span-1">
    <button
        type="submit"
        :class="isEditMode
            ? 'bg-green-600 text-white rounded px-4 py-2 w-full'
            : 'bg-blue-600 text-white rounded px-4 py-2 w-full'"
            @click="submit"
    >
        {{ isEditMode ? 'Update' : 'Save' }}
    </button>

    <button v-if="isEditMode"
        type="submit"
        class="bg-red-600 ml-2 text-white rounded px-4 py-2 w-full"
        @click="handleReset"
    >
        Reset
    </button>
</div>

    </form>
</template>


<script setup>
import { computed, reactive, ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
    editTransaction: {
        type: Object,
        default: null,
    },
    services: {
        type: Array,
        required: true,
    },
});

const isEditMode = ref(false);

const emit = defineEmits(["transaction-added-or-updated"]);

const form = reactive({
    service_id: "",
    quantity: 1,
    unit_price: 0,
    payment_mode: "cash",
});

const handleReset = (event) => {
    event.preventDefault();
    resetForm();
    isEditMode.value = false;
}


const resetForm = () => {
    const defaultService = props.services.find((s) => s.is_default);

    if (defaultService) {
        form.unit_price = defaultService.price;
        form.service_id = defaultService.id;
    }
};

watch(
    () => form.service_id,
    () => {
        const service = props.services.find((s) => s.id == form.service_id);

        if (service) {
            form.unit_price = service.price;
        }
    },
    { immediate: true }
);

watch(
    () => props.editTransaction?.id,
    () => {
        isEditMode.value = props.editTransaction?.id != null
    },
    { immediate: true }
);

watch(
    () => props.services,
    (list) => {
        const defaultService = list.find((s) => s.is_default);

        if (defaultService && !form.service_id) {
            form.unit_price = defaultService.price;
            form.service_id = defaultService.id;
        }
    },
    { immediate: true }
);

watch(
    () => props.editTransaction,
    (tx) => {
        if (tx) {
            form.service_id = tx.service_id;
            form.quantity = tx.quantity;
            form.unit_price = tx.unit_price ?? 0;
            form.payment_mode = tx.payment_mode;
        } else {
            resetForm();
        }
    },
    { immediate: true }
);


/* ✅ SUBMIT */
const submit = async (event) => {
    event.preventDefault();
    if (isEditMode.value) {
        await axios.post(`/transactions/${props.editTransaction.id}`, form);
    } else {
        await axios.post("/transactions", form);
    }

    resetForm();
    emit("transaction-added-or-updated", isEditMode.value);
};
</script>
