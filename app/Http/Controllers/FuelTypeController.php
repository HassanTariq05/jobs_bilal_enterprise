<?php

namespace App\Http\Controllers;

use App\Models\FuelType;
use App\Http\Requests\StoreFuelTypeRequest;
use App\Http\Requests\UpdateFuelTypeRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class FuelTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "fuel-types/";
    public function index()
    {
        access_guard(167);
        $rows = FuelType::withTrashed()->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(168);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFuelTypeRequest $request)
    {
        access_guard(168);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        FuelType::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelType $fuelType)
    {
        access_guard(167);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelType $fuelType, $id)
    {
        access_guard(169);
        $row = FuelType::find($id);
        if (!$row) {
            return redirect()->route('fuel-types');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFuelTypeRequest $request, FuelType $fuelType, $id)
    {
        access_guard(169);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        FuelType::where('id', $id)->update($data);
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
        access_guard(170);
        DB::beginTransaction();
         try {
            FuelType::find($id)->delete();
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
        access_guard(171);
        DB::beginTransaction();
         try {
            FuelType::withTrashed()->find($id)->restore();
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
        access_guard(172);
        $record = FuelType::withTrashed()->find($id);
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
