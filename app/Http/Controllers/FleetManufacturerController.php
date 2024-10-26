<?php

namespace App\Http\Controllers;

use App\Models\FleetManufacturer;
use App\Http\Requests\StoreFleetManufacturerRequest;
use App\Http\Requests\UpdateFleetManufacturerRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class FleetManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "fleet-manufacturers/";
    public function index()
    {
        access_guard(227);
        $rows = FleetManufacturer::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(228);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFleetManufacturerRequest $request)
    {
        access_guard(228);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('fleet_manufacturers_image', 'public');
        }
        FleetManufacturer::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(FleetManufacturer $fleetManufacturer)
    {
        access_guard(227);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FleetManufacturer $fleetManufacturer, $id)
    {
        access_guard(229);
        $row = FleetManufacturer::find($id);
        if(!$row){
            return redirect()->route('fleet-manufacturers');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFleetManufacturerRequest $request, FleetManufacturer $fleetManufacturer, $id)
    {
        access_guard(229);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('fleet_manufacturers_image', 'public');
        }
        FleetManufacturer::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(230);
        DB::beginTransaction();
         try {
            FleetManufacturer::find($id)->delete();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been deleted successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function restore($id = 0)
    {
        access_guard(231);
        DB::beginTransaction();
         try {
            FleetManufacturer::withTrashed()->find($id)->restore();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been restored successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function destroy($id = 0)
    {
        access_guard(232);
        $record = FleetManufacturer::withTrashed()->find($id);
        if (!is_null($record)) {
            $record->forceDelete();
            $alert = array(
                'message' => 'Record deleted successfully',
                'alert-type' => 'success'
            );
        }else{
            $alert = array(
                'message' => 'Unable to delete record.',
                'alert-type' => 'error'
            );
        }
        return back()->with($alert);
    }
}
