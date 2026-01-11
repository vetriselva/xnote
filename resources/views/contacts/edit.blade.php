<x-app-layout>
    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

        <h2 class="text-xl font-bold mb-4">Edit Contact</h2>

        <form method="POST"
              action="{{ route('contacts.update', $contact) }}"
              class="space-y-4">
            @csrf
            @method('PUT')

            @include('contacts.form', ['contact' => $contact])

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
        </form>

    </div>
</x-app-layout>
