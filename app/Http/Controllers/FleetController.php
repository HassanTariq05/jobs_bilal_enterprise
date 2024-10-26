<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\User;
use App\Http\Requests\StoreFleetRequest;
use App\Http\Requests\UpdateFleetRequest;

use Illuminate\Support\Facades\DB;

class FleetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "fleets/";
    public function index()
    {
        access_guard(149);
        $rows = Fleet::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(150);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFleetRequest $request)
    {
        access_guard(150);
        $data = [
            'fleet_manufacturer_id' => $request->fleet_manufacturer_id,
            'fleet_type_id' => $request->fleet_type_id,
            'registration_number' => $request->registration_number,
            'chassis_number' => $request->chassis_number,
            'engine_number' => $request->engine_number,
            'model' => $request->model,
            'horsepower' => $request->horsepower,
            'loading_capacity' => $request->loading_capacity,
            'registration_city' => $request->registration_city,
            'ownership' => $request->ownership,
            'lifting_capacity' => $request->lifting_capacity,
            'diesel_opening_inventory' => $request->diesel_opening_inventory,
        ];
        Fleet::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fleet $fleet)
    {
        access_guard(149);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fleet $fleet, $id)
    {
        access_guard(151);
        $row = Fleet::find($id);
        if(!$row){
            return redirect()->route('fleets');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFleetRequest $request, Fleet $fleet, $id)
    {
        access_guard(151);
        $data = [
            'fleet_manufacturer_id' => $request->fleet_manufacturer_id,
            'fleet_type_id' => $request->fleet_type_id,
            'registration_number' => $request->registration_number,
            'chassis_number' => $request->chassis_number,
            'engine_number' => $request->engine_number,
            'model' => $request->model,
            'horsepower' => $request->horsepower,
            'loading_capacity' => $request->loading_capacity,
            'registration_city' => $request->registration_city,
            'ownership' => $request->ownership,
            'lifting_capacity' => $request->lifting_capacity,
            'diesel_opening_inventory' => $request->diesel_opening_inventory,
        ];
        Fleet::where('id', $id)->update($data);

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
        access_guard(152);
        DB::beginTransaction();
         try {
            Fleet::find($id)->delete();
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
        access_guard(153);
        DB::beginTransaction();
         try {
            Fleet::withTrashed()->find($id)->restore();
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
        access_guard(154);
        $record = Fleet::withTrashed()->find($id);
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
