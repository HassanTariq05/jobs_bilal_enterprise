<?php

namespace App\Observers;

use App\Models\JobInvoiceContainerBreakup;

use Illuminate\Support\Facades\DB;

class JobInvoiceContainerBreakupObserver
{
    /**
     * Handle the JobInvoiceContainerBreakup "created" event.
     */
    public function created(JobInvoiceContainerBreakup $jobInvoiceContainerBreakup): void
    {
        //
    }

    /**
     * Handle the JobInvoiceContainerBreakup "updated" event.
     */
    public function updated(JobInvoiceContainerBreakup $jobInvoiceContainerBreakup): void
    {
        //
    }

    /**
     * Handle the JobInvoiceContainerBreakup "deleted" event.
     */
    public function deleted(JobInvoiceContainerBreakup $jobInvoiceContainerBreakup): void
    {
        //$jobInvoiceContainerBreakup->items()->delete();

        DB::beginTransaction();
        try {
            $jobInvoiceContainerBreakup->items()->each(function ($item, $key) {
                $item->delete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoiceContainerBreakup "restored" event.
     */
    public function restored(JobInvoiceContainerBreakup $jobInvoiceContainerBreakup): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceContainerBreakup->items()->each(function ($item, $key) {
                $item->restore();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoiceContainerBreakup "force deleted" event.
     */
    public function forceDeleted(JobInvoiceContainerBreakup $jobInvoiceContainerBreakup): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceContainerBreakup->items()->each(function ($item, $key) {
                $item->forceDelete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
