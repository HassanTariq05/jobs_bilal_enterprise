<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobBill extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'party_id',
        'bill_date',
        'bill_no',
        'due_date',
        'vendor_ref',
    ];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public static function parties()
    {
        $where = " id IN (SELECT party_id FROM job_bills) ";
        return Party::whereRaw($where)->get();
    }

    public function items()
    {
        return $this->hasMany(JobBillDetail::class);
    }


    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function job_bill_details()
    {
        return $this->hasMany(JobBillDetail::class);
    }

    public function job_bill_totals()
    {
        $totals = ['amount'=>0, 'tax'=>0, 'net'=>0];
        foreach($this->job_bill_details as $i)
        {
            $totals['amount'] += $i->amount;
            $totals['tax'] += $i->tax;
            $totals['net'] += $i->net;
        }
        return $totals;
    }


    public function job_bill_total_paid()
    {
        $received = 0;
        $received = JobBillPaymentDetail::where('job_bill_id', $this->id)->sum('total');
        return $received;
    }

    /*
    public function job_bill_total_paid()
    {
        $received = 0;
        $received = JobBillPaymentDetail::where('job_bill_id', $this->id)->sum('paid_amount');
        return $received;
    }
    */

    public function job_bill_balance()
    {
        $totals = $this->job_bill_totals();
        $received = $this->job_bill_total_paid();
        return ($totals['net']-$received);
    }    


    public function payment_details()
    {
        return JobBillPaymentDetail::where('job_bill_id', $this->id)->get();
    }

    
    public function files()
    {
        return $this->hasMany(JobBillFile::class);
    }

}
