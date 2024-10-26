<?php

namespace App\Http\Controllers;

use App\Models\JobBillFile;
use App\Http\Requests\StoreJobBillFileRequest;
use App\Http\Requests\UpdateJobBillFileRequest;

use Illuminate\Support\Facades\DB;

class JobBillFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(43);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(44);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBillFileRequest $request)
    {
        access_guard(44);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobBillFile $jobBillFile)
    {
        access_guard(43);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBillFile $jobBillFile)
    {
        access_guard(45);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobBillFileRequest $request, JobBillFile $jobBillFile)
    {
        access_guard(45);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(46);
        DB::beginTransaction();
         try {
            JobBillFile::find($id)->delete();
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
        access_guard(47);
        DB::beginTransaction();
         try {
            JobBillFile::withTrashed()->find($id)->restore();
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
        access_guard(48);
        $record = JobBillFile::withTrashed()->find($id);
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
