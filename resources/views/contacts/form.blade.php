<div
    x-data="{
        hasReminder: {{ old('has_reminder', isset($contact) && $contact->reminder_at ? 'true' : 'false') }}
    }"
    class="space-y-4"
>
    <!-- Name -->
    <div>
        <label class="block font-medium">Name</label>
        <input name="name"
               value="{{ old('name', $contact->name ?? '') }}"
               class="w-full border rounded px-3 py-2">
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <!-- Phone -->
    <div>
        <label class="block font-medium">Phone</label>
        <input name="phone"
               value="{{ old('phone', $contact->phone ?? '') }}"
               class="w-full border rounded px-3 py-2">
        @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <!-- Email -->
    <div>
        <label class="block font-medium">Email</label>
        <input name="email"
               value="{{ old('email', $contact->email ?? '') }}"
               class="w-full border rounded px-3 py-2">
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

    </div>

    <!-- Others -->
    <div>
        <label class="block font-medium">Others</label>
        <input name="others"
               value="{{ old('others', $contact->others ?? '') }}"
               class="w-full border rounded px-3 py-2">
        @error('others') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

    </div>

    <!-- Reminder Checkbox -->
    <div class="flex items-center gap-2">
        <input
            type="checkbox"
            name="has_reminder"
            value="1"
            x-model="hasReminder"
            class="rounded border-gray-300"
        >
        <label class="text-sm text-gray-700">
            Set as reminder
        </label>
    </div>

    <!-- Reminder Fields -->
    <div
        x-show="hasReminder"
        x-transition
        class="grid grid-cols-1 sm:grid-cols-2 gap-4"
    >
        <div>
            <label class="block font-medium">Reminder Date</label>
            <input
                type="datetime-local"
                name="reminder_at"
                value="{{ old('reminder_at', isset($contact) && $contact->reminder_at ? $contact->reminder_at->format('Y-m-d\TH:i') : '') }}"
                class="w-full border rounded px-3 py-2"
            >
            @error('reminder_at') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium">Reminder Note</label>
            <input
                type="text"
                name="reminder_note"
                value="{{ old('reminder_note', $contact->reminder_note ?? '') }}"
                class="w-full border rounded px-3 py-2"
                placeholder="Call back / Payment follow-up"
            >
            @error('reminder_note') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
