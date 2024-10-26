<?php

namespace App\Http\Controllers;

use App\Models\FuelPurchase;
use App\Http\Requests\StoreFuelPurchaseRequest;
use App\Http\Requests\UpdateFuelPurchaseRequest;

use Illuminate\Support\Facades\DB;

class FuelPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "fuel-purchases/";
    public function index()
    {
        access_guard(121);
        $rows = FuelPurchase::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(122);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelPurchaseRequest $request)
    {
        access_guard(122);
        $amount = ($request->qty*$request->rate);
        $data = [
            'party_id' => $request->party_id,
            'fuel_type_id' => $request->fuel_type_id,
            'tank_id' => $request->tank_id,
            'qty' => $request->qty,
            'rate' => $request->rate,
            'amount' => $amount,
            'delivery_date' => $request->delivery_date,
            'freight_charges' => $request->freight_charges,
            'remarks' => $request->remarks,
        ];
        FuelPurchase::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelPurchase $fuelPurchase)
    {
        access_guard(121);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelPurchase $fuelPurchase, $id)
    {
        access_guard(123);
        $row = FuelPurchase::find($id);
        if(!$row){
            return redirect()->route('fuel-purchases');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuelPurchaseRequest $request, FuelPurchase $fuelPurchase, $id)
    {
        access_guard(123);
        $amount = ($request->qty*$request->rate);
        $data = [
            'party_id' => $request->party_id,
            'fuel_type_id' => $request->fuel_type_id,
            'tank_id' => $request->tank_id,
            'qty' => $request->qty,
            'rate' => $request->rate,
            'amount' => $amount,
            'delivery_date' => $request->delivery_date,
            'freight_charges' => $request->freight_charges,
            'remarks' => $request->remarks,
        ];
        FuelPurchase::where('id', $id)->update($data);
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
        access_guard(124);
        DB::beginTransaction();
         try {
            FuelPurchase::find($id)->delete();
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
        access_guard(125);
        DB::beginTransaction();
         try {
            FuelPurchase::withTrashed()->find($id)->restore();
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
        access_guard(126);
        $record = FuelPurchase::withTrashed()->find($id);
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
