<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingFiles;
use App\Models\Party;
//use App\Models\Booking;
use App\Models\Location;
//use APP\Models\Parties;
use App\Models\ContainerSize;
use App\Models\BookingContainers;
use DateTime;

//use APP\Models\BookingContainers;
//use Illuminate\Support\Facades\DB;

use App\Models\JobPerformance;
use App\Models\JobPerformanceSheetData;



use Illuminate\Support\Facades\Auth;

use Excel;
use App\Imports\JobPerformanceImport;



use Illuminate\Support\Facades\DB;


class BookingsController extends Controller
{

    private $root = "bookings/";
    protected $booking;
    protected $bl_prefix = "BA|BL no.";
    public function index()
    {
      //  echo "<h1>Hello</h1>";
        access_guard(25);
        $rows =  DB::select("
SELECT 
    bookings.*, 
    loc1.short_name AS location_name,
    loc2.short_name AS off_load_name,
    loc3.short_name AS loading_port_name,
    parties.title AS customer_name,
    jt.title AS job_type_title
FROM 
    bookings
JOIN 
    locations AS loc1 ON bookings.location = loc1.id 
JOIN 
    locations AS loc2 ON bookings.off_load = loc2.id 
JOIN 
    locations AS loc3 ON bookings.loading_port = loc3.id 
JOIN 
    parties ON bookings.customer = parties.id
LEFT JOIN 
    job_types AS jt ON bookings.job_type = jt.id
order by bookings.id desc");

        return view($this->root . 'list', compact('rows'));
   
  //   dd($rows);
//        echo json_encode([$rows]);
    }

    public function create() {
        access_guard(26);
        $location = Location::all();
        $parties= Party::all();
//       $container_sizes = ContainerSize::all();
        $container_sizes = DB::select("SELECT * from container_sizes");       


        return view($this->root . 'add', compact('location', 'parties', 'container_sizes'));


    }

    public function update() {
    

    }

    public function edit($id) {

        access_guard(26);
        $location = Location::all();
        $parties= Party::all();
        $containers = Db::select("SELECT bc.* from booking_containers  as bc inner join bookings as bk on bc.booking = bk.booking where bk.id = {$id};");
        $container_sizes = DB::select("SELECT * from container_sizes");       

        $row =  DB::select("
                    SELECT 
                bookings.*, 
                loc1.short_name AS location_name,
                loc2.short_name AS off_load_name,
                loc3.short_name AS loading_port_name,
                parties.title AS customer_name 

                FROM 
                    bookings 

                JOIN 
                    locations AS loc1 ON bookings.location = loc1.id 

                JOIN 
                    locations AS loc2 ON bookings.off_load = loc2.id 

                JOIN 
                    locations AS loc3 ON bookings.loading_port = loc3.id 

                JOIN 
                    parties ON bookings.customer = parties.id where bookings.id = {$id}");

    $file = DB::select("SELECT book_f.* FROM booking_files as book_f JOIN bookings as book on book_f.booking_id = book.bl_no where book.id = {$id};");


        return view($this->root . 'edit', compact('row', 'file', 'location', 'parties', 'container_sizes', 'containers'));
        //echo json_encode([$file]);
     //   echo $location;
     //   echo $parties;
     //echo json_encode([$container_sizes]);
    }

    public function generate() {
        $booking = rand(1000000, 99999);     
        //  date("Y-m-d h:i:sa")
        $month_year = date("d/m/y h:i:sa");
        $bl_no = $this->bl_prefix. $booking .$month_year;
        
        dd($bl_no);
    }
    

    public function store(StoreBookingRequest $request) 
    {
        access_guard(26);
        $booking = rand(1000000, 99999);     
        $month = date("m");
        $year = date("Y");

        // Fetch or create the monthly count record
        $monthlyCount = DB::table('monthly_counts')
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($monthlyCount) {
            // Increment the count for the current month
            $count = $monthlyCount->count + 1;
            DB::table('monthly_counts')
                ->where('id', $monthlyCount->id)
                ->update(['count' => $count]);
        } else {
            // Create a new record for the month
            $count = 1;
            DB::table('monthly_counts')->insert([
                'year' => $year,
                'month' => $month,
                'count' => $count,
            ]);
        }

        // Format the bl_no
        $bl_no = $request->bl_no . "/" . $month . "/" . str_pad($count, 2, '0', STR_PAD_LEFT);
        
        DB::beginTransaction();
        $data = [
            'booking' => $booking,
            'bl_no' => $bl_no,
            'loading_port' => $request->loading_port,
            'off_load' => $request->off_load,
            'customer' => $request->customer,
            'location' => $request->location,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'job_type' => $request->job_type_id,
        ];

        try {
            Booking::create($data);
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
        } catch (\Exception $e) {
            $alert = array(
                'message' => 'Booking creation failed: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            DB::rollBack();
            return back()->with($alert);
        }
        
        
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
                    $files[$fi]['path'] = $file->store('booking_' . $request->bl_no, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    $invalid_containers = 0;
                    $regex = "/^[A-Za-z]{4}[0-9]{7}$/"; 
                    foreach ($files as $file) {
                         BookingFiles::create([
                             'booking_id' => $bl_no,
                             'title' => $file['title'],
                             'ext' => $file['ext'],
                             'file_path' => $file['path'],
                         ]);
                        $rows = Excel::toArray(new JobPerformanceImport, storage_path("app/public/" . $file['path']));
                        $rows = $rows[0];

                        //dd($rows);
                        try {
                            if(COUNT($rows)){
                                $containers_report = [ ];
                                for($x=1;$x<COUNT($rows);$x++){
                
                                    if(!preg_match($regex, $rows[$x][2])) {
                                        $invalid_containers += 1;
                                        $containers_report[$x] =
                                        [
                                        "error" => 1,
                                        "message" => "container no must be four alphabets followed by 9 numbers with no space between",
                                        "container_no" => $rows[$x][2],
                                        "cell_address" => $x."C"
                                        ];
                                    }
                                    else {
                                    
                                     $sheet_data = [
                                         'booking' =>  $booking,
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
                        
                                     BookingContainers::create($sheet_data);
    
                                    }
                                }

           //                     dd($containers_report);
                
                                DB::commit();
                
                                 $alert = array(
                                    'message' => "Record has been saved.",
                                    'alert-type' => 'success'
                                );
                                return back()->with($alert)->with('containers_report', $containers_report);
                            }


                        }catch (\Exception $e) {
                            DB::rollBack();
                
                                $alert = array(
                                    'message' => "error". $e->getMessage(),
                                    'alert-type' => 'error'
                                );
                                return back()->with($alert);

                        }


                    }
                    
                }
                //dd($files);
            }  else {
                DB::commit();
                return back()->with($alert);
        
            }
        
        return back()->with($alert);

    }

    public function store_manually(Request $request) {
        $booking = rand(1000000, 99999);
        $month = date("m");
        $year = date("Y");

        $monthlyCount = DB::table('monthly_counts')
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($monthlyCount) {
            $count = $monthlyCount->count + 1;
            DB::table('monthly_counts')
                ->where('id', $monthlyCount->id)
                ->update(['count' => $count]);
        } else {
            $count = 1;
            DB::table('monthly_counts')->insert([
                'year' => $year,
                'month' => $month,
                'count' => $count,
            ]);
        }

        $bl_no = $request->bl_no . "/" . $month . "/" . str_pad($count, 2, '0', STR_PAD_LEFT);

        access_guard(28);
        DB::beginTransaction();
        // $booking_no = $request->booking;
        $container_no = $request['container_no-array'];
        $container_size = $request['container_size-array'];
       
        $container_status = $request['container_status-array'];
        $date_array = $request['container_date-array'];
        $container_offload = $request['off_load-array'];
        $container_loading = $request['loading_port-array'];
        $weight = $request['weight-array'];
        $cross_stuffing_status = $request['cross_stuffing_status-array'];
        $detention_date = $request['detention_date-array'];
        // dd($date_array[0]);
         
        $data = [
            'booking' => $booking,
            'bl_no' => $bl_no,
            'loading_port' => $request->loading_port,
            'off_load' => $request->off_load,
            'customer' => $request->customer,
            'location' => $request->location,
            'date' => $request->date,
            'remarks' => $request->remarks,
            'job_type' => $request->job_type_id,

        ];
        
        //echo json_encode([$data]);
        
         try {
            Booking::create($data);
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
            );
            DB::commit();
            //return back()->with($alert);
        }
        catch(\Exception $e) {

            $alert = array(
                'message' => 'Booking creation Failed'. $e->getMessage(),
                'alert-type' => 'error'
            );
            DB::rollBack();
            return back()->with($alert);

        }
        
       DB::beginTransaction();
       for ($i = 0; $i < count($container_no); $i++) {
            $manual_data = [
                'booking' => $booking,
                'bl_no' => $bl_no,
                'container_no' => $container_no[$i],
                'size' => $container_size[$i],
                'status' => $container_status[$i],
                'vehicle_no' => '',
                'trucking_mode' => '',
                'date' => $date_array[$i],
                'loading_port' => $container_offload[$i],
                'off_loading_port' => $container_loading[$i],
                'party' => '',
                'remarks' => $request->remarks,
                'container_weight' => $weight[$i],
                'cross_stuffing_status' => $cross_stuffing_status[$i],
                'detention_start_date' => $detention_date[$i],


            ];
            //dd($manual_data);
        
            // now booking_containers table
            try {
                BookingContainers::create($manual_data);
                $alert = array(
                    'message' => 'Saved successfully.',
                    'alert-type' => 'success'
                );
                
            }
            catch(\Exception $e) {

                $alert = array(
                    'message' => 'Containers manual entry Failed'. $e->getMessage(),
                    'alert-type' => 'error'
                );
                DB::rollBack();
                return back()->with($alert);

            } 
        }
        DB::commit();
        return back()->with($alert);
    }

    public function booking_containers(Request $request) {

        // dd($request->all);
        $bl_no = $request->data;
        try {
            $result = DB::table('booking_containers')
            ->where('booking', $bl_no)
            ->get();        
            echo json_encode($result);

        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function trash($id = 0)
    {
        access_guard(28);
        DB::beginTransaction();
         try {
            Booking::find($id)->delete();
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