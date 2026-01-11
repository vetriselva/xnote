<?php
namespace App\Repositories\Contracts;

use App\Models\Contact;

interface ContactRepositoryInterface
{
    public function paginateWithFilters(array $filters, int $perPage = 10);
    public function store(array $data);
    public function update(Contact $contact, array $data);
    public function delete(Contact $contact);
}
