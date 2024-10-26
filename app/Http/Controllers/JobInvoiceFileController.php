<?php

namespace App\Http\Controllers;

use App\Models\JobInvoiceFile;
use App\Http\Requests\StoreJobInvoiceFileRequest;
use App\Http\Requests\UpdateJobInvoiceFileRequest;

use Illuminate\Support\Facades\DB;

class JobInvoiceFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(91);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(92);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobInvoiceFileRequest $request)
    {
        access_guard(92);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobInvoiceFile $jobInvoiceFile)
    {
        access_guard(91);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobInvoiceFile $jobInvoiceFile)
    {
        access_guard(93);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobInvoiceFileRequest $request, JobInvoiceFile $jobInvoiceFile)
    {
        access_guard(93);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(94);
        DB::beginTransaction();
         try {
            JobInvoiceFile::find($id)->delete();
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
        access_guard(95);
        DB::beginTransaction();
         try {
            JobInvoiceFile::withTrashed()->find($id)->restore();
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
        access_guard(96);
        DB::beginTransaction();
         try {
            JobInvoiceFile::withTrashed()->find($id)->forceDelete();
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
