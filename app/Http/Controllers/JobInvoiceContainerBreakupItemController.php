<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\JobInvoiceContainerBreakup;
use App\Models\JobInvoiceContainerBreakupItem;


class JobInvoiceContainerBreakupItemController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    public function update_items_rate(Request $request)
    {

        DB::beginTransaction();

        try {

            $data = [
                'sales_tax_territory_id' => $request->sales_tax_territory_id,
                'account_title_id' => $request->account_title_id,
                'rate' => $request->rate,
                'qty' => $request->qty,
                'amount' => $request->amount,
                'tax_percentage' => $request->tax_percentage,
                'tax' => $request->tax,
                'net' => $request->net,
                'description' => $request->description,
            ];
            JobInvoiceContainerBreakup::where('id', $request->job_invoice_container_breakup_id)->update($data);

            $data2 = [
                'job_invoice_container_breakup_id' => $request->job_invoice_container_breakup_id,
                'rate' => $request->rate,
            ];
            $ids = explode(',', str_replace(' ','', $request->ids));
            foreach ($ids as $id) {
                JobInvoiceContainerBreakupItem::where('id', $id)->update($data2);
            }

            DB::commit();

            syncInvoiceItemByCode($request->cic);

            $alert = array(
                'message' => 'Updated successfully.',
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


        /*
        $ids = explode(',', $request->ids) ;
        $job_invoice_container_breakup_id = $request->job_invoice_container_breakup_id;
        $description = $request->description;
        $new_rate = $request->new_rate;
        $cic = $request->cic;
        $qty=0;
        foreach($ids as $id){
            if($id>0){
                JobInvoiceContainerBreakupItem::where('id', $id)->update(['rate'=>$new_rate]);
                $qty++;
            }
        }

        $tax = get_specific_field_by_id('job_invoice_container_breakups', 'tax', $job_invoice_container_breakup_id);
        $amount = ($qty*$new_rate);
        $data = [
            'description'=>$description,
            'rate'=>$new_rate,
            'qty'=>$qty,
            'amount'=>$amount,
            'net'=>($tax*$amount),

        ];
        JobInvoiceContainerBreakup::where('id', $job_invoice_container_breakup_id)->update($data);

        syncInvoiceItemByCode($cic);
        $alert = array(
            'message' => 'Record Updated Successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
        */
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id, $cic)
    {
       
        DB::beginTransaction();
         try {
            JobInvoiceContainerBreakupItem::find($id)->delete();
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
    public function restore($id, $cic)
    {
       
        DB::beginTransaction();
         try {
            JobInvoiceContainerBreakupItem::withTrashed()->find($id)->restore();
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


    public function destroy($id, $cic)
    {
        DB::beginTransaction();
        try {

            JobInvoiceContainerBreakupItem::withTrashed()->where('id', $id)->forceDelete();
            
            syncInvoiceItemByCode($cic);

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
}
