<?php

namespace App\Http\Controllers;

use App\Models\JobFile;
use App\Http\Requests\StoreJobFileRequest;
use App\Http\Requests\UpdateJobFileRequest;

use Illuminate\Support\Facades\DB;

class JobFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(73);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(74);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobFileRequest $request)
    {
        access_guard(74);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobFile $jobFile)
    {
        access_guard(73);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobFile $jobFile)
    {
        access_guard(75);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobFileRequest $request, JobFile $jobFile)
    {
        access_guard(75);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(76);
        DB::beginTransaction();
         try {
            JobFile::find($id)->delete();
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
        access_guard(77);
        DB::beginTransaction();
         try {
            JobFile::withTrashed()->find($id)->restore();
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
        access_guard(78);
        $record = JobFile::withTrashed()->find($id);
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
