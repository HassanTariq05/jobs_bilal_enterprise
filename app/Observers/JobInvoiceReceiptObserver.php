<?php

namespace App\Observers;

use App\Models\JobInvoiceReceipt;

use Illuminate\Support\Facades\DB;

class JobInvoiceReceiptObserver
{
    /**
     * Handle the JobInvoiceReceipt "created" event.
     */
    public function created(JobInvoiceReceipt $jobInvoiceReceipt): void
    {
        //
    }

    /**
     * Handle the JobInvoiceReceipt "updated" event.
     */
    public function updated(JobInvoiceReceipt $jobInvoiceReceipt): void
    {
        //
    }

    /**
     * Handle the JobInvoiceReceipt "deleted" event.
     */
    public function deleted(JobInvoiceReceipt $jobInvoiceReceipt): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceReceipt->items()->each(function ($item, $key) {
                $item->delete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoiceReceipt "restored" event.
     */
    public function restored(JobInvoiceReceipt $jobInvoiceReceipt): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceReceipt->items()->each(function ($item, $key) {
                $item->restore();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoiceReceipt "force deleted" event.
     */
    public function forceDeleted(JobInvoiceReceipt $jobInvoiceReceipt): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceReceipt->items()->each(function ($item, $key) {
                $item->forceDelete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
