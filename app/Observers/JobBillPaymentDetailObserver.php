<?php

namespace App\Observers;

use App\Models\JobBillPaymentDetail;

use Illuminate\Support\Facades\DB;

class JobBillPaymentDetailObserver
{
    /**
     * Handle the JobBillPaymentDetail "created" event.
     */
    public function created(JobBillPaymentDetail $jobBillPaymentDetail): void
    {
        //
    }

    /**
     * Handle the JobBillPaymentDetail "updated" event.
     */
    public function updated(JobBillPaymentDetail $jobBillPaymentDetail): void
    {
        //
    }

    /**
     * Handle the JobBillPaymentDetail "deleted" event.
     */
    public function deleted(JobBillPaymentDetail $jobBillPaymentDetail): void
    {
        //
    }

    /**
     * Handle the JobBillPaymentDetail "restored" event.
     */
    public function restored(JobBillPaymentDetail $jobBillPaymentDetail): void
    {
        //
    }

    /**
     * Handle the JobBillPaymentDetail "force deleted" event.
     */
    public function forceDeleted(JobBillPaymentDetail $jobBillPaymentDetail): void
    {
        //
    }
}
