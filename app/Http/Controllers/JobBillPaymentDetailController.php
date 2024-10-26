<?php

namespace App\Http\Controllers;

use App\Models\JobBillPaymentDetail;
use App\Http\Requests\StoreJobBillPaymentDetailRequest;
use App\Http\Requests\UpdateJobBillPaymentDetailRequest;

use Illuminate\Support\Facades\DB;

class JobBillPaymentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(55);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(56);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBillPaymentDetailRequest $request)
    {
        access_guard(56);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobBillPaymentDetail $jobBillPaymentDetail)
    {
        access_guard(55);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBillPaymentDetail $jobBillPaymentDetail)
    {
        access_guard(57);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobBillPaymentDetailRequest $request, JobBillPaymentDetail $jobBillPaymentDetail)
    {
        access_guard(57);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(58);
        DB::beginTransaction();
         try {
            JobBillPaymentDetail::find($id)->delete();
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
        access_guard(59);
        DB::beginTransaction();
         try {
            JobBillPaymentDetail::withTrashed()->find($id)->restore();
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
        access_guard(60);
        $record = JobBillPaymentDetail::withTrashed()->find($id);
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
