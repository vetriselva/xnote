<?php
namespace App\Repositories\Contracts;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;

interface ServiceRepositoryInterface
{
    public function paginate(int $perPage = 10);

    public function create(ServiceRequest $request): Service;

    public function update(ServiceRequest $request, $service): Service;

    public function delete(Service $service): bool;
}
