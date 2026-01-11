<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private ContactRepositoryInterface $contacts
    ) {}

    public function index(Request $request)
    {
        $contacts = $this->contacts->paginateWithFilters(
            $request->only('search', 'overdue'),
            10
        );

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(StoreContactRequest $request)
    {
        $this->contacts->store($request->validated());

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact created successfully');
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $this->contacts->update($contact, $request->validated());

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact updated successfully');
    }

    public function upcomingReminders()
    {
        return Contact::whereNotNull('reminder_at')
            ->where('reminder_at', '>=', now())
            ->orderBy('reminder_at')
            ->limit(5)
            ->get();
    }


    public function destroy(Contact $contact)
    {
        $this->contacts->delete($contact);

        return redirect()
            ->route('contacts.index')
            ->with('success', 'Contact deleted successfully');
    }
}

