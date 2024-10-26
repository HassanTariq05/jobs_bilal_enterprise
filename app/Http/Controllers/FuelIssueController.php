<?php

namespace App\Http\Controllers;

use App\Models\FuelIssue;
use App\Models\Fleet;
use App\Http\Requests\StoreFuelIssueRequest;
use App\Http\Requests\UpdateFuelIssueRequest;

use Illuminate\Support\Facades\DB;

class FuelIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "fuel-issue/";
    public function index()
    {
        access_guard(115);
        $rows = FuelIssue::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(116);
        $fleets = Fleet::all();
        return view($this->root.'add', compact('fleets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelIssueRequest $request)
    {       
        access_guard(116);
        $data = [
            'tank_id' => $request->tank_id,
            'fleet_id' => $request->fleet_id,
            'operation_id' => $request->operation_id,
            'fill_date' => $request->fill_date,
            'qty' => $request->qty,
            'driver' => $request->driver,
            'odometer_reading' => $request->odometer_reading,
            'remarks' => $request->remarks,
        ];
        FuelIssue::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelIssue $fuelIssue)
    {
        access_guard(115);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelIssue $fuelIssue, $id)
    {
        access_guard(117);
        $row = FuelIssue::find($id);
        if(!$row){
            return redirect()->route('fuel-issue');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuelIssueRequest $request, FuelIssue $fuelIssue, $id)
    {
        access_guard(117);
        $data = [
            'tank_id' => $request->tank_id,
            'fleet_id' => $request->fleet_id,
            'operation_id' => $request->operation_id,
            'fill_date' => $request->fill_date,
            'qty' => $request->qty,
            'driver' => $request->driver,
            'odometer_reading' => $request->odometer_reading,
            'remarks' => $request->remarks,
        ];
        FuelIssue::where('id', $id)->update($data);
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
        access_guard(118);
        DB::beginTransaction();
         try {
            FuelIssue::find($id)->delete();
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
        access_guard(119);
        DB::beginTransaction();
         try {
            FuelIssue::withTrashed()->find($id)->restore();
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
        access_guard(120);
        $record = FuelIssue::withTrashed()->find($id);
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
