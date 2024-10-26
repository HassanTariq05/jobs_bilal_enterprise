<?php

namespace App\Http\Controllers;

use App\Models\JobContainer;
use App\Http\Requests\StoreJobContainerRequest;
use App\Http\Requests\UpdateJobContainerRequest;

use Illuminate\Support\Facades\DB;

class JobContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(61);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(62);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobContainerRequest $request)
    {
        access_guard(62);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobContainer $jobContainer)
    {
        access_guard(61);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobContainer $jobContainer)
    {
        access_guard(63);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobContainerRequest $request, JobContainer $jobContainer)
    {
        access_guard(63);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(64);
        DB::beginTransaction();
         try {
            JobContainer::find($id)->delete();
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
        access_guard(65);
        DB::beginTransaction();
         try {
            JobContainer::withTrashed()->find($id)->restore();
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
        access_guard(66);
        $record = JobContainer::withTrashed()->find($id);
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
