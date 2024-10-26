<?php

namespace App\Http\Controllers;

use App\Models\JobPerformance;
use App\Models\JobPerformanceSheetData;

use App\Http\Requests\StoreJobPerformanceRequest;
use App\Http\Requests\UpdateJobPerformanceRequest;


use Illuminate\Support\Facades\Auth;

use Excel;
use App\Imports\JobPerformanceImport;

use App\Exports\LocationsExport;
use App\Exports\PartiesExport;


use Illuminate\Support\Facades\DB;

class JobPerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/performance/";
    public function index($id)
    {
        $rows = JobPerformance::where('job_id', $id)->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPerformanceRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $file_original_name = $request->file_original_name;
            $file_original_ext = $request->file_original_ext;
            $file_temp_name = $request->file_temp_name;
            $stored_file = $request->stored_file;

            $data = [
                'job_id' => $id,
                'user_id' => Auth::User()->id,
                'file_original_name' => $file_original_name,
                'file_original_ext' => $file_original_ext,
                'file_temp_name' => $file_temp_name,
                'stored_file' => $stored_file
            ];



            $record = JobPerformance::create($data);

            $rows = Excel::toArray(new JobPerformanceImport, storage_path("app/public/" . $stored_file));
            $rows = $rows[0];

            if(COUNT($rows)){
                for($x=1;$x<COUNT($rows);$x++){

                    $sheet_data = [
                        'job_performance_id' => $record->id,
                        'bl_no' => $rows[$x][1],
                        'container_no' => $rows[$x][2],
                        'size' => $rows[$x][3],
                        'status' => $rows[$x][4],
                        'vehicle_no' => $rows[$x][5],
                        'trucking_mode' => $rows[$x][6],
                        'date' => $rows[$x][7],
                        'loading_port' => $rows[$x][8],
                        'off_loading_port' => $rows[$x][9],
                        'party' => $rows[$x][10],
                        'remarks' => $rows[$x][11],
                    ];
        
                    JobPerformanceSheetData::create($sheet_data);
                }

                DB::commit();

                $alert = array(
                    'message' => "Record has been saved.",
                    'alert-type' => 'success'
                );
                return back()->with($alert);
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

    public function upload_job_performance_sheet(StoreJobPerformanceRequest $request, $id)
    {

        $file_info = [];
        $request->validate([
            //'file' => 'required|mimes:xlsx,xls,csv',
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file;

        $title = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $stored_file = $file->store('job_' . $id, 'public');

        $file_info['file_original_name'] = $title;
        $file_info['file_original_ext'] = $ext;
        $file_info['file_temp_name'] = str_replace("job_$id", '', $stored_file);
        $file_info['stored_file'] = $stored_file;
        $path = $request->file('file')->getRealPath();

        //echo "<pre>";print_r($path.'.'.$ext); exit();

        
        $rows = Excel::toArray(new JobPerformanceImport, $file);
        $rows = $rows[0];
        return redirect()->route('create-job-performance', [$id])->with(['sheet_data' => $rows, 'file' => $file_info]);
    }

    public function download_locations_master()
    {
        return Excel::download(new LocationsExport, 'locations_master.xlsx');
    }
    public function download_parties_master()
    {
        return Excel::download(new PartiesExport, 'parties_master.xlsx');
    }


    /**
     * Display the specified resource.
     */
    public function show(JobPerformance $jobPerformance, $job_id, $id)
    {

        $row = JobPerformance::find($id);
        if(!$row){ 
            $alert = array(
                'message' => "Sorry! records not found.",
                'alert-type' => 'error'
            );
            return redirect()->route('job-performance', [$job_id])->with($alert);
        }


        return view($this->root . 'show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPerformance $jobPerformance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPerformanceRequest $request, JobPerformance $jobPerformance)
    {
        //
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(JobPerformance $jobPerformance)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPerformance $jobPerformance)
    {
        
    }
}
