<?php

namespace App\Observers;

use App\Models\JobInvoiceReceiptDetail;

use Illuminate\Support\Facades\DB;

class JobInvoiceReceiptDetailObserver
{
    /**
     * Handle the JobInvoiceReceiptDetail "created" event.
     */
    public function created(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail): void
    {
        //
    }

    /**
     * Handle the JobInvoiceReceiptDetail "updated" event.
     */
    public function updated(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail): void
    {
        //
    }

    /**
     * Handle the JobInvoiceReceiptDetail "deleted" event.
     */
    public function deleted(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail): void
    {
        //
    }

    /**
     * Handle the JobInvoiceReceiptDetail "restored" event.
     */
    public function restored(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail): void
    {
        //
    }

    /**
     * Handle the JobInvoiceReceiptDetail "force deleted" event.
     */
    public function forceDeleted(JobInvoiceReceiptDetail $jobInvoiceReceiptDetail): void
    {
        //
    }
}
