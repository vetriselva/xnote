<x-app-layout>
<div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add Service</h2>

    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input name="name"
                   value="{{ old('name') }}"
                   class="w-full border px-3 py-2 rounded">
            @error('name') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input name="price"
                   type="number"
                   value="{{ old('price') }}"
                   class="w-full border px-3 py-2 rounded">
            @error('price') <p class="text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3 flex items-center gap-2">
            <input type="hidden" name="is_default" value="0">

            <input
                type="checkbox"
                name="is_default"
                value="1"
                class="rounded border-gray-300"
            >
            <label class="text-sm text-gray-700">
                Set as default service
            </label>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Save Service
        </button>
    </form>
</div>
</x-app-layout>
