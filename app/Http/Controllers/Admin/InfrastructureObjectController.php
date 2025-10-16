<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InfrastructureObjectStatus;
use App\Enums\InfrastructureObjectType;
use App\Http\Controllers\Controller;
use App\Models\InfrastructureObject;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfrastructureObjectController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $allTypes = array_column(\App\Enums\InfrastructureObjectType::cases(), 'value');
        $allStatuses = array_column(\App\Enums\InfrastructureObjectStatus::cases(), 'value');

        $query = InfrastructureObject::with('creator');

        $query->searchByName($request->get('name'))
            ->ofStatus($request->get('status'))
            ->ofType($request->get('type'))
            ->ofDistrict($request->get('district'));

        $objects = $query->paginate(15)->withQueryString();

        return view('admin.objects.index', compact('objects', 'allTypes', 'allStatuses'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $types = InfrastructureObjectType::cases();
        $statuses = InfrastructureObjectStatus::cases();

        return view('admin.objects.create', compact('types', 'statuses'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_column(InfrastructureObjectType::cases(), 'value')),
            'status' => 'required|string|in:' . implode(',', array_column(InfrastructureObjectStatus::cases(), 'value')),
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'district' => 'nullable|string|max:100',
        ]);

        $validatedData['created_by'] = Auth::id();

        InfrastructureObject::create($validatedData);

        return redirect()->route('dashboard.objects.index')->with('success', 'Infrastructure object created successfully.');
    }

    /**
     * @param InfrastructureObject $object
     * @return Factory|View
     */
    public function edit(InfrastructureObject $object)
    {
        $types = InfrastructureObjectType::cases();
        $statuses = InfrastructureObjectStatus::cases();

        return view('admin.objects.edit', compact('object', 'types', 'statuses'));
    }

    /**
     * @param Request $request
     * @param InfrastructureObject $object
     * @return RedirectResponse
     */
    public function update(Request $request, InfrastructureObject $object): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:' . implode(',', array_column(InfrastructureObjectType::cases(), 'value')),
            'status' => 'required|string|in:' . implode(',', array_column(InfrastructureObjectStatus::cases(), 'value')),
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'district' => 'nullable|string|max:100',
        ]);

        $object->update($validatedData);

        return redirect()->route('dashboard.objects.index')->with('success', 'Infrastructure object updated successfully.');
    }

    /**
     * @param InfrastructureObject $object
     * @return RedirectResponse
     */
    public function destroy(InfrastructureObject $object): RedirectResponse
    {
        $object->delete();

        return back()->with('success', 'Infrastructure object deleted successfully.');
    }
}
