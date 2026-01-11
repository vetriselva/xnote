<?php
// app/Http/Controllers/ServiceController.php
namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Repositories\ServiceRepositoryInterface;

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;

class ServiceController extends Controller
{
    public function __construct(
        private ServiceRepositoryInterface $serviceRepo
    ) {}

    public function index()
    {
        $services = $this->serviceRepo->paginate(10);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(ServiceRequest $request)
    {
        $this->serviceRepo->create($request);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service created successfully');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $this->serviceRepo->update($request, $service);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        $this->serviceRepo->delete($service);

        return redirect()
            ->route('services.index')
            ->with('success', 'Service deleted successfully');
    }
}

