<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AccountTitle;
use App\Models\JobBillPayment;
use App\Models\JobBillPaymentDetail;
use App\Models\JobBill;
use App\Http\Requests\StoreJobBillPaymentRequest;
use App\Http\Requests\UpdateJobBillPaymentRequest;

use Illuminate\Support\Facades\DB;

class JobBillPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/payments/";
    public function index()
    {
        access_guard(49);
        $rows = JobBillPayment::withTrashed()->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(50);
        $bill_info = [];
        if (isset($_REQUEST['bill'])) {
            $id = $_REQUEST['bill'];
            $bill_info = JobBill::find($id);
        }
        $vendors = JobBill::parties();
        $heads = AccountTitle::where('account_nature_id', 5)->orderBY('title')->get();
        return view($this->root . 'add', compact('vendors', 'heads', 'bill_info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBillPaymentRequest $request)
    {
        access_guard(50);
        DB::beginTransaction();
        try {

            $my = date('y', strtotime($request->document_date));
            $payment_no = '';
            $prefix = 'PMT';
            if ($request->payment_mode_id == 4) {
                $prefix = 'CPV';
            }
            $record = JobBillPayment::select('payment_no')->where('payment_no', 'LIKE', "%$my")->orderBy('id', 'desc')->withTrashed()->first();
            if ($record) {
                $lastid = explode('-', $record->payment_no);
                $lastid = $lastid[1] + 1;
                $payment_no = $prefix . '-' . str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $my;
            } else {
                $payment_no = $prefix . '-' . str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $my;
            }

            $data = [
                'payment_no' => $payment_no,
                'document_date' => $request->document_date,
                'sales_tax_territory_id' => $request->sales_tax_territory_id,
                'bank_id' => $request->bank_id,
                'instrument_amount' => $request->instrument_amount,
                'instrument_number' => $request->instrument_number,
                'instrument_date' => $request->instrument_date,
                'paid_to' => $request->paid_to,
                'bank_account_id' => $request->bank_account_id,
                'payment_mode_id' => $request->payment_mode_id
            ];
            $row = JobBillPayment::create($data);

            for ($x = 0; $x < count($request->bill_id); $x++) {

                $sales_tax_with_held = $income_tax_with_held = $adjustment_amount = $paid_amount = 0;
                if ($request->sales_tax_with_held[$x]) {
                    $sales_tax_with_held = $request->sales_tax_with_held[$x];
                }
                if ($request->income_tax_with_held[$x]) {
                    $income_tax_with_held = $request->income_tax_with_held[$x];
                }
                if ($request->adjustment_amount[$x]) {
                    $adjustment_amount = $request->adjustment_amount[$x];
                }
                if ($request->paid_amount[$x]) {
                    $paid_amount = $request->paid_amount[$x];
                }
                $total = ($sales_tax_with_held+$income_tax_with_held+$adjustment_amount+$paid_amount);
                $data = [
                    'job_bill_payment_id' => $row->id,
                    'job_bill_id' => $request->bill_id[$x],
                    'sales_tax_with_held' => $sales_tax_with_held,
                    'income_tax_with_held' => $income_tax_with_held,
                    'account_title_id' => $request->account_title_id[$x],
                    'adjustment_amount' => $adjustment_amount,
                    'paid_amount' => $paid_amount,
                    'total' => $total,
                ];
                JobBillPaymentDetail::create($data);
            }
            DB::commit();

            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('create-job-payment')->with($alert);
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
    public function show(JobBillPayment $jobBillPayment)
    {
        access_guard(49);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBillPayment $jobBillPayment, $id)
    {
        access_guard(51);
        $row = JobBillPayment::find($id);
        $heads = AccountTitle::where('account_nature_id', 4)->orderBY('title')->get();
        return view($this->root . 'edit', compact('row', 'heads'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobBillPaymentRequest $request, JobBillPayment $jobBillPayment, $id)
    {
        access_guard(51);
        DB::beginTransaction();
        try {
            $data = [
                'document_date' => $request->document_date,
                'sales_tax_territory_id' => $request->sales_tax_territory_id,
                'bank_id' => $request->bank_id,
                'instrument_amount' => $request->instrument_amount,
                'instrument_number' => $request->instrument_number,
                'instrument_date' => $request->instrument_date,
                'paid_to' => $request->paid_to,
                'bank_account_id' => $request->bank_account_id,
                'payment_mode_id' => $request->payment_mode_id
            ];
            JobBillPayment::where('id', $id)->update($data);

            for ($x = 0; $x < count($request->bill_id); $x++) {

                $sales_tax_with_held = $income_tax_with_held = $adjustment_amount = $paid_amount = 0;
                if ($request->sales_tax_with_held) {
                    $sales_tax_with_held = $request->sales_tax_with_held[$x];
                }
                if ($request->income_tax_with_held) {
                    $income_tax_with_held = $request->income_tax_with_held[$x];
                }
                if ($request->adjustment_amount) {
                    $adjustment_amount = $request->adjustment_amount[$x];
                }
                if ($request->paid_amount) {
                    $paid_amount = $request->paid_amount[$x];
                }
                $total = ($sales_tax_with_held+$income_tax_with_held+$adjustment_amount+$paid_amount);
                $data = [
                    'job_bill_payment_id' => $id,
                    'job_bill_id' => $request->bill_id[$x],
                    'sales_tax_with_held' => $sales_tax_with_held,
                    'income_tax_with_held' => $income_tax_with_held,
                    'account_title_id' => $request->account_title_id[$x],
                    'adjustment_amount' => $adjustment_amount,
                    'paid_amount' => $paid_amount,
                    'total' => $total,
                ];
                JobBillPaymentDetail::where('id', $request->rid[$x])->update($data);
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
        access_guard(52);
        DB::beginTransaction();
         try {
            JobBillPayment::find($id)->delete();
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
        access_guard(53);
        DB::beginTransaction();
         try {
            JobBillPayment::withTrashed()->find($id)->restore();
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
        access_guard(54);
        $record = JobBillPayment::withTrashed()->find($id);
        if (!is_null($record)) {
            $record->forceDelete();
            $alert = array(
                'message' => 'Record deleted successfully',
                'alert-type' => 'success'
            );
        } else {
            $alert = array(
                'message' => 'Unable to delete record.',
                'alert-type' => 'error'
            );
        }
        return back()->with($alert);
    }

    public function getOutstandingBills(Request $request)
    {
        $r = $request->all();
        $where = " id>0 ";
        $output = "";

        if ($r['vendor_id']) {
            $where .= " AND party_id=" . $r['vendor_id'];
        }
        if ($r['job_no']) {
            $where .= " AND job_id=(SELECT id FROM jobs WHERE job_no='" . $r['job_no'] . "')";
        }
        if ($r['document_date']) {
            $where .= " AND job_id=(SELECT id FROM jobs WHERE document_date='" . $r['document_date'] . "')";
        }
        $result = JobBill::whereRaw($where)->get();

        if ($result) {

            foreach ($result as $row) {
                if ($row->job_bill_balance() > 0) {
                    $output .= "
                            <tr>
                                <td class='text-center'>
                                    <input 
                                        type='checkbox' 
                                        data-bill_id='" . $row->id . "'
                                        data-bill_no='" . $row->bill_no . "'
                                        data-job_no='" . $row->job->job_no . "'
                                        data-location='" . $row->job->location->title . "'
                                        data-party='" . $row->party->title . "'
                                        data-party_short_name='" . $row->party->short_name . "'
                                        data-balance='" . $row->job_bill_balance() . "'
                                        class='bills_chk_box'
                                    />
                                </td>
                                <td>" . $row->bill_no . "</td>
                                <td>" . $row->job->job_no . "</td>
                                <td>" . $row->job->location->title . "</td>
                                <td>" . $row->party->title . "</td>
                                <td class='text-right'>" . $row->job_bill_balance() . "</td>
                            </tr>
                            ";
                }
            }
        }

        if ($output == '') {
            $output = "<tr><td colspan='7' class='alert text-danger'>Sorry! bills not found</td></tr>";
        }

        echo $output;
    }
}
