<?php
namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;

class ContactRepository implements ContactRepositoryInterface
{
    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Contact::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('reminder_note', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('others', 'like', '%' . $filters['search'] . '%');
            });
        }


        if (!empty($filters['overdue']) && $filters['overdue'] == '1') {
            $query->whereNotNull('reminder_at')
                ->where('reminder_at', '<', now());
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    public function store(array $data)
    {
        return Contact::create($data);
    }

    public function update(Contact $contact, array $data)
    {
        $contact->update($data);
        return $contact;
    }

    public function delete(Contact $contact)
    {
        return $contact->delete();
    }
}
