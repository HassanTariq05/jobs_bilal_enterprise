<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobFile;
use App\Models\JobType;
use App\Models\JobStatus;


use App\Models\JobInvoice;
use App\Models\JobInvoiceFile;
use App\Models\JobInvoiceDetail;
use App\Models\JobInvoiceReceipt;
use App\Models\JobInvoiceReceiptDetail;
use App\Models\JobBill;
use App\Models\JobBillFile;
use App\Models\JobBillDetail;
use App\Models\JobBillPayment;
use App\Models\JobBillPaymentDetail;

use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;

use Illuminate\Support\Facades\DB;


class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $root = "jobs/";
    public function index(Request $request)
    {
        access_guard(67);
        $rows = [];
        $where = '';
        $statuses = JobStatus::withTrashed()->get();

        if (isset($request->search)) {
            if ($request->job_no) {
                $job_no = $request->job_no;
                $where .= " AND job_no='$job_no'";
            }
            if ($request->document_date) {
                $dated = explode(' - ', $request->document_date);
                $sdate = $dated[0];
                $edate = $dated[1];
                $where .= " AND (document_date >= '$sdate' AND document_date <= '$edate')";
            }
            if ($request->party_id) {
                $party_id = $request->party_id;
                $where .= " AND party_id=$party_id";
            }
            if ($request->company_id) {
                $company_id = $request->company_id;
                $where .= " AND company_id=$company_id";
            }
            if ($request->vendor_id) {
                $vendor_id = $request->vendor_id;
                $where .= " AND id IN ( SELECT i.job_id FROM job_invoices AS i WHERE i.party_id=$vendor_id )";
            }
        }

        if (COUNT($statuses)) {
            foreach ($statuses as $status) {
                $status->jobs = Job::whereRaw(" job_status_id=" . $status->id . " $where ")->orderBy('id', 'desc')->get();
                $rows[] = $status;
            }
        }
        return view($this->root . 'list', compact('rows'));
        //dd($rows);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(68);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request, Job $job)
    {
        access_guard(68);
        DB::beginTransaction();

        try {

            $my = date('m-y', strtotime($request->document_date));
            $job_no = '';
            $record = Job::select('job_no')->where('job_no', 'LIKE', "%$my")->orderBy('id', 'desc')->withTrashed()->first();
            if ($record) {
                $lastid = substr($record->job_no, 0, -6) + 1;
                $job_no = str_pad($lastid, 4, "0", STR_PAD_LEFT) . '-' . $my;
            } else {
                $job_no = str_pad(1, 4, "0", STR_PAD_LEFT) . '-' . $my;
            }

            $data = [
                'job_no' => $job_no,
                'party_id' => $request->party_id,
                'company_id' => $request->company_id,
                'location_id' => $request->location_id,
                'job_type_id' => $request->job_type_id,
                'document_date' => $request->document_date,
                'remarks' => $request->remarks,
            ];

            $id = Job::create($data);

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
                    $files[$fi]['path'] = $file->store('job_' . $id->id, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        JobFile::create([
                            'job_id' => $id->id,
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
            
            if(has_permission(80)){
                return redirect()->route('create-job-invoice', [$id->id])->with($alert);
            }else{
                return redirect()->route('jobs')->with($alert);
            }

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
    public function show(Job $job)
    {
        access_guard(67);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job, $id)
    {

        access_guard(69);
        $row = Job::find($id);
        if (!$row) {
            return redirect()->route('jobs');
        }
        $job_types = JobType::all();
        return view($this->root . 'edit', compact('row', 'job_types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobRequest $request, Job $job, $id)
    {
        access_guard(69);
        DB::beginTransaction();

        try {

            $data = [
                'party_id' => $request->party_id,
                'company_id' => $request->company_id,
                'location_id' => $request->location_id,
                'job_type_id' => $request->job_type_id,
                'document_date' => $request->document_date,
                'job_status_id' => $request->job_status_id,
                'remarks' => $request->remarks,
                'approved' => $request->approved,
            ];

            Job::where('id', $id)->update($data);

            $files = [];
            if (COUNT($request->files)) {
                $request->validate([
                    //'files' => 'required|mimes:pdf,xls,xlsx,doc,docx,txt|max:2048',
                    'files' => 'required',
                ]);
                $fi = 0;
                foreach ($request->file('files') as $file) {
                    $files[$fi]['title'] = $file->getClientOriginalName();
                    $files[$fi]['ext'] = $file->getClientOriginalExtension();
                    $files[$fi]['path'] = $file->store('job_' . $id, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        JobFile::create([
                            'job_id' => $id,
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
            return back()->with($alert);
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
        access_guard(70);
        DB::beginTransaction();
         try {
            Job::find($id)->delete();
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
        access_guard(71);
        DB::beginTransaction();
         try {
            Job::withTrashed()->find($id)->restore();
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


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = 0)
    {
        access_guard(72);
        DB::beginTransaction();
         try {
            Job::withTrashed()->find($id)->forceDelete();
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
}
