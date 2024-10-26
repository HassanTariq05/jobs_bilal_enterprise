<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\JobBillContainerBreakup;
use App\Models\JobBillContainerBreakupItem;
use App\Http\Requests\StoreJobBillContainerBreakupItemRequest;
use App\Http\Requests\UpdateJobBillContainerBreakupItemRequest;

class JobBillContainerBreakupItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $job_id, $job_bill_id)
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
    public function show(Request $request)
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
             JobBillContainerBreakup::where('id', $request->job_bill_container_breakup_id)->update($data);
 
             $data2 = [
                 'job_bill_container_breakup_id' => $request->job_bill_container_breakup_id,
                 'rate' => $request->rate,
             ];
             $ids = explode(',', str_replace(' ','', $request->ids));
             foreach ($ids as $id) {
                 JobBillContainerBreakupItem::where('id', $id)->update($data2);
             }
 
             DB::commit();
 
             syncBillItemByCode($request->cic);
 
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
     }
 
     /**
      * Trash the specified resource from storage.
      */
      public function trash($id, $cic)
      {
         
          DB::beginTransaction();
          try {
             JobBillContainerBreakupItem::find($id)->delete();
             syncBillItemByCode($cic);
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
             JobBillContainerBreakupItem::withTrashed()->find($id)->restore();
             syncBillItemByCode($cic);
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
              JobBillContainerBreakupItem::withTrashed()->where('id', $id)->forceDelete();
              syncBillItemByCode($cic);
  
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
