<x-app-layout>
    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

        <h2 class="text-xl font-bold mb-4">Add Contact</h2>

        <form method="POST" action="{{ route('contacts.store') }}" class="space-y-4">
            @csrf

            @include('contacts.form')

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save
            </button>
        </form>

    </div>
</x-app-layout>
