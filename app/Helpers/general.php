<?php

use App\Models\RolePrivilege;
use App\Models\Party;
use App\Models\Location;

use App\Models\Job;
use App\Models\JobInvoiceDetail;
use App\Models\JobInvoiceContainerBreakup;
use App\Models\JobInvoiceContainerBreakupItem;

use App\Models\JobBillDetail;
use App\Models\JobBillContainerBreakup;
use App\Models\JobBillContainerBreakupItem;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

function getFromStorage($ref = '')
{
    $output = '/assets/img/no-image.png';
    if (!empty($ref)) {
        //$output = Storage::url("app/public/$ref");
        $output = storage_path("app/public/$ref");
        //$output = Storage::url("app/public/$ref");
        //$output = Storage::url("$ref");
    }
    return $output;
}

function syncInvoiceItemByCode($cic)
{
    $invoice_item = JobInvoiceDetail::where('container_item_code', $cic)->first();
    //echo "invoice_item <pre>"; print_r($invoice_item);
    if ($invoice_item) {
        //echo "invoice_item<pre>"; print_r($invoice_item);
        $container_breakups = JobInvoiceContainerBreakup::where('job_invoice_detail_id', $invoice_item->id)->get();
        //echo "container breakups <pre>"; print_r($container_breakups);
        if ($container_breakups) {
            $container_breakups_qty = 0;
            $container_breakups_rate = [];
            $container_breakups_amount = 0;
            $container_breakups_tax_percentage = [];
            $container_breakups_tax = 0;
            $container_breakups_net = 0;
            $container_breakups_description = [];
            foreach ($container_breakups as $container_breakup) {
                $record = $container_breakup->update_container_breakup_totals();
                $container_breakups_qty += $record->qty;
                $container_breakups_rate[] = $record->rate;
                $container_breakups_amount += $record->amount;
                $container_breakups_tax_percentage[] = $record->tax_percentage;
                $container_breakups_tax += $record->tax;
                $container_breakups_net += $record->net;
                $container_breakups_description[] = $record->description;
            }
            //if ($container_breakups_net > 0) {
            $get_rate = $tax_percentage = 0;
            if ($container_breakups_amount > 0) {
                $get_rate = (array_sum($container_breakups_rate) / $container_breakups_amount);
            }
            $percentage_counter = COUNT($container_breakups_tax_percentage);
            if ($percentage_counter > 0) {
                $tax_percentage = (array_sum($container_breakups_tax_percentage) / $percentage_counter);
            }
            $data = [
                'qty' => $container_breakups_qty,
                'rate' => $get_rate,
                'amount' => $container_breakups_amount,
                'tax_percentage' => $tax_percentage,
                'tax' => $container_breakups_tax,
                'net' => $container_breakups_net,
                'description' => implode(', ', $container_breakups_description),
            ];
            JobInvoiceDetail::where('container_item_code', $cic)->update($data);
            //}
        }
    }




    /*
    $invoice_item = JobInvoiceDetail::where('container_item_code', $cic)->first();
    if ($invoice_item) {
        echo "invoice_item<pre>";
        print_r($invoice_item);
        $container_breakups = JobInvoiceContainerBreakup::where('job_invoice_detail_id', $invoice_item->id)->get();
        if ($container_breakups) {
            $container_breakups_total = 0;
            foreach($container_breakups as $container_breakup){
                $container_breakup_items = JobInvoiceContainerBreakupItem::where('job_invoice_container_breakup_id', $container_breakup->id)->get();
                if($container_breakup_items){
                    $container_breakup_items_total = 0;
                    foreach($container_breakup_items as $container_breakup_item){
                        $container_breakup_items_total += $container_breakup_item->rate;
                    }
                    $data = [
                        'amount' => $container_breakup_items_total,
                        'net' => ($container_breakup_items_total+$container_breakup->tax)
                    ];
                    JobInvoiceContainerBreakup::where('id',$container_breakup_item->id)->update();
                }
            }
        }
        echo "container_breakups<pre>";
        print_r($container_breakups);
        exit();
    }
    */
}

