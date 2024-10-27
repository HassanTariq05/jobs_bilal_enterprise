<?php

namespace App\Http\Controllers;

use App\Models\JobInvoiceContainerBreakup;
use App\Models\JobInvoiceContainerBreakupItem;

use App\Http\Requests\StoreJobInvoiceContainerBreakupRequest;
use App\Http\Requests\UpdateJobInvoiceContainerBreakupRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Job;
use App\Models\JobInvoice;
use App\Models\JobInvoiceDetail;
use App\Models\JobPerformance;
use App\Models\JobPerformanceSheetData;

class JobInvoiceContainerBreakupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/invoice/details/container-breakup/";
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Request $request, $job_id, $job_inv_id)
    {
        $head_id = $_REQUEST['head'];
        //$where = " id>0 ";
        $where = " job_performance_id IN (SELECT id FROM job_performances WHERE job_id=$job_id)";
        /*
        $where = " 
                    job_performance_id IN 
                        (SELECT id FROM job_performances WHERE job_id=$job_id) AND 
                    container_no NOT IN 
                    (SELECT jicbi.container_no FROM job_invoice_container_breakup_items AS jicbi WHERE jicbi.job_invoice_container_breakup_id IN (SELECT jicb.id FROM job_invoice_container_breakups AS jicb WHERE jicb.account_title_id=$head_id ) ) 
                ";
       
        $where = " 
                    job_performance_id IN (SELECT id FROM job_performances WHERE job_id=$job_id)
                    AND
                    container_no NOT IN 
                    (SELECT jicbi.container_no FROM job_invoice_container_breakup_items AS jicbi WHERE jicbi.job_invoice_container_breakup_id IN (SELECT jicb.id FROM job_invoice_container_breakups AS jicb WHERE jicb.job_invoice_id IN (SELECT ji.id FROM job_invoices AS ji WHERE ji.job_id=$job_id) ) )
                "; 
        */
        $rows = [];
        $heads_rates = [];

    
        $xitems_array = get_job_invoice_container_breakup_items_array($job_id);
        //echo "<pre>"; print_r($result); exit();

        $job = Job::find($job_id);
        if (!$job) {
            return redirect()->route('jobs');
        }
        $inv = JobInvoice::find($job_inv_id);
        if (!$inv) {
            return redirect()->route('jobs');
        }

        if (isset($_REQUEST['search_container'])) {

            $bill_no =  preg_replace('/\s+/', '', $request->filter_bill_no);
            $container_no =  preg_replace('/\s+/', '', $request->filter_container_no);

            $size = $request->filter_size;
            $status = $request->filter_status;
            $trucking_mode = $request->filter_trucking_mode;

            if ($bill_no) {
                $bill_no = str_replace(',', "','", $bill_no);
                $where .= " AND bl_no IN ('$bill_no') ";
            }
            if ($container_no) {
                $container_no = str_replace(',', "','", $container_no);
                $where .= " AND container_no IN ('$container_no') ";
            }
            if ($size) {
                $where .= " AND size=$size ";
            }
            if ($status) {
                $where .= " AND status='$status' ";
            }
            if ($trucking_mode) {
                $where .= " AND trucking_mode='$trucking_mode' ";
            }
        }
        $jps = JobPerformance::where('job_id', $job_id)->get();
        $jp_ids = [];
        if ($jps) {
            foreach ($jps as $jp) {
                $jp_ids[] = $jp->id;
            }
            $rows = JobPerformanceSheetData::whereRaw($where)->get();
        }

        if (isset($_REQUEST['cic'])) {
            $cic = $_REQUEST['cic'];
            $heads_rates = JobInvoiceContainerBreakup::where('container_item_code', $cic)->get();
        }

        return view($this->root . 'add', compact('job', 'inv', 'rows', 'heads_rates', 'xitems_array'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            if ($request->container_ids) {


                $x_record = JobInvoiceContainerBreakup::where('job_invoice_id', $request->job_invoice_id)->where('job_invoice_detail_id', NULL)->where('sales_tax_territory_id', $request->sales_tax_territory_id)->where('account_title_id', $request->account_title_id)->where('container_item_code', $request->container_item_code)->where('rate', $request->rate)->where('tax', $request->tax)->first();

                // echo "<pre>"; print_r($x_record); exit();

                $containers_data = json_decode($request->container_data);

                if ($x_record) {

                    $x_breakup_id = $x_record->id;
                    $x_qty = $x_record->qty;
                    $x_amount = $x_record->amount;
                    $x_net = $x_record->net;
                    $x_description = $x_record->description;


                    $data = [
                        'qty' => ($x_qty + $request->qty),
                        'amount' => ($x_amount + $request->amount),
                        'net' => ($x_net + $request->net),
                        'description' => ($x_description . ' ' . $request->description)
                    ];
                    JobInvoiceContainerBreakup::where('id', $x_breakup_id)->update($data);

                    /*
                    $container_nos = explode(',', $request->container_nos);
                    foreach ($container_nos as $container_no) {
                        if ($container_no) {
                            $data = [
                                'job_invoice_container_breakup_id' => $x_breakup_id,
                                'container_no' => $container_no,
                                'rate' => $request->rate,
                                'qty' => 1,
                            ];
                            JobInvoiceContainerBreakupItem::create($data);
                        }
                    }
                    */
                    foreach ($containers_data as $cdata) {
                        $data = [
                            'job_invoice_container_breakup_id' => $x_breakup_id,

                            'bl_no' => $cdata->bl_no,
                            'container_no' => $cdata->container_no,
                            'size' => $cdata->size,
                            'status' => $cdata->status,
                            'vehicle_no' => $cdata->vehicle_no,
                            'trucking_mode' => $cdata->trucking_mode,
                            'date' => $cdata->date,
                            'loading_port' => $cdata->loading_port,
                            'off_loading_port' => $cdata->off_loading_port,
                            'party' => $cdata->party,
                            'remarks' => $cdata->remarks,

                            'rate' => $request->rate,
                            'qty' => 1,
                        ];
                        JobInvoiceContainerBreakupItem::create($data);
                    }
                } else {
                    $data = [
                        'job_invoice_id' => $request->job_invoice_id,
                        'sales_tax_territory_id' => $request->sales_tax_territory_id,
                        'account_title_id' => $request->account_title_id,
                        'container_item_code' => $request->container_item_code,
                        'rate' => $request->rate,
                        'qty' => $request->qty,
                        'amount' => $request->amount,
                        'tax_percentage' => $request->tax_percentage,
                        'tax' => $request->tax,
                        'net' => ($request->amount + $request->tax),
                        'description' => $request->description,
                    ];
                    $record = JobInvoiceContainerBreakup::create($data);

                    /*
                    $container_nos = explode(',', $request->container_nos);
                    foreach ($container_nos as $container_no) {
                        if ($container_no) {
                            $data = [
                                'job_invoice_container_breakup_id' => $record->id,
                                'container_no' => $container_no,
                                'rate' => $request->rate,
                                'qty' => 1,
                            ];
                            JobInvoiceContainerBreakupItem::create($data);
                        }
                    }
                    */
                    foreach ($containers_data as $cdata) {
                        $data = [
                            'job_invoice_container_breakup_id' => $record->id,

                            'bl_no' => $cdata->bl_no,
                            'container_no' => $cdata->container_no,
                            'size' => $cdata->size,
                            'status' => $cdata->status,
                            'vehicle_no' => $cdata->vehicle_no,
                            'trucking_mode' => $cdata->trucking_mode,
                            'date' => $cdata->date,
                            'loading_port' => $cdata->loading_port,
                            'off_loading_port' => $cdata->off_loading_port,
                            'party' => $cdata->party,
                            'remarks' => $cdata->remarks,

                            'rate' => $request->rate,
                            'qty' => 1,
                        ];
                        JobInvoiceContainerBreakupItem::create($data);
                    }
                }
            }

            DB::commit();
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return back()->with($alert);
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
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $job_id, $job_inv_id, $inv_detail_id, $container_item_code)
    {

        $rows = [];
        //$heads_rates = [];

        $job = Job::find($job_id);
        if (!$job) {
            return redirect()->route('jobs');
        }
        $inv = JobInvoice::find($job_inv_id);
        if (!$inv) {
            return redirect()->route('jobs');
        }

        $rows = JobInvoiceContainerBreakup::where('container_item_code', $container_item_code)->get();

        return view($this->root . 'edit', compact('job', 'inv',  'inv_detail_id', 'container_item_code', 'rows'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobInvoiceContainerBreakupRequest $request, JobInvoiceContainerBreakup $jobInvoiceContainerBreakup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    /*
    public function destroy($job_id, $inv_id, $id)
        {
            DB::beginTransaction();
            try {

                JobInvoiceContainerBreakup::where('id', $id)->delete();
                JobInvoiceContainerBreakupItem::where('job_invoice_container_breakup_id', $id)->delete();

                DB::commit();

                $alert = array(
                    'message' => 'Record Deleted Successfully',
                    'alert-type' => 'success'
                );
                return back()->with($alert);
            } catch (\Exception $e) {
                DB::rollBack();
                $alert = array(
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                );
                return back()->with($alert);
            }
        }
    */


    public function trash($id)
    {
       
        DB::beginTransaction();
         try {
            JobInvoiceContainerBreakup::find($id)->delete();
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
    public function restore($id)
    {
       
        DB::beginTransaction();
         try {
            JobInvoiceContainerBreakup::withTrashed()->find($id)->restore();
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

    
    public function destroy($id=0)
    {
        
        DB::beginTransaction();
        try {
            JobInvoiceContainerBreakup::withTrashed()->find($id)->forceDelete();
            //syncInvoiceItemByCode($cic);
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
