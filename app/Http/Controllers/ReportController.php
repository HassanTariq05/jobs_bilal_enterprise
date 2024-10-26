<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Job;
//use App\Models\JobInvoice;
use App\Models\JobInvoiceDetail;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private $root = "reports/";
    public function customer_ledger(Request $request)
    {
        access_guard(239);
        $customers = Party::where('party_type_id', 1)->orderBy('title')->get();
        $rows = [];

        /*
        if(isset($request->submit))
        {
            $rows = JobInvoiceDetail::get();
        }
        */

        return view($this->root . 'customer_ledger', compact('customers', 'rows'));
    }

    public function vendor_ledger()
    {
        access_guard(240);
        $rows = [];
        $vendors = Party::where('party_type_id', 2)->orderBy('title')->get();
        return view($this->root . 'vendor_ledger', compact('rows', 'vendors'));
    }

    public function general_ledger()
    {
        access_guard(242);
        $rows = [];
        return view($this->root . 'general_ledger', compact('rows'));
    }

    public function bank_ledger()
    {
        access_guard(241);
        $clients = [];
        $rows = [];
        return view($this->root . 'bank_ledger', compact('rows', 'clients'));
    }

    public function party_wise_surplus_deficit()
    {
        access_guard(248);
        $rows = [];

        return view($this->root . 'party_wise_surplus_deficit', compact('rows'));
    }

    public function job_wise_pnl()
    {
        access_guard(246);
        $rows = [];
        $where = " id>0 ";

        if (isset($_REQUEST['submit'])) {
            $rows = Job::whereRaw($where)->orderBy('id', 'desc')->get();
        }

        return view($this->root . 'job_wise_pnl', compact('rows'));
    }
    /*    
    public function vendors()
    {   
        access_guard(248);
        $rows = [];

        $where = " party_type_id=2 ";

        $vendors = Party::whereRaw($where)->orderBy('title')->get();

        if(isset($_REQUEST['submit'])){
            if($_REQUEST['party_id']){
                $where .= " AND id=".$_REQUEST['party_id'];
            }
            $rows = Party::whereRaw($where)->orderBy('title')->get();
        }

        return view($this->root . 'vendors', compact('vendors', 'rows'));
    }

    public function customers()
    {   
        access_guard(247);
        $rows = [];
        $where = " party_type_id=1 ";
        $customers = Party::whereRaw($where)->orderBy('title')->get();
        if(isset($_REQUEST['submit'])){
            if($_REQUEST['party_id']){
                $where .= " AND id=".$_REQUEST['party_id'];
            }
            $rows = Party::whereRaw($where)->orderBy('title')->get();
        }
        return view($this->root . 'customers', compact('customers', 'rows'));
    }

    public function transactions()
    {   
        access_guard(243);
        $clients = [];
        $rows = [];
        return view($this->root . 'transactions', compact('rows', 'clients'));
    }

    public function collection()
    {   
        access_guard(244);
        $clients = [];
        $rows = [];
        return view($this->root . 'collection', compact('rows', 'clients'));
    }

    public function adjustment()
    {   
        access_guard(245);
        $clients = [];
        $rows = [];
        return view($this->root . 'adjustment', compact('rows', 'clients'));
    }

*/
}
