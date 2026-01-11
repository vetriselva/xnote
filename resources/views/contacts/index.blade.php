<x-app-layout>
    <div class="mx-auto p-6 space-y-4">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-white text-2xl font-bold">Contacts</h2>

            <a href="{{ route('contacts.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                + Add Contact
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white shadow rounded overflow-x-auto">

            <form method="GET" class="p-2 flex-end mb-4 flex gap-3 items-center">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name, phone, email, company..."
                class="border rounded px-3 py-2 w-full max-w-md"
            >
            <label class="flex items-center gap-1 text-sm">
                <input type="checkbox" name="overdue" value="1"
                    {{ request('overdue') == '1' ? 'checked' : '' }}>
                Overdue Reminders
            </label>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Filter
            </button>

            @if(request()->has('search'))
                <a href="{{ route('contacts.index') }}"
                class="bg-gray-300 px-4 py-2 rounded">
                    Reset
                </a>
            @endif
            </form>


            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Phone</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Company</th>
                        <th class="p-3 text-left">Reminder</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($contacts as $contact)
                        <tr class="border-t">
                            <td class="p-3 font-medium">
                                {{ $contact->name }}
                            </td>

                            <td class="p-3">
                                {{ $contact->phone ?? '—' }}
                            </td>

                            <td class="p-3">
                                {{ $contact->email ?? '—' }}
                            </td>

                            <td class="p-3">
                                {{ $contact->company ?? '—' }}
                            </td>

                            <td class="p-3">
                                @if($contact->reminder_at)
                                    <div class="text-sm">
                                        <div class="{{ $contact->reminder_at->isPast() ? 'text-red-600 font-semibold' : 'text-green-600' }}">
                                            {{ $contact->reminder_at->format('d M Y, h:i A') }}
                                        </div>
                                        <div class="text-gray-500 text-xs">
                                            {{ $contact->reminder_note }}
                                        </div>
                                    </div>
                                @else
                                    —
                                @endif
                            </td>

                            <td class="p-3 flex gap-3">
                                <a href="{{ route('contacts.edit', $contact) }}"
                                   class="text-blue-600 hover:underline">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('contacts.destroy', $contact) }}"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <!-- Empty State -->
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-20 h-20 text-gray-300"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.5"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/>
                                    </svg>

                                    <p class="text-sm">No contacts yet</p>

                                    <a href="{{ route('contacts.create') }}"
                                       class="text-blue-600 underline">
                                        Add your first contact
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $contacts->links() }}

    </div>
</x-app-layout>
