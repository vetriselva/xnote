<?php
namespace App\Repositories;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function paginate(int $perPage = 10)
    {
        return Service::orderByDesc('id')->paginate($perPage);
    }

    public function create(ServiceRequest $request): Service
    {
        if ($request->is_default) {
            Service::where('tenant_id', auth()->user()->tenant_id)
                ->update(['is_default' => false]);
        }

        return Service::create($request->validated());
    }

    public function update(ServiceRequest $request, $service): Service
    {
        if ($request->is_default) {
            Service::where('tenant_id', auth()->user()->tenant_id)
            ->where('id', '!=', $service->id)
            ->update(['is_default' => false]);
        }

        $service->update($request->validated());
        return $service;
    }

    public function delete(Service $service): bool
    {
        return $service->delete();
    }
}
