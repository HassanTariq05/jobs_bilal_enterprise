<?php

namespace App\Observers;

use App\Models\JobInvoiceDetail;

use Illuminate\Support\Facades\DB;

class JobInvoiceDetailObserver
{
    /**
     * Handle the JobInvoiceDetail "created" event.
     */
    public function created(JobInvoiceDetail $jobInvoiceDetail): void
    {
        //
    }

    /**
     * Handle the JobInvoiceDetail "updated" event.
     */
    public function updated(JobInvoiceDetail $jobInvoiceDetail): void
    {
        //
    }

    /**
     * Handle the JobInvoiceDetail "deleted" event.
     */
    public function deleted(JobInvoiceDetail $jobInvoiceDetail): void
    {
        //$jobInvoiceDetail->job_invoice_container_breakups()->delete();
        DB::beginTransaction();
        try {
            $jobInvoiceDetail->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                $container_breakup->items()->each(function ($item, $key) {
                    $item->delete();
                });
                $container_breakup->delete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoiceDetail "restored" event.
     */
    public function restored(JobInvoiceDetail $jobInvoiceDetail): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceDetail->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                $container_breakup->items()->each(function ($item, $key) {
                    $item->restore();
                });
                $container_breakup->restore();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobInvoiceDetail "force deleted" event.
     */
    public function forceDeleted(JobInvoiceDetail $jobInvoiceDetail): void
    {
        DB::beginTransaction();
        try {
            $jobInvoiceDetail->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                $container_breakup->items()->each(function ($item, $key) {
                    $item->forceDelete();
                });
                $container_breakup->forceDelete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
