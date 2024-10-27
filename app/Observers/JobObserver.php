<?php

namespace App\Observers;

use App\Models\Job;

use Illuminate\Support\Facades\DB;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     */
    public function created(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "updated" event.
     */
    public function updated(Job $job): void
    {
        //
    }

    /**
     * Handle the Job "deleted" event.
     */
    public function deleted(Job $job): void
    {
        //$job->job_invoices()->each()->delete();
        DB::beginTransaction();
        try {
            $job->job_invoices()->each(function ($invoice, $key) {
                $invoice->items()->each(function ($item, $key) {
                    $item->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                        $container_breakup->items()->each(function ($container_breakup_item, $key) {
                            $container_breakup_item->delete();
                        });
                        $container_breakup->delete();
                    });
                    $item->delete();
                });
                $invoice->delete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the Job "restored" event.
     */
    public function restored(Job $job): void
    {
        DB::beginTransaction();
        try {
            $job->job_invoices()->each(function ($invoice, $key) {
                $invoice->items()->each(function ($item, $key) {
                    $item->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                        $container_breakup->items()->each(function ($container_breakup_item, $key) {
                            $container_breakup_item->restore();
                        });
                        $container_breakup->restore();
                    });
                    $item->restore();
                });
                $invoice->restore();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the Job "force deleted" event.
     */
    public function forceDeleted(Job $job): void
    {
        DB::beginTransaction();
        try {
            $job->job_invoices()->each(function ($invoice, $key) {
                $invoice->items()->each(function ($item, $key) {
                    $item->job_invoice_container_breakups()->each(function ($container_breakup, $key) {
                        $container_breakup->items()->each(function ($container_breakup_item, $key) {
                            $container_breakup_item->forceDelete();
                        });
                        $container_breakup->forceDelete();
                    });
                    $item->forceDelete();
                });
                $invoice->forceDelete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
