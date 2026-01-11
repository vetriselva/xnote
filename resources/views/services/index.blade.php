<x-app-layout>
<div class="mx-auto p-6 space-y-4">

    <div class="flex justify-between items-center">
        <h2 class="text-white text-2xl font-bold">Services</h2>
        <a href="{{ route('services.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Service
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Default</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr class="border-t">
                        <td class="p-3">{{ $service->name }}</td>
                        <td class="p-3">₹{{ $service->price }}</td>
                        <td class="px-4 py-2">
                            @if($service->is_default)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                    Default
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3 flex gap-2">
                            <a href="{{ route('services.edit', $service) }}"
                               class="text-blue-600">Edit</a>

                            <form method="POST"
                                    action="{{ route('services.destroy', $service) }}"
                                    onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $services->links() }}
</div>
</x-app-layout>
