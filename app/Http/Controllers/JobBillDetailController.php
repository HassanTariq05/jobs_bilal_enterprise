<?php

namespace App\Http\Controllers;

use App\Models\JobBillDetail;
use App\Models\JobBill;
use App\Models\Job;
use App\Models\JobPerformance;
use App\Models\JobBillContainerBreakup;
use App\Models\JobBillContainerBreakupItem;
use App\Http\Requests\StoreJobBillDetailRequest;
use App\Http\Requests\UpdateJobBillDetailRequest;

use Illuminate\Support\Facades\DB;

class JobBillDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/bill/details/";
    public function index()
    {
        access_guard(37);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($job_id, $job_bill_id)
    {
        access_guard(38);
        $job = Job::find($job_id);
        if (!$job) {
            return redirect()->route('jobs');
        }

        $bill = JobBill::find($job_bill_id);
        if (!$bill) {
            return redirect()->route('jobs');
        }

        $rows = JobBillDetail::where('job_bill_id', $job_bill_id)->get();
        $performance_uploaded_files = JobPerformance::where('job_id', $job_id)->get();
        return view($this->root . 'add', compact('job', 'bill', 'rows', 'performance_uploaded_files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBillDetailRequest $request)
    {
        access_guard(38);
        $net = $request->tax + $request->amount;
        $data = [
            'job_bill_id' => $request->job_bill_id,
            'account_title_id' => $request->account_title_id,
            'sales_tax_territory_id' => $request->sales_tax_territory_id,
            'rate' => $request->rate,
            'qty' => $request->qty,
            'amount' => $request->amount,
            'tax_percentage' => $request->tax_percentage,
            'tax' => $request->tax,
            'net' => $net,
            'description' => $request->description,
            'is_manual' => 1,
        ];
        JobBillDetail::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }
    public function store_container_breakup_bill_item(StoreJobBIllDetailRequest $request)
    {

        DB::beginTransaction();

        try {
            $data = [
                'job_id' => $request->job_id,
                'job_bill_id' => $request->job_bill_id,
                'account_title_id' => $request->account_title_id,
                'sales_tax_territory_id' => $request->sales_tax_territory_id,
                'container_item_code' => $request->container_item_code,
                'rate' => $request->rate,
                'qty' => $request->qty,
                'amount' => $request->amount,
                'tax_percentage' => $request->tax_percentage,
                'tax' => $request->tax,
                'net' => $request->net,
                'description' => $request->description,
                'is_manual' => 0,
            ];
            $record = JobBillDetail::create($data);

            $data = [
                'job_bill_detail_id' => $record->id
            ];
            JobBillContainerBreakup::where('container_item_code', $request->container_item_code)->update($data);


            DB::commit();
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('create-job-bill-detail', [$request->job_id, $request->job_bill_id])->with($alert);
        } catch (\Exception $e) {
            DB::rollBack();
            $alert = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($alert);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(JobBillDetail $jobBillDetail)
    {
        access_guard(37);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBillDetail $jobBillDetail, $job_id, $job_bill_id, $bill_detail_id)
    {
        access_guard(39);
        $job = Job::find($job_id);
        if (!$job) {
            return redirect()->route('jobs');
        }

        $bill = JobBill::find($job_bill_id);
        if (!$bill) {
            return redirect()->route('jobs');
        }

        $row = JobBillDetail::find($bill_detail_id);
        if (!$row) {
            return redirect()->route('create-job-bill-detail', [$job_id, $job_bill_id]);
        }

        $rows = JobBillDetail::where('job_bill_id', $job_bill_id)->get();

        return view($this->root . 'edit', compact('job', 'bill', 'row', 'rows'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobBillDetailRequest $request, JobBillDetail $jobBillDetail, $id, $job_bill_id, $bill_detail_id)
    {
        access_guard(39);
        $net = $request->tax + $request->amount;
        $data = [
            'job_bill_id' => $request->job_bill_id,
            'account_title_id' => $request->account_title_id,
            'sales_tax_territory_id' => $request->sales_tax_territory_id,
            'rate' => $request->rate,
            'qty' => $request->qty,
            'amount' => $request->amount,
            'tax_percentage' => $request->tax_percentage,
            'tax' => $request->tax,
            'net' => $net,
            'description' => $request->description,
            'is_manual' => 1,
        ];
        JobBillDetail::where('id', $bill_detail_id)->update($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('create-job-bill-detail', [$id, $job_bill_id])->with($alert);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function trash($id = 0)
    {

        access_guard(40);
        DB::beginTransaction();
         try {
            JobBillDetail::find($id)->delete();
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
        access_guard(41);
        DB::beginTransaction();
         try {
            JobBillDetail::withTrashed()->find($id)->restore();
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

        access_guard(42);
        DB::beginTransaction();
         try {
            JobBillDetail::withTrashed()->find($id)->forceDelete();
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
