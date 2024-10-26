<?php

namespace App\Http\Controllers;

use App\Models\JobInvoiceDetail;
use App\Models\JobInvoice;
use App\Models\Job;
use App\Models\JobPerformance;
use App\Models\JobPerformanceSheetData;
use App\Models\JobInvoiceContainerBreakup;
use App\Models\JobInvoiceContainerBreakupItem;

use App\Http\Requests\StoreJobInvoiceDetailRequest;
use App\Http\Requests\UpdateJobInvoiceDetailRequest;

use Illuminate\Support\Facades\DB;

class JobInvoiceDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/invoice/details/";
    public function index()
    {
        access_guard(85);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($job_id, $job_inv_id)
    {
        access_guard(86);
        $job = Job::find($job_id);
        if (!$job) {
            return redirect()->route('jobs');
        }

        $inv = JobInvoice::find($job_inv_id);
        if (!$inv) {
            return redirect()->route('jobs');
        }

        $rows = JobInvoiceDetail::where('job_invoice_id', $job_inv_id)->get();
        $performance_uploaded_files = JobPerformance::where('job_id', $job_id)->get();
        return view($this->root . 'add', compact('job', 'inv', 'rows', 'performance_uploaded_files'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobInvoiceDetailRequest $request)
    {
        access_guard(86);
        $net = $request->tax + $request->amount;
        $data = [
            'job_invoice_id' => $request->job_invoice_id,
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
        JobInvoiceDetail::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }
    public function store_container_breakup_invoice_item(StoreJobInvoiceDetailRequest $request)
    {
        access_guard(86);

        DB::beginTransaction();

        try {
            $data = [
                'job_id' => $request->job_id,
                'job_invoice_id' => $request->job_invoice_id,
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
            $record = JobInvoiceDetail::create($data);

            $data = [
                'job_invoice_detail_id' => $record->id
            ];
            JobInvoiceContainerBreakup::where('container_item_code', $request->container_item_code)->update($data);


            DB::commit();
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('create-job-invoice-detail', [$request->job_id, $request->job_invoice_id])->with($alert);
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
    public function show(JobInvoiceDetail $jobInvoiceDetail)
    {
        access_guard(85);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobInvoiceDetail $jobInvoiceDetail, $job_id, $job_inv_id, $inv_detail_id)
    {
        access_guard(87);
        $job = Job::find($job_id);
        if (!$job) {
            return redirect()->route('jobs');
        }

        $inv = JobInvoice::find($job_inv_id);
        if (!$inv) {
            return redirect()->route('jobs');
        }

        $row = JobInvoiceDetail::find($inv_detail_id);
        if (!$row) {
            return redirect()->route('create-job-invoice-detail', [$job_id, $job_inv_id]);
        }

        $rows = JobInvoiceDetail::where('job_invoice_id', $job_inv_id)->get();

        return view($this->root . 'edit', compact('job', 'inv', 'row', 'rows'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobInvoiceDetailRequest $request, JobInvoiceDetail $jobInvoiceDetail, $job_id, $job_inv_id, $inv_detail_id)
    {
        access_guard(87);
        $net = $request->tax + $request->amount;
        $data = [
            'job_invoice_id' => $request->job_invoice_id,
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
        JobInvoiceDetail::where('id', $inv_detail_id)->update($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('create-job-invoice-detail', [$job_id, $job_inv_id])->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
     {
         access_guard(88);
         DB::beginTransaction();
         try {
            JobInvoiceDetail::find($id)->delete();
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
         access_guard(89);
         DB::beginTransaction();
         try {
            JobInvoiceDetail::withTrashed()->find($id)->restore();
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
        access_guard(90);
         DB::beginTransaction();
         try {
            JobInvoiceDetail::withTrashed()->find($id)->forceDelete();
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
