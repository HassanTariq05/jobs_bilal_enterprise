<?php

namespace App\Http\Controllers;

use App\Models\JobInvoice;
use App\Models\Job;
use App\Models\Company;
use App\Models\BankAccount;
use App\Models\Party;
use App\Models\JobInvoiceFile;


use Illuminate\Http\Request;

use App\Models\JobInvoiceDetail;

use App\Http\Requests\StoreJobInvoiceRequest;
use App\Http\Requests\UpdateJobInvoiceRequest;

use App\Models\JobInvoiceReceiptDetail;

use Illuminate\Support\Facades\DB;

use PDF;

use function Laravel\Prompts\select;

class JobInvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/invoice/";
    
    public function index()
    {
        access_guard(79);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        access_guard(80);
        $job = Job::find($id);
        $customers = Party::whereRaw(' FIND_IN_SET (1, party_type_id) ')->get();

        if (!$job) {
            return redirect()->route('jobs');
        }
        return view($this->root . 'add', compact('id', 'job', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobInvoiceRequest $request)
    {
        access_guard(80);
        DB::beginTransaction();

        try {

            $company = JOB::find($request->job_id);

            $my = date('my', strtotime($request->inv_date));
            $inv_no = '';
            $company_code = "";
            $prefix = 'INV';
            // getting company code
            if ($company) {
                $id = $company->company_id;
                if ($id) {
                    $company = Company::find($id);
                    if ($company) {
                        $company_code = "$company->short_name";
                    }
                }
            }
            $record = JobInvoice::select('inv_no')->where('inv_no', 'LIKE', "%$my")->orderBy('id', 'desc')->withTrashed()->first();

            if ($record) {
                $lastid = explode('-', $record->inv_no);
                $lastid = (int)$lastid[1] + 1;
                $inv_no = $prefix . '-' . str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $company_code . '-' . $my;
            } else {
                $inv_no = $prefix . '-' . str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $company_code . '-' . $my;
            }


            $data = [
                'job_id' => $request->job_id,
                'party_id' => $request->party_id,
                'inv_date' => $request->inv_date,
                'inv_no' => $inv_no
            ];
            $row = JobInvoice::create($data);

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
                    $files[$fi]['path'] = $file->store('job_invoice_' . $row->id, 'public');
                    $fi++;
                }
                // storing file detail in the database
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        JobInvoiceFile::create([
                            'job_invoice_id' => $row->id,
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
            return redirect()->route('create-job-invoice-detail', [$request->job_id, $row->id])->with($alert);
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
    public function show(JobInvoice $jobInvoice)
    {
        access_guard(79);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobInvoice $jobInvoice, $job_id, $job_inv_id)
    {
        access_guard(81);
        $job = Job::find($job_id);
        $row = JobInvoice::find($job_inv_id);
        $customers = Party::whereRaw(' FIND_IN_SET (1, party_type_id) ')->get();

        if (!$row) {
            return redirect()->route('jobs');
        }
        return view($this->root . 'edit', compact('job', 'row', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobInvoiceRequest $request, JobInvoice $jobInvoice, $job_id, $job_invoice_id)
    {
        access_guard(81);
        DB::beginTransaction();

        try {

            $data = [
                'job_id' => $request->job_id,
                'party_id' => $request->party_id,
                'inv_date' => $request->inv_date,
            ];
            JobInvoice::where('id', $job_invoice_id)->update($data);


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
                    $files[$fi]['path'] = $file->store('job_invoice_' . $job_invoice_id, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        JobInvoiceFile::create([
                            'job_invoice_id' => $job_invoice_id,
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
        access_guard(82);
        $receipts = JobInvoiceReceiptDetail::where('job_invoice_id', $id)->get();
        if ($receipts->count()) {
            $alert = array(
                'message' => 'Sorry! you are not allowed to delete this invoice untill you delete its receipts.',
                'alert-type' => 'error'
            );
        } else {
            DB::beginTransaction();
            try {
                JobInvoice::find($id)->delete();
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
        access_guard(83);
        DB::beginTransaction();
        try {
            JobInvoice::withTrashed()->find($id)->restore();
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
        access_guard(84);
        $receipts = JobInvoiceReceiptDetail::withTrashed()->where('job_invoice_id', $id)->get();
        if ($receipts->count()) {
            $alert = array(
                'message' => 'Sorry! you are not allowed to delete this invoice untill you delete its receipts.',
                'alert-type' => 'error'
            );
        } else {
            DB::beginTransaction();
            try {
                JobInvoice::find($id)->forceDelete();
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

    public function get_job_invoice_receipts($id)
    {
        $output = "<tr><td colspan='9'><div class='alert alert-danger'>Sorry! records not found</div></td></tr>";
        $results = JobInvoiceReceiptDetail::where('job_invoice_id', $id)->get();
        if (COUNT($results)) {
            $output = "";
            $c = 1;
            foreach ($results as $r) {
                $output .= "<tr>
                            <td class='text-center'>" . $c . "</td>
                            <td>" . $r->job_invoice_receipt->receipt_no . "</td>
                            <td class='text-right'>" . amount($r->sales_tax_with_held + $r->income_tax_with_held) . "</td>
                            <td class='text-right'>" . amount($r->adjustment_amount) . "</td>
                            <td class='text-right'>" . amount($r->job_invoice_receipt->instrument_amount) . "</td>
                            <td>" . $r->job_invoice_receipt->instrument_number . "</td>
                            <td>" . $r->job_invoice_receipt->payment_mode->title . "</td>
                            <td>" . $r->job_invoice_receipt->bank->title . "</td>
                            <td class='text-right'>" . amount($r->received_amount) . "</td>
                        </tr>";
                $c++;
            }
        }
        echo $output;
    }

    public function generate_invoice_pdf(Request $request, $id)
    {
        $submit = 0;
        $tax_invoice = 1;
        $bank_account = [];
        $inv = [];

        $inv = JobInvoice::find($id);
        $bank_accounts = BankAccount::all();

        if (isset($request->submit)) {

            $tax_invoice = $request->tax_invoice;

            $submit = 1;
            $bank_account = BankAccount::find($request->bank_account_id);      
            $pdf = PDF::loadView($this->root . 'generate_invoice_pdf', compact('id', 'bank_accounts', 'inv', 'submit', 'tax_invoice', 'bank_account'))->setPaper('A4','portrait');
            return $pdf->download("job_invoice_$id.pdf"); 
        }
        /*
        if (isset($request->submit)) {             
            $pdf = PDF::loadView($this->root . 'generate_invoice_pdf', compact('id', 'bank_accounts', 'inv', 'submit', 'tax_invoice', 'bank_account'))->setPaper('A4','portrait');
            return $pdf->download("job_invoice_$id.pdf");    
        }
        */

        return view($this->root . 'generate_invoice_pdf_form', compact('id', 'bank_accounts', 'inv', 'submit', 'tax_invoice', 'bank_account'));

    }

    public function generate_invoice_summary_pdf(Request $request, $id)
    {
        $submit = 0;
        $tax_invoice = 1;
        $bank_account = [];
        $invoices = [];

        $invoices = JobInvoice::where('job_id', $id)->get();
        $bank_accounts = BankAccount::all();

        $customerQuery = 
        "   SELECT jobs.parties.title, jobs.parties.ntn
            FROM jobs.jobs
            JOIN jobs.parties ON jobs.jobs.party_id = jobs.parties.id
            WHERE jobs.jobs.id= $id;
        ";
        $customer = Db::select($customerQuery);

        $locationQuery = 
        "   SELECT jobs.locations.title
            FROM jobs.locations
            JOIN jobs.jobs ON jobs.jobs.location_id = jobs.locations.id
            WHERE jobs.jobs.id= $id;
        ";
        $location = Db::select($locationQuery);

        $companyNtnQuery = "
            SELECT jobs.companies.ntn
            FROM jobs.jobs
            JOIN jobs.companies ON jobs.jobs.company_id = jobs.companies.id
            WHERE jobs.jobs.id= $id;        
        ";

        $companyNtn = Db::select($companyNtnQuery);

        if (isset($request->submit)) {
            $tax_invoice = $request->tax_invoice;
            $submit = 1;

            $bank_account = BankAccount::find($request->bank_account_id);

            $pdf = PDF::loadView(
                $this->root . 'generate_invoice_summary_pdf',
                compact('id', 'customer', 'location', 'companyNtn', 'bank_accounts', 'invoices', 'submit', 'tax_invoice', 'bank_account')
            )->setPaper('A4', 'portrait');

            return $pdf->download("invoices_summary_job_$id.pdf");
        }

        

        return view(
            $this->root . 'generate_invoice_summary_pdf_form',
            compact('id', 'customer', 'bank_accounts', 'invoices', 'submit', 'tax_invoice', 'bank_account')
        );
    }
}
