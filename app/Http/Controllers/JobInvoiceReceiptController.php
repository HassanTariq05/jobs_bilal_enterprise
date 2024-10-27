<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\AccountTitle;
use App\Models\JobInvoiceReceipt;
use App\Models\JobInvoiceReceiptDetail;
use App\Models\JobInvoice;
use App\Http\Requests\StoreJobInvoiceReceiptRequest;
use App\Http\Requests\UpdateJobInvoiceReceiptRequest;

use Illuminate\Support\Facades\DB;

class JobInvoiceReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/receipts/";
    public function index()
    {
        access_guard(97);
        $rows = JobInvoiceReceipt::withTrashed()->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(98);
        $inv_info = [];
        if (isset($_REQUEST['inv'])) {
            $id = $_REQUEST['inv'];
            $inv_info = JobInvoice::find($id);
        }
        $clients = JobInvoice::parties();
        $heads = AccountTitle::where('account_nature_id', 4)->orderBY('title')->get();
        return view($this->root . 'add', compact('clients', 'heads', 'inv_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobInvoiceReceiptRequest $request)
    {
        access_guard(98);
        DB::beginTransaction();

        try {

            //$my = '-' . date('y');
            $my = date('y', strtotime($request->document_date));
            $receipt_no = '';
            $prefix = 'RCT';
            if ($request->payment_mode_id == 4) {
                $prefix = 'CRV';
            }
            $record = JobInvoiceReceipt::select('receipt_no')->where('receipt_no', 'LIKE', "%$my")->orderBy('id', 'desc')->withTrashed()->first();
            if ($record) {
                //$lastid = substr($record->receipt_no, 0, -6) + 1;
                $lastid = explode('-', $record->receipt_no);
                $lastid = $lastid[1] + 1;
                $receipt_no = $prefix . '-' . str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $my;
            } else {
                $receipt_no = $prefix . '-' . str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $my;
            }

            $data = [
                'receipt_no' => $receipt_no,
                'document_date' => $request->document_date,
                'sales_tax_territory_id' => $request->sales_tax_territory_id,
                'bank_id' => $request->bank_id,
                'instrument_amount' => $request->instrument_amount,
                'instrument_number' => $request->instrument_number,
                'instrument_date' => $request->instrument_date,
                'received_from' => $request->received_from,
                'bank_account_id' => $request->bank_account_id,
                'payment_mode_id' => $request->payment_mode_id
            ];

            $row = JobInvoiceReceipt::create($data);

            for ($x = 0; $x < count($request->invoice_id); $x++) {

                $sales_tax_with_held = $income_tax_with_held = $adjustment_amount = $received_amount = 0;
                if ($request->sales_tax_with_held[$x]) {
                    $sales_tax_with_held = $request->sales_tax_with_held[$x];
                }
                if ($request->income_tax_with_held[$x]) {
                    $income_tax_with_held = $request->income_tax_with_held[$x];
                }
                if ($request->adjustment_amount[$x]) {
                    $adjustment_amount = $request->adjustment_amount[$x];
                }
                if ($request->received_amount[$x]) {
                    $received_amount = $request->received_amount[$x];
                }

                $total = ($sales_tax_with_held+$income_tax_with_held+$adjustment_amount+$received_amount);

                $data = [
                    'job_invoice_receipt_id' => $row->id,
                    'job_invoice_id' => $request->invoice_id[$x],
                    'sales_tax_with_held' => $sales_tax_with_held,
                    'income_tax_with_held' => $income_tax_with_held,
                    'account_title_id' => $request->account_title_id[$x],
                    'adjustment_amount' => $adjustment_amount,
                    'received_amount' => $received_amount,
                    'total' => $total,
                ];
                JobInvoiceReceiptDetail::create($data);
            }
            DB::commit();
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('create-job-receipt')->with($alert);
        } catch (\Exception $e) {
            DB::rollBack();
            $alert = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($alert);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JobInvoiceReceipt $jobInvoiceReceipt)
    {
        access_guard(97);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobInvoiceReceipt $jobInvoiceReceipt, $id)
    {
        access_guard(99);
        $row = JobInvoiceReceipt::find($id);
        $heads = AccountTitle::where('account_nature_id', 4)->orderBY('title')->get();
        return view($this->root . 'edit', compact('row', 'heads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobInvoiceReceiptRequest $request, JobInvoiceReceipt $jobInvoiceReceipt, $id)
    {
        access_guard(99);
        DB::beginTransaction();

        try {

            $data = [
                'document_date' => $request->document_date,
                'sales_tax_territory_id' => $request->sales_tax_territory_id,
                'bank_id' => $request->bank_id,
                'instrument_amount' => $request->instrument_amount,
                'instrument_number' => $request->instrument_number,
                'instrument_date' => $request->instrument_date,
                'received_from' => $request->received_from,
                'bank_account_id' => $request->bank_account_id,
                'payment_mode_id' => $request->payment_mode_id
            ];
            JobInvoiceReceipt::where('id', $id)->update($data);

            for ($x = 0; $x < count($request->invoice_id); $x++) {

                $sales_tax_with_held = $income_tax_with_held = $adjustment_amount = $received_amount = 0;
                if ($request->sales_tax_with_held) {
                    $sales_tax_with_held = $request->sales_tax_with_held[$x];
                }
                if ($request->income_tax_with_held) {
                    $income_tax_with_held = $request->income_tax_with_held[$x];
                }
                if ($request->adjustment_amount) {
                    $adjustment_amount = $request->adjustment_amount[$x];
                }
                if ($request->received_amount) {
                    $received_amount = $request->received_amount[$x];
                }
                $total = ($sales_tax_with_held+$income_tax_with_held+$adjustment_amount+$received_amount);
                $data = [
                    'job_invoice_receipt_id' => $id,
                    'job_invoice_id' => $request->invoice_id[$x],
                    'sales_tax_with_held' => $sales_tax_with_held,
                    'income_tax_with_held' => $income_tax_with_held,
                    'account_title_id' => $request->account_title_id[$x],
                    'adjustment_amount' => $adjustment_amount,
                    'received_amount' => $received_amount,
                    'total' => $total,
                ];
                JobInvoiceReceiptDetail::where('id', $request->rid[$x])->update($data);
            }
            DB::commit();

            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('create-job-receipt')->with($alert);
        } catch (\Exception $e) {
            DB::rollBack();
            $alert = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($alert);
        }
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(100);
        DB::beginTransaction();
         try {
            JobInvoiceReceipt::find($id)->delete();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been deleted successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function restore($id = 0)
    {
        access_guard(101);
        DB::beginTransaction();
         try {
            JobInvoiceReceipt::withTrashed()->find($id)->restore();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been restored successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }
    public function destroy($id = 0)
    {
        access_guard(102);
        DB::beginTransaction();
         try {
            JobInvoiceReceipt::withTrashed()->find($id)->forceDelete();
             DB::commit();
             $alert = array(
                 'message' => 'Record has been deleted successfully.',
                 'alert-type' => 'success'
             );
         } catch (\Exception $e) {
             DB::rollBack();
             $alert = array(
                 'message' => $e->getMessage(),
                 'alert-type' => 'error'
             );
         }
         return back()->with($alert);
    }


    public function getOutstandingInvoices(Request $request)
    {
        $r = $request->all();
        $where = " id>0 ";
        $output = "";

        if ($r['client_id']) {
            $where .= " AND party_id=" . $r['client_id'];
        }
        if ($r['job_no']) {
            $where .= " AND job_id=(SELECT id FROM jobs WHERE job_no='" . $r['job_no'] . "')";
        }
        if ($r['document_date']) {
            $where .= " AND job_id=(SELECT id FROM jobs WHERE document_date='" . $r['document_date'] . "')";
        }
        $result = JobInvoice::whereRaw($where)->get();

        if ($result) {

            foreach ($result as $row) {
                if ($row->job_invoice_balance() > 0) {
                    $output .= "
                            <tr>
                                <td class='text-center'>
                                    <input 
                                        type='checkbox' 
                                        data-invoice_id='" . $row->id . "'
                                        data-invoice_no='" . $row->inv_no . "'
                                        data-job_no='" . $row->job->job_no . "'
                                        data-location='" . $row->job->location->title . "'
                                        data-party='" . $row->party->title . "'
                                        data-party_short_name='" . $row->party->short_name . "'
                                        data-balance='" . $row->job_invoice_balance() . "'
                                        class='invoices_chk_box'
                                    />
                                </td>
                                <td>" . $row->inv_no . "</td>
                                <td>" . $row->job->job_no . "</td>
                                <td>" . $row->job->location->title . "</td>
                                <td>" . $row->party->title . "</td>
                                <td class='text-right'>" . $row->job_invoice_balance() . "</td>
                            </tr>
                            ";
                }
            }
        }

        if ($output == '') {
            $output = "<tr><td colspan='7' class='alert text-danger'>Sorry! invoices not found</td></tr>";
        }

        echo $output;
    }
}
