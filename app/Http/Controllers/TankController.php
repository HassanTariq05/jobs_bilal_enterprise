<?php

namespace App\Http\Controllers;

use App\Models\Tank;
use App\Models\User;
use App\Http\Requests\StoreTankRequest;
use App\Http\Requests\UpdateTankRequest;


use Illuminate\Support\Facades\DB;

class TankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "tanks/";
    public function index()
    {
        access_guard(209);
        $rows = Tank::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(210);
        $users = User::where('id', '>', 1)->get();
        return view($this->root.'add', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTankRequest $request)
    {
        access_guard(210);
        $data = [
            'user_id' => $request->user_id,
            'fuel_type_id' => $request->fuel_type_id,
            'title' => $request->title,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'remarks' => $request->remarks,
        ];
        Tank::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tank $tank)
    {
        access_guard(209);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tank $tank, $id)
    {
        access_guard(211);
        $row = Tank::find($id);
        $users = User::where('id', '>', 1)->get();
        //echo "<pre>"; print_r($users); exit();
        if(!$row){
            return redirect()->route('tanks');
        }
        return view($this->root.'edit', compact('row', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTankRequest $request, Tank $tank, $id)
    {
        access_guard(211);
        $data = [
            'user_id' => $request->user_id,
            'fuel_type_id' => $request->fuel_type_id,
            'title' => $request->title,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'remarks' => $request->remarks,
        ];
        Tank::where('id', $id)->update($data);

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
        access_guard(212);
        DB::beginTransaction();
         try {
            Tank::find($id)->delete();
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
        access_guard(213);
        DB::beginTransaction();
         try {
            Tank::withTrashed()->find($id)->restore();
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
        access_guard(214);
        DB::beginTransaction();
         try {
            Tank::withTrashed()->find($id)->forceDelete();
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
}
