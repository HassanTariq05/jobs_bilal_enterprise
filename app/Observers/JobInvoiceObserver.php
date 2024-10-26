<?php

namespace App\Observers;

use App\Models\JobInvoice;

use Illuminate\Support\Facades\DB;

class JobInvoiceObserver
{
    /**
     * Handle the JobInvoice "created" event.
     */
    public function created(JobInvoice $jobInvoice): void
    {
        //
    }

    /**
     * Handle the JobInvoice "updated" event.
     */
    public function updated(JobInvoice $jobInvoice): void
    {
        //
    }

    /**
     * Handle the JobInvoice "deleted" event.
     */
    public function deleted(JobInvoice $jobInvoice): void
    {
        //$jobInvoice->items()->delete();
        DB::beginTransaction();
        try {
            $jobInvoice->items()->each(function ($item, $key) {
                $item->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                    $container_breakup->items()->each(function ($container_breakup_item, $key) {
                        $container_breakup_item->delete();
                    });
                    $container_breakup->delete();
                });
                $item->delete();
            });
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoice "restored" event.
     */
    public function restored(JobInvoice $jobInvoice): void
    {
        DB::beginTransaction();
        try {
            $jobInvoice->items()->each(function ($item, $key) {
                $item->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                    $container_breakup->items()->each(function ($container_breakup_item, $key) {
                        $container_breakup_item->restore();
                    });
                    $container_breakup->restore();
                });
                $item->restore();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoice "force deleted" event.
     */
    public function forceDeleted(JobInvoice $jobInvoice): void
    {
        DB::beginTransaction();
        try {
            $jobInvoice->items()->each(function ($item, $key) {
                $item->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                    $container_breakup->items()->each(function ($container_breakup_item, $key) {
                        $container_breakup_item->forceDelete();
                    });
                    $container_breakup->forceDelete();
                });
                $item->forceDelete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
