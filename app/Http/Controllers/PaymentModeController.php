<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use App\Http\Requests\StorePaymentModeRequest;
use App\Http\Requests\UpdatePaymentModeRequest;

use Illuminate\Support\Facades\DB;

class PaymentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        access_guard(13);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(14);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentModeRequest $request)
    {
        access_guard(14);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMode $paymentMode)
    {
        access_guard(13);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMode $paymentMode)
    {
        access_guard(15);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentModeRequest $request, PaymentMode $paymentMode)
    {
        access_guard(15);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(16);
        DB::beginTransaction();
         try {
            PaymentMode::find($id)->delete();
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
        access_guard(17);
        DB::beginTransaction();
         try {
            PaymentMode::withTrashed()->find($id)->restore();
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
        access_guard(18);
        DB::beginTransaction();
         try {
            PaymentMode::withTrashed()->find($id)->forceDelete();
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