function syncBillItemByCode($cic)
{


    $bill_item = JobBillDetail::where('container_item_code', $cic)->first();
    if ($bill_item) {

        $container_breakups = JobBillContainerBreakup::where('job_bill_detail_id', $bill_item->id)->get();

        if ($container_breakups) {
            $container_breakups_qty = 0;
            $container_breakups_rate = [];
            $container_breakups_amount = 0;
            $container_breakups_tax_percentage = [];
            $container_breakups_tax = 0;
            $container_breakups_net = 0;
            $container_breakups_description = [];
            foreach ($container_breakups as $container_breakup) {
                $record = $container_breakup->update_container_breakup_totals();

                $container_breakups_qty += $record->qty;
                $container_breakups_rate[] = $record->rate;
                $container_breakups_amount += $record->amount;
                $container_breakups_tax_percentage[] = $record->tax_percentage;
                $container_breakups_tax += $record->tax;
                $container_breakups_net += $record->net;
                $container_breakups_description[] = $record->description;
            }

            //if ($container_breakups_net > 0) {
            $get_rate = $tax_percentage = 0;

            if ($container_breakups_amount > 0) {
                $get_rate = (array_sum($container_breakups_rate) / $container_breakups_amount);
            }

            $percentage_counter = COUNT($container_breakups_tax_percentage);
            if ($percentage_counter > 0) {
                $tax_percentage = (array_sum($container_breakups_tax_percentage) / $percentage_counter);
            }

            $data = [
                'qty' => $container_breakups_qty,
                'rate' => $get_rate,
                'amount' => $container_breakups_amount,
                'tax_percentage' => $tax_percentage,
                'tax' => $container_breakups_tax,
                'net' => $container_breakups_net,
                'description' => implode(', ', $container_breakups_description),
            ];
            JobBillDetail::where('container_item_code', $cic)->update($data);

            //}
        }
    }
}

function amount($ref, $decimal=2)
{
    return number_format($ref, $decimal);
}

function has_permission($privilege_id = 0)
{
    //echo '192 = '.$privilege_id;
    $output = 0;
    if (Auth::user()->id < 2) {
        $output = 1;
    } else {
        if ($privilege_id > 0) {
            $role_id = Auth::user()->user_role_id;
            $result = RolePrivilege::where('role_id', $role_id)->where('privilege_id', $privilege_id)->get();            
            if ($result->count()) {
                $output = 1;
            }
        }
    }
    return $output;
}

function has_category_permission($privilege_category_id = 0)
{
    //echo '192 = '.$privilege_id;
    $output = 0;
    if (Auth::user()->id < 2) {
        $output = 1;
    } else {
        if ($privilege_category_id > 0) {
            $role_id = Auth::user()->user_role_id;
            $result = 
            RolePrivilege::
                select('role_privileges.*', 'p.*')
                ->join('privileges as p', 'role_privileges.privilege_id', 'p.id')
                ->join('privilege_groups as pg', 'p.privilege_group_id', 'pg.id')
                ->join('privilege_categories as pc', 'pg.privilege_category_id', 'pc.id')
                ->where('role_id', $role_id)
                ->where('pc.id', $privilege_category_id)
                ->get();
                // dd($result);            
            if ($result->count() > 0) {
                $output = 1;
            }
        }
    }
    return $output;
}

function has_group_permission($privilege_group_id = 0)
{
    //echo '192 = '.$privilege_id;
    $output = 0;
    if (Auth::user()->id < 2) {
        $output = 1;
    } else {
        if ($privilege_group_id > 0) {
            $role_id = Auth::user()->user_role_id;
            $result = 
            RolePrivilege::
                select('role_privileges.*', 'p.*')
                ->join('privileges as p', 'role_privileges.privilege_id', 'p.id')
                ->join('privilege_groups as pg', 'p.privilege_group_id', 'pg.id')
                ->where('role_id', $role_id)
                ->where('pg.id', $privilege_group_id)
                ->get();
                // dd($result);            
            if ($result->count() > 0) {
                $output = 1;
            }
        }
    }
    return $output;
}

function get_specific_field_by_id($table, $field, $id = 0)
{
    $output = '';
    if (!empty($table) && !empty($field)) {
        //$result = DB::table($table)->select($field)->where('id', $id)->get();
        $result = DB::table($table)->where('id', $id)->pluck($field)->all();
        $output = $result[0];
        //->select($field)->where('id', $id)->get();
    }
    return $output;
}

function access_guard($privilege_id = 0)
{
    if (!has_permission($privilege_id)) {
        abort(403);
        //return redirect()->route('dashboard'); 
    }
}

