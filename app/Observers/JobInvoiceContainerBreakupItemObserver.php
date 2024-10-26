<?php

namespace App\Observers;

use App\Models\JobInvoiceContainerBreakupItem;

use Illuminate\Support\Facades\DB;

class JobInvoiceContainerBreakupItemObserver
{
    /**
     * Handle the JobInvoiceContainerBreakupItem "created" event.
     */
    public function created(JobInvoiceContainerBreakupItem $jobInvoiceContainerBreakupItem): void
    {
        //
    }

    /**
     * Handle the JobInvoiceContainerBreakupItem "updated" event.
     */
    public function updated(JobInvoiceContainerBreakupItem $jobInvoiceContainerBreakupItem): void
    {
        //
    }

    /**
     * Handle the JobInvoiceContainerBreakupItem "deleted" event.
     */
    public function deleted(JobInvoiceContainerBreakupItem $jobInvoiceContainerBreakupItem): void
    {
        //
    }

    /**
     * Handle the JobInvoiceContainerBreakupItem "restored" event.
     */
    public function restored(JobInvoiceContainerBreakupItem $jobInvoiceContainerBreakupItem): void
    {
        //
    }

    /**
     * Handle the JobInvoiceContainerBreakupItem "force deleted" event.
     */
    public function forceDeleted(JobInvoiceContainerBreakupItem $jobInvoiceContainerBreakupItem): void
    {
        //
    }
}
