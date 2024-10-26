<?php

namespace App\Http\Controllers;

use App\Models\PartyType;
use App\Http\Requests\StorePartyTypeRequest;
use App\Http\Requests\UpdatePartyTypeRequest;

use Illuminate\Support\Facades\DB;

class PartyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(203);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(204);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartyTypeRequest $request)
    {
        access_guard(204);
    }

    /**
     * Display the specified resource.
     */
    public function show(PartyType $partyType)
    {
        access_guard(203);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PartyType $partyType)
    {
        access_guard(205);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartyTypeRequest $request, PartyType $partyType)
    {
        access_guard(205);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(206);
        DB::beginTransaction();
         try {
            PartyType::find($id)->delete();
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
        access_guard(207);
        DB::beginTransaction();
         try {
            PartyType::withTrashed()->find($id)->restore();
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
        access_guard(208);
        DB::beginTransaction();
         try {
            PartyType::withTrashed()->find($id)->forceDelete();
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
