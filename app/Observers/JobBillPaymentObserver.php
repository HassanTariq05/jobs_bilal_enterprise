<?php

namespace App\Observers;

use App\Models\JobBillPayment;

use Illuminate\Support\Facades\DB;

class JobBillPaymentObserver
{
    /**
     * Handle the JobBillPayment "created" event.
     */
    public function created(JobBillPayment $jobBillPayment): void
    {
        //
    }

    /**
     * Handle the JobBillPayment "updated" event.
     */
    public function updated(JobBillPayment $jobBillPayment): void
    {
        
    }

    /**
     * Handle the JobBillPayment "deleted" event.
     */
    public function deleted(JobBillPayment $jobBillPayment): void
    {
        DB::beginTransaction();
        try {
            $jobBillPayment->items()->each(function ($item, $key) {
                $item->delete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobBillPayment "restored" event.
     */
    public function restored(JobBillPayment $jobBillPayment): void
    {
        DB::beginTransaction();
        try {
            $jobBillPayment->items()->each(function ($item, $key) {
                $item->restore();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * Handle the JobBillPayment "force deleted" event.
     */
    public function forceDeleted(JobBillPayment $jobBillPayment): void
    {
        DB::beginTransaction();
        try {
            $jobBillPayment->items()->each(function ($item, $key) {
                $item->forceDelete();
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
