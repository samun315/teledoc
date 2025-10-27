<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Services\Service\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        $services = $this->serviceService->getAllServices();
        return view('service.index', compact('services'));
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(ServiceRequest $request)
    {
        try {
            $this->serviceService->createService($request->validated());
            return redirect()->route('service.service.index')->with('success', 'Service created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    public function edit($service_id)
    {
        try {
            $service = $this->serviceService->getServiceById($service_id);
            return view('service.edit', compact('service'));
        } catch (\Exception $e) {
            return redirect()->route('service.service.index')->with('error', 'Service not found');
        }
    }

    public function update(ServiceRequest $request, $service_id)
    {
        try {
            $this->serviceService->updateService($service_id, $request->validated());
            return redirect()->route('service.service.index')->with('success', 'Service updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    public function destroy($service_id)
    {
        try {
            $this->serviceService->deleteService($service_id);
            return redirect()->route('service.service.index')->with('success', 'Service deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('service.service.index')->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}

