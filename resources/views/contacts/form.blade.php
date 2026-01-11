<div>
    <label class="block font-medium">Name</label>
    <input name="name"
           value="{{ old('name', $contact->name ?? '') }}"
           class="w-full border rounded px-3 py-2">
    @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block font-medium">Phone</label>
    <input name="phone"
           value="{{ old('phone', $contact->phone ?? '') }}"
           class="w-full border rounded px-3 py-2">
           @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block font-medium">Email</label>
    <input name="email"
           value="{{ old('email', $contact->email ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div>
    <label class="block font-medium">Company</label>
    <input name="company"
           value="{{ old('company', $contact->company ?? '') }}"
           class="w-full border rounded px-3 py-2">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block font-medium">Reminder Date</label>
        <input
            type="datetime-local"
            name="reminder_at"
            value="{{ old('reminder_at', isset($contact) && $contact->reminder_at ? $contact->reminder_at->format('Y-m-d\TH:i') : '') }}"
            class="w-full border rounded px-3 py-2"
        >
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
    </div>

</div>
