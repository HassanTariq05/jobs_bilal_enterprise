<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use App\Http\Requests\StoreFuelRequest;
use App\Http\Requests\UpdateFuelRequest;

use Illuminate\Support\Facades\DB;

class FuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(109);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(110);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelRequest $request)
    {
        access_guard(110);
    }

    /**
     * Display the specified resource.
     */
    public function show(Fuel $fuel)
    {
        access_guard(109);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fuel $fuel)
    {
        access_guard(111);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuelRequest $request, Fuel $fuel)
    {
        access_guard(111);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(112);
        DB::beginTransaction();
         try {
            Fuel::find($id)->delete();
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
        access_guard(113);
        DB::beginTransaction();
         try {
            Fuel::withTrashed()->find($id)->restore();
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
        access_guard(114);
        $record = Fuel::withTrashed()->find($id);
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
