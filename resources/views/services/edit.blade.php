<x-app-layout>
<div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Service</h2>

    <form method="POST" action="{{ route('services.update', $service) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input name="name"
                   value="{{ old('name', $service->name) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input name="price"
                   type="number"
                   value="{{ old('price', $service->price) }}"
                   class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-3 flex items-center gap-2">
            <input type="hidden" name="is_default" value="0">
            <input
                type="checkbox"
                name="is_default"
                value="1"
                class="rounded border-gray-300"
                {{ old('is_default', $service->is_default) ? 'checked' : '' }}
            >
            <label class="text-sm text-gray-700">
                Set as default service
            </label>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Service
        </button>
    </form>
</div>
</x-app-layout>
