<?php

namespace App\Http\Controllers;

use App\Models\JobBill;
use App\Models\Job;
use App\Models\Company;
use App\Models\Party;
use App\Models\JobBillFile;

use App\Models\JobBillDetail;

use App\Http\Requests\StoreJobBillRequest;
use App\Http\Requests\UpdateJobBillRequest;

use Illuminate\Support\Facades\DB;

use App\Models\JobBillPaymentDetail;

class JobBillController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/bill/";
    public function index()
    {
        access_guard(31);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($job_id)
    {
        access_guard(32);
        $job = Job::find($job_id);
        $vendors = Party::whereRaw(' FIND_IN_SET (2, party_type_id) ')->get();
        if (!$job) {
            return redirect()->route('jobs');
        }
        return view($this->root . 'add', compact('job', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobBillRequest $request)
    {
        access_guard(32);
        DB::beginTransaction();

        try {

            $company = JOB::find($request->job_id);

            $my = date('my', strtotime($request->bill_date));
            $bill_no = '';
            $company_code = "";
            $prefix = 'PNV';
            if ($company) {
                $id = $company->company_id;
                if ($id) {
                    $company = Company::find($id);
                    if ($company) {
                        $company_code = "$company->short_name";
                    }
                }
            }
            $record = JobBill::select('bill_no')->where('bill_no', 'LIKE', "%$my")->orderBy('id', 'desc')->withTrashed()->first();

            if ($record) {
                $lastid = explode('-', $record->bill_no);
                $lastid = (int)$lastid[1] + 1;
                $bill_no = $prefix . '-' . str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $company_code . '-' . $my;
            } else {
                $bill_no = $prefix . '-' . str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $company_code . '-' . $my;
            }

            $data = [
                'job_id' => $request->job_id,
                'party_id' => $request->party_id,
                'bill_date' => $request->bill_date,
                'bill_no' => $bill_no,
                'due_date' => $request->due_date,
                'vendor_ref' => $request->vendor_ref,
            ];
            $row = JobBill::create($data);

            $files = [];
            if (COUNT($request->files)) {
                $request->validate([
                    //'files' => 'required|mimes: jpg, jpeg, png, pdf, xlx, docx, txt |max:2048',
                    'files' => 'required',
                ]);
                $fi = 0;
                foreach ($request->file('files') as $file) {
                    $files[$fi]['title'] = $file->getClientOriginalName();
                    $files[$fi]['ext'] = $file->getClientOriginalExtension();
                    $files[$fi]['path'] = $file->store('job_bill_' . $row->id, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        JobBillFile::create([
                            'job_bill_id' => $row->id,
                            'title' => $file['title'],
                            'ext' => $file['ext'],
                            'file_path' => $file['path'],
                        ]);
                    }
                }
                }
            DB::commit();

            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('create-job-bill-detail', [$request->job_id, $row->id])->with($alert);
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
    public function show(JobBill $jobBill)
    {
        access_guard(31);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobBill $jobBill, $job_id, $job_bill_id)
    {
        access_guard(33);
        $job = Job::find($job_id);
        $row = JobBill::find($job_bill_id);
        $vendors = Party::whereRaw(' FIND_IN_SET (2, party_type_id)')->get();
        if (!$row) {
            return redirect()->route('jobs');
        }
        return view($this->root . 'edit', compact('job', 'row', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobBillRequest $request, JobBill $jobBill, $job_id, $job_bill_id)
    {
        access_guard(33);
        DB::beginTransaction();

        try {

            $data = [
                'job_id' => $request->job_id,
                'party_id' => $request->party_id,
                'bill_date' => $request->bill_date,
                'due_date' => $request->due_date,
                'vendor_ref' => $request->vendor_ref,
            ];
            JobBill::where('id', $job_bill_id)->update($data);

            $files = [];
            if (COUNT($request->files)) {
                $request->validate([
                    //'files' => 'required|mimes: jpg, jpeg, png, pdf, xlx, docx, txt |max:2048',
                    'files' => 'required',
                ]);
                $fi = 0;
                foreach ($request->file('files') as $file) {
                    $files[$fi]['title'] = $file->getClientOriginalName();
                    $files[$fi]['ext'] = $file->getClientOriginalExtension();
                    $files[$fi]['path'] = $file->store('job_invoice_' . $job_bill_id, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        JobBillFile::create([
                            'job_bill_id' => $job_bill_id,
                            'title' => $file['title'],
                            'ext' => $file['ext'],
                            'file_path' => $file['path'],
                        ]);
                    }
                }
            }
            DB::commit();

            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('edit-job', [$job_id])->with($alert);
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
        access_guard(34);
        $payments = JobBillPaymentDetail::where('job_bill_id', $id)->get();
        if ($payments->count()) {
            $alert = array(
                'message' => 'Sorry! you are not allowed to delete this bill untill you delete its payments.',
                'alert-type' => 'error'
            );
        } else {
            DB::beginTransaction();
            try {
                JobBill::find($id)->delete();
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
        }
        return back()->with($alert);
    }
    public function restore($id = 0)
    {
        access_guard(35);
        DB::beginTransaction();
        try {
            JobBill::withTrashed()->find($id)->restore();
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
        access_guard(36);
        $payments = JobBillPaymentDetail::withTrashed()->where('job_bill_id', $id)->get();
        if ($payments->count()) {
            $alert = array(
                'message' => 'Sorry! you are not allowed to delete this bill untill you delete its payments.',
                'alert-type' => 'error'
            );
        } else {
            DB::beginTransaction();
            try {
                JobBill::find($id)->forceDelete();
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
        }
        return back()->with($alert);
    }


    public function get_job_bill_payments($id)
    {
        $output = "<tr><td colspan='9'><div class='alert alert-danger'>Sorry! records not found</div></td></tr>";
        $results = JobBillPaymentDetail::where('job_bill_id', $id)->get();
        if (COUNT($results)) {
            $output = "";
            $c = 1;
            foreach ($results as $r) {
                $output .= "<tr>
                                <td class='text-center'>" . $c . "</td>
                                <td>" . $r->job_bill_payment->payment_no . "</td>
                                <td class='text-right'>" . amount($r->job_bill_payment->sales_tax_with_held + $r->job_bill_payment->income_tax_with_held) . "</td>
                                <td class='text-right'>" . amount($r->job_bill_payment->adjustment_amount) . "</td>
                                <td class='text-right'>" . amount($r->job_bill_payment->instrument_amount) . "</td>
                                <td>" . $r->job_bill_payment->instrument_number . "</td>
                                <td>" . $r->job_bill_payment->payment_mode->title . "</td>
                                <td>" . $r->job_bill_payment->bank->title . "</td>
                            
                                <td class='text-right'>" . amount($r->paid_amount) . "</td>
                            </tr>";
                $c++;
            }
        }
        echo $output;
    }
}
