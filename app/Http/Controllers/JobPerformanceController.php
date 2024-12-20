<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingContainers;
use App\Models\Fleet;
use App\Models\Job;
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
use Request;

class JobPerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "jobs/performance/";
    public function index2($id)
    {
        $rows = JobPerformance::where('job_id', $id)->get();
        $fleet = Fleet::get();
        
        $job = Job::select(
            'job_types.title as job_type',
            'jobs.*'
        )
        ->leftJoin('job_types', 'job_types.id', 'jobs.job_type_id')
        ->where('jobs.id', $id)
        ->first();

        $bookings = Booking::select(
            'parties.title as customer_name', 
            'locations.title as location_name', 
            'lp.title as lp_name', 
            'offload_l.title as offload_name', 
            'bookings.*'
        )
        ->leftJoin('parties', 'parties.id', 'bookings.customer')
        ->leftJoin('locations', 'locations.id', 'bookings.location')
        ->leftJoin('locations as lp', 'lp.id', 'bookings.loading_port')
        ->leftJoin('locations as offload_l', 'offload_l.id', 'bookings.off_load')
        ->where('job_type', $job->job_type_id)
        ->where('status', 'POST')
        ->get();

        foreach($bookings as $b):
            $containers = BookingContainers::where('bl_no', $b->bl_no)->get();
            $pendingContainers = BookingContainers::where('bl_no', $b->bl_no)->where('activity_status', 'PENDING')->get();
            $b['total_containers'] = count($containers);
            $b['pending_containers'] = count($pendingContainers);
        endforeach;

        return view($this->root . 'activity', compact('rows', 'job', 'bookings', 'fleet'));

    }

    public function index($id)
    {
        $job = Job::where('id', $id)->first();
        $rows = JobPerformance::where('job_id', $id)->get();

        return view($this->root . 'list', compact('rows', 'job'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($jobId)
    {
        $job = Job::select(
            'job_types.title as job_type',
            'jobs.*'
        )
        ->leftJoin('job_types', 'job_types.id', 'jobs.job_type_id')
        ->where('jobs.id', $jobId)
        ->first();

        $bookings = Booking::select(
            'parties.title as customer_name', 
            'locations.title as location_name', 
            'lp.title as lp_name', 
            'offload_l.title as offload_name', 
            'bookings.*'
        )
        ->leftJoin('parties', 'parties.id', 'bookings.customer')
        ->leftJoin('locations', 'locations.id', 'bookings.location')
        ->leftJoin('locations as lp', 'lp.id', 'bookings.loading_port')
        ->leftJoin('locations as offload_l', 'offload_l.id', 'bookings.off_load')
        ->where('job_type', $job->job_type_id)
        ->where('status', 'POST')
        ->get();

        foreach($bookings as $b):
            $containers = BookingContainers::where('bl_no', $b->bl_no)->get();
            $pendingContainers = BookingContainers::where('bl_no', $b->bl_no)->where('activity_status', 'PENDING')->get();
            $b['total_containers'] = count($containers);
            $b['pending_containers'] = count($pendingContainers);
        endforeach;

        return view($this->root . 'add', compact('job', 'bookings'));
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

    public function getContainers($jobId, $bookingNumber) {
        try {
            $containers = BookingContainers
            ::where('booking', $bookingNumber)
            ->where('activity_status', "PENDING")
            ->get();

            return response()->json([
                'success' => 1,
                'error'   => 0,
                'message' => 'Details of the containers for booking '.$bookingNumber,
                'data'    => ['containers' => $containers]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'error'   => 1,
                'message' => $e->getMessage(),
                'data'    => []
            ]);
        } 
    }

    public function updateContainers($jobId, $bookingNumber) {

        $request = request();

        for($i=0; $i<count($request->container_ids); $i++) {
            BookingContainers
            ::where("id", $request->container_ids[$i])
            ->update(
                [
                    "vehicle_no"=>$request->vehicle_number[$i],
                    "cross_stuffing_container_no"=>$request->cross_stuffing_container_no[$i],
                    "activity_status"=>"CLOSED"
                ]
            );
        }

        $alert = array(
            'message' => "Updated ".count($request->container_ids)." containers.",
            'alert-type' => 'success'
        );
        return back()->with($alert); 
    }
}
