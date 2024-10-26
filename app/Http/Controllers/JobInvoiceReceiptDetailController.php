<?php

namespace App\Http\Controllers;

use App\Models\JobInvoiceReceiptDetail;
use App\Http\Requests\StoreJobInvoiceReceiptDetailRequest;
use App\Http\Requests\UpdateJobInvoiceReceiptDetailRequest;

use Illuminate\Support\Facades\DB;

class JobInvoiceReceiptDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(103);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(104);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobInvoiceReceiptDetailRequest $request)
    {
        access_guard(104);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail)
    {
        access_guard(103);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail)
    {
        access_guard(105);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobInvoiceReceiptDetailRequest $request, JobInvoiceReceiptDetail $jobInvoiceReceiptDetail)
    {
        access_guard(105);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(106);
        DB::beginTransaction();
         try {
            JobInvoiceReceiptDetail::find($id)->delete();
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
        access_guard(107);
        DB::beginTransaction();
         try {
            JobInvoiceReceiptDetail::withTrashed()->find($id)->restore();
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
        access_guard(108);
        DB::beginTransaction();
         try {
            JobInvoiceReceiptDetail::withTrashed()->find($id)->forceDelete();
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
