<?php

namespace App\Http\Controllers;

use App\Models\FleetType;
use App\Http\Requests\StoreFleetTypeRequest;
use App\Http\Requests\UpdateFleetTypeRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class FleetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "fleet-types/";
    public function index()
    {
        access_guard(221);
        $rows = FleetType::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(222);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFleetTypeRequest $request)
    {
        access_guard(222);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('fleet_types_images', 'public');
        }
        FleetType::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(FleetType $fleetType)
    {
        access_guard(221);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FleetType $fleetType, $id)
    {
        access_guard(223);
        $row = FleetType::find($id);
        if(!$row){
            return redirect()->route('fleet-types');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFleetTypeRequest $request, FleetType $fleetType, $id)
    {
        access_guard(223);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        if ($request->hasFile('image')) {
            $data['image'] = request()->file('image')->store('fleet_types_images', 'public');
        }
        FleetType::where('id', $id)->update($data);
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
        access_guard(224);
        DB::beginTransaction();
         try {
            FleetType::find($id)->delete();
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
        access_guard(225);
        DB::beginTransaction();
         try {
            FleetType::withTrashed()->find($id)->restore();
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
        access_guard(226);
        $record = FleetType::withTrashed()->find($id);
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
