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

class WorkOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "work-orders/";
    public function index()
    {
        $fleet = Fleet::get();

        $openBookings = array();
        $closedBookings = array();

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
        ->where('bookings.status', 'PENDING')
        ->orderBy('bookings.id')
        ->get();

        foreach($bookings as $b):
            $containers = BookingContainers::where('bl_no', $b->bl_no)->get();
            $pendingContainers = BookingContainers::where('bl_no', $b->bl_no)->where('activity_status', 'PENDING')->get();
            $b['total_containers'] = count($containers);
            $b['pending_containers'] = count($pendingContainers);

            if($b['total_containers'] > 0) {
                if($b['pending_containers'] == 0) {
                    array_push($closedBookings, $b);
                } else {
                    array_push($openBookings, $b);
                }
            }

        endforeach;

        return view($this->root . 'list', compact('openBookings', 'closedBookings', 'fleet'));

    }

    public function postWorkOrder($id) {
        Booking::
        where("id", $id)
        ->update(["status"=>"POST"]);
        $alert = array(
            'message' => "Work order # ". $id ." posted",
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    public function assignWorkOrders($jobId) {
        $request = request();
        
        JobPerformance::
            where("performance_type", "SYSTEM")
            ->where("job_id", $jobId)
            ->delete();

        $newJobPerformance = JobPerformance::create(
            [
                "performance_type"=>"SYSTEM", 
                "job_id"=>$jobId,
                "user_id"=>Auth::User()->id
            ]
        );

        foreach($request->checked as $bookingId => $value):
            $booking = Booking::where("id", $bookingId)->first();
            $bookingContainers = BookingContainers::where("bl_no", $booking->bl_no)->get();
            foreach($bookingContainers as $bc):
                JobPerformanceSheetData::
                    create(
                        [
                            "job_performance_id"=>$newJobPerformance->id,
                            "bl_no"=>$bc->bl_no,
                            "container_no"=>$bc->container_no,
                            "size"=>$bc->size,
                            "vehicle_no"=>$bc->vehicle_no,
                            "trucking_mode"=>$bc->trucking_mode,
                            "date"=>$bc->date,
                            "loading_port"=>$bc->loading_port,
                            "off_loading_port"=>$bc->off_loading_port,
                            "party"=>$bc->party,
                            "remarks"=>$bc->remarks,
                            "status"=>$bc->status,
                        ]
                    );
            endforeach;

            Booking::
            where("id", $booking->id)
            ->update(["status"=>"ASSIGNED"]);
            
        endforeach;

        $alert = array(
            'message' => "Work orders (".implode(", ", $request->checked).") assigned to job # ".$jobId,
            'alert-type' => 'success'
        );
        return back()->with($alert);

    }
}
