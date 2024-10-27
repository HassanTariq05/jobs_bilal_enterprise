<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\JobBillPayment;

class JobBillPayments extends Component
{
    /**
     * Create a new component instance.
     */
    private $job_id = 0;
    public function __construct($job_id = 0)
    {
        $this->job_id = $job_id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if($this->job_id){
            $payments=JobBillPayment::where('job_id', $this->job_id)->get();
        }else{
            $payments=JobBillPayment::all();
        }    

        return view('components.job-bill-payments', compact('payments'));
    }
}
