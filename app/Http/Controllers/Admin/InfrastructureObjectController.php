<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InfrastructureObjectStatus;
use App\Enums\InfrastructureObjectType;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\InfrastructureObject;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InfrastructureObjectController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $query = InfrastructureObject::with('creator');

        $query->searchByName($request->get('name'))
            ->ofStatus($request->get('status'))
            ->ofType($request->get('type'))
            ->ofDistrict($request->get('district_id'))
            ->where('city_id', config('app.current_city_id'));

        $objects = $query->paginate(15)->withQueryString();

        return view('admin.objects.index', array_merge(compact('objects'), $this->getFormOptions()));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.objects.create', $this->getFormOptions());
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
            'district_id' => ['nullable', 'integer', Rule::exists('districts', 'id')->where('city_id', config('app.current_city_id'))],
        ]);

        $validatedData['created_by'] = Auth::id();
        $validatedData['city_id'] = config('app.current_city_id');

        InfrastructureObject::create($validatedData);

        return redirect()->route('dashboard.objects.index')->with('success', 'Infrastructure object created successfully.');
    }

    /**
     * @param InfrastructureObject $object
     * @return Factory|View
     */
    public function edit(InfrastructureObject $object)
    {
        return view('admin.objects.edit', array_merge(compact('object'), $this->getFormOptions()));
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
            'district_id' => ['nullable', 'integer', Rule::exists('districts', 'id')->where('city_id', config('app.current_city_id'))],
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

    /**
     * @return array
     */
    private function getFormOptions(): array
    {
        return [
            'allTypes' => array_column(InfrastructureObjectType::cases(), 'value'),
            'allStatuses' => array_column(InfrastructureObjectStatus::cases(), 'value'),
            'allDistricts' => District::where('city_id', config('app.current_city_id'))
                ->get(['id', 'name'])
                ->toArray(),
        ];
    }
}
