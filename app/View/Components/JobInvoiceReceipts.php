<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\JobInvoiceReceipt;
use App\Models\JobInvoiceReceiptDetail;

class JobInvoiceReceipts extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        /*
        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        $seg3 = request()->segment(3);

        if($seg1=='jobs' && $seg2='edit'){
            //$receipts=JobInvoiceReceipt::whereIn('receipt_no', $seg3)->get();
            //$receipts=JobInvoiceReceipt::whereIn('id', JobInvoiceReceiptDetail::select->('id')->where('job_invoice_id'))->get();

        }else{
            $receipts=JobInvoiceReceipt::all();
        }    
        */
        $receipts=JobInvoiceReceipt::all();
        return view('components.job-invoice-receipts', compact('receipts'));
    }
}
