<?php

namespace App\Http\Controllers;

use App\Models\JobStatus;
use App\Http\Requests\StoreJobStatusRequest;
use App\Http\Requests\UpdateJobStatusRequest;

use Illuminate\Support\Facades\DB;

class JobStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(233);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(234);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobStatusRequest $request)
    {
        access_guard(234);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobStatus $jobStatus)
    {
        access_guard(233);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobStatus $jobStatus)
    {
        access_guard(235);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobStatusRequest $request, JobStatus $jobStatus)
    {
        access_guard(235);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(236);
        DB::beginTransaction();
         try {
            JobStatus::find($id)->delete();
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
        access_guard(237);
        DB::beginTransaction();
         try {
            JobStatus::withTrashed()->find($id)->restore();
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
        access_guard(238);
        DB::beginTransaction();
         try {
            JobStatus::withTrashed()->find($id)->forceDelete();
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