function check_performance_sheet_data_error($cell_address, $value)
{
    $output = [
        'error' => 0,
        'class' => '',
        'message' => ''
    ];
    $error_cell = "border-danger border text-danger";

    $column = preg_replace('/[0-9]/', '', $cell_address);



    if ($column == "B") {
        $e = 0;
        $pattern = '/^[\w&.\-]+$/';
        if (!preg_match($pattern, $value)) {
            $e++;
        }
        if ($e > 0) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "BL no. is not appropriate. Remove space/Special Characters etc."
            ];
        }
    }
    if ($column == "C") {
        $e = 0;
        $alpha = substr($value, 0, 4);
        $numeric = substr($value, -7);
        if (strlen($value) != 11) {
            $e++;
        }
        if (!is_numeric($numeric)) {
            $e++;
        }
        if (!ctype_alpha($alpha)) {
            $e++;
        }
        if ($e > 0) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Container no. is not correct."
            ];
        }
    }
    if ($column == "D") {
        $e = 0;
        //if ((intval($value) != intval(20)) || (intval($value) != intval(40))) {
        if (!in_array(intval($value), [20, 40])) {
            $e++;
        }
        if ($e > 0) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Size should be whether 20 or 40"
            ];
        }
    }
    if ($column == "E") {
        if (strtolower($value) !== "full" && strtolower($value) !== 'empty') {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Status should be Empty or Full."
            ];
        }
    }
    if ($column == "F") {
        $e = 0;
        if (!ctype_alnum($value)) {
            $e++;
        }
        if (preg_match('/\s/', $value)) {
            $e++;
        }
        if (is_numeric($value)) {
            $e++;
        }
        if (ctype_alpha($value)) {
            $e++;
        }
        if ($e > 0) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Vehicle no. should contain alphanumeric value."
            ];
        }
    }
    if ($column == "G") {
        if (strtolower($value) !== "owned" && strtolower($value) !== 'private') {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Trucking mode should be Owned or Private."
            ];
        }
    }
    if ($column == "H") {
        $e = 0;
        if (strlen($value) != 10) {
            $e++;
        }
        $exploaded_date = explode('-', $value);
        if (COUNT($exploaded_date) != 3) {
            $e++;
        }
        if (isset($exploaded_date[0]) && ((strlen($exploaded_date[0]) != 2) || ($exploaded_date[0] > 31))) {
            $e++;
        }
        if (isset($exploaded_date[1]) && ((strlen($exploaded_date[1]) != 2) || ($exploaded_date[1] > 12))) {
            $e++;
        }
        if (isset($exploaded_date[2]) && (strlen($exploaded_date[2]) != 4)) {
            $e++;
        }
        if ($e > 0) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Use dd/mm/yyyy format only"
            ];
        }
    }
    if ($column == "I") {
        $row = Location::where(strtolower('title'), strtolower($value))->get();
        if (!$row->count()) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Please create location via setup form"
            ];
        }
    }
    if ($column == "J") {
        $row = Location::where(strtolower('title'), strtolower($value))->get();
        if (!$row->count()) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Please create location via setup form"
            ];
        }
    }
    if ($column == "K") {
        $row = Party::where(strtolower('title'), strtolower($value))->get();
        if (!$row->count()) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "Please create party via setup form."
            ];
        }
    }
    if ($column == "L") {
        if (strlen($value) > 200) {
            $output = [
                'error' => 1,
                'class' => $error_cell,
                'message' => "No more than 200 characters."
            ];
        }
    }

    return $output;
}

function get_job_invoice_container_breakup_items_array($job_id = 0)
{
    $output = [];
    $job = Job::find($job_id);
    if ($job->job_invoices->count()) {
        foreach ($job->job_invoices as $invoice) {
            if ($invoice->job_invoice_details->count()) {
                foreach ($invoice->job_invoice_details as $detail) {                    
                    if ($detail->job_invoice_container_breakups->count()) {
                        foreach ($detail->job_invoice_container_breakups as $breakup) {
                            $head = $breakup->account_title_id;
                            if ($breakup->items->count()) {
                                foreach ($breakup->items as $item) {
                                    $output [] = $head.'_'.$item->container_no.'_'.$item->status;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $output;
}

function get_job_bill_container_breakup_items_array($job_id = 0)
{
    $output = [];
    $job = Job::find($job_id);
    if ($job->job_bills->count()) {
        foreach ($job->job_bills as $bill) {
            if ($bill->job_bill_details->count()) {
                foreach ($bill->job_bill_details as $detail) {    
                    $c = $detail->job_bill_container_breakups ? $detail->job_bill_container_breakups->count() : 0;                
                    if ($c) {
                        foreach ($detail->job_bill_container_breakups as $breakup) {
                            $head = $breakup->account_title_id;
                            if ($breakup->items->count()) {
                                foreach ($breakup->items as $item) {
                                    $output [] = $head.'_'.$item->container_no.'_'.$item->status;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return $output;
}