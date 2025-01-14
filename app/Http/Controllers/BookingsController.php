<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Exception;
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

use function Laravel\Prompts\select;

class BookingsController extends Controller
{

    private $root = "bookings/";
    protected $booking;
    protected $bl_prefix = "BA|BL no.";

    public function index()
    {
        access_guard(252);

        // Modify the SQL to include the custom_bl column
        $rows = DB::select("
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
            WHERE 
                bookings.status LIKE 'PENDING'
            ORDER BY 
                bookings.id DESC
        ");

        return view($this->root . 'list', compact('rows'));
    }

    public function summary()
    {
        access_guard(252);

        $rows = DB::select("
            SELECT bookings.* 
            FROM bookings 
            ORDER BY bookings.id DESC
        ");

        foreach ($rows as $row) {
            // Rates Applied Count
            $rateAppliedQuery = "
                SELECT COUNT(*) AS rates_applied_count 
                FROM job_invoice_container_breakup_items AS jicbi
                WHERE jicbi.bl_no LIKE :bl_no
            ";
            $ratesApplied = DB::select($rateAppliedQuery, ['bl_no' => $row->bl_no]);
            $row->rates_applied_count = $ratesApplied[0]->rates_applied_count ?? 0;

            // Containers Count
            $containerQuery = "
                SELECT COUNT(*) AS containers_count 
                FROM booking_containers AS bc
                WHERE bc.booking = :booking
            ";
            $containersCount = DB::select($containerQuery, ['booking' => $row->booking]);
            $row->containers_count = $containersCount[0]->containers_count ?? 0;

            // Invoices Count
            $invoiceQuery = "
                SELECT COUNT(*) AS invoices_count 
                FROM jobs.job_invoices AS ji
                INNER JOIN jobs.job_invoice_container_breakups AS jicb ON jicb.job_invoice_id = ji.id
                INNER JOIN jobs.job_invoice_container_breakup_items AS jicbi ON jicbi.job_invoice_container_breakup_id = jicb.id
                WHERE jicbi.bl_no LIKE :bl_no
            ";
            $invoicesCount = DB::select($invoiceQuery, ['bl_no' => $row->bl_no]);
            $row->invoices_count = $invoicesCount[0]->invoices_count ?? 0;

            // Payments Count
            $paymentQuery = "
                SELECT COUNT(*) AS payments_count 
                FROM jobs.job_bills AS jb
                INNER JOIN jobs.job_bill_container_breakups AS jbcb ON jbcb.job_bill_id = jb.id
                INNER JOIN jobs.job_bill_container_breakup_items AS jbcbi ON jbcbi.job_bill_container_breakup_id = jbcb.id
                WHERE jbcbi.bl_no LIKE :bl_no
            ";
            $paymentsCount = DB::select($paymentQuery, ['bl_no' => $row->bl_no]);
            $row->payments_count = $paymentsCount[0]->payments_count ?? 0;
        }


        return view($this->root . 'booking-summary', compact('rows'));
    }


    public function create() {
        access_guard(253);
        $location = Location::all();
        $parties= Party::all();
//       $container_sizes = ContainerSize::all();
        $container_sizes = DB::select("SELECT * from container_sizes");       


        return view($this->root . 'add', compact('location', 'parties', 'container_sizes'));


    }

    public function update($id, UpdateBookingRequest $request)
    {
        access_guard(69);
        DB::beginTransaction();

        try {

            $data = [
                'booking' => $request->booking,
                'bl_no' => $request->bl_no,
                'loading_port' => $request->loading_port,
                'off_load' => $request->off_load,
                'customer' => $request->customer,
                'location' => $request->location,
                'date' => $request->date,
                'remarks' => $request->remarks,
            ];

            Booking::where('id', $id)->update($data);

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
                    $files[$fi]['path'] = $file->store('booking_' . $id, 'public');
                    $fi++;
                }
                if (COUNT($files)) {
                    foreach ($files as $file) {
                        BookingFiles::create([
                            'booking_id' => $id,
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

    public function edit($id) {

        access_guard(255);
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
        access_guard(253);

        $bl_no = $this->getNextBLNo();

        $booking = rand(1000000, 99999);
        
        DB::beginTransaction();
        $data = [
            'booking' => $booking,
            'bl_no' => $bl_no,
            'custom_bl' => $request->bl_no,
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

                        // dd($rows);
                        try {
                            if(COUNT($rows)){
                                $containers_report = [ ];
                                for($x=1;$x<COUNT($rows);$x++) {
                                    if(!preg_match($regex, $rows[$x][0])) {
                                        $invalid_containers += 1;
                                        $containers_report[$x] =
                                        [
                                            "error" => 1,
                                            "message" => "Container no must be four alphabets followed by 7 numbers with no space between",
                                            "container_no" => $rows[$x][2],
                                            "cell_address" => $x."C"
                                        ];

                                        throw new Exception("Container# '". $rows[$x][0] ."' must be 4 alphabets followed by 9 numbers with no space between");
                                    }
                                    else {
                                    
                                        $sheet_data = [
                                            'booking' =>  $booking,
                                            'bl_no' => $bl_no,
                                            'container_no' => $rows[$x][0],
                                            'size' => $rows[$x][1],
                                            'status' => $rows[$x][2],
                                            'date' => $rows[$x][3],
                                            'loading_port' => $rows[$x][4],
                                            'off_loading_port' => $rows[$x][5],
                                            'weight' => $rows[$x][6],
                                            'cross_stuffing_status' => $rows[$x][7],
                                            'detention_start_date' => $rows[$x][8],
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


                        } catch (\Exception $e) {
                            DB::rollBack();
                            $alert = array(
                                'message' => $e->getMessage(),
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

    private function getNextBLNo() {
        $currMonth = date("m");

        $lastBooking = Booking::all()->last();
        $lastBookingCount = 1;

        if($lastBooking) {
            $arr = explode("/", $lastBooking->bl_no);
            if(count($arr) > 1 && $arr[1] == $currMonth) {
                $lastBookingCount = $arr[2] + 1;
            }
        }

       return "BL/" . $currMonth . "/" . str_pad($lastBookingCount, 4, '0', STR_PAD_LEFT);
    }

    public function store_manually(Request $request) {

        $booking = rand(1000000, 99999);

        $bl_no = $this->getNextBLNo();

        access_guard(253);
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
                'loading_port' => $container_loading[$i],
                'off_loading_port' => $container_offload[$i],
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

    public function update_containers_manually(Request $request) {

        $booking = $request['booking'];

        $bl_no = $request['bl_no'];

        access_guard(253);
        
        $container_no = $request['container_no-array'];
        $container_size = $request['container_size-array'];
       
        $container_status = $request['container_status-array'];
        $date_array = $request['container_date-array'];
        $container_offload = $request['off_load-array'];
        $container_loading = $request['loading_port-array'];
        $weight = $request['weight-array'];
        $cross_stuffing_status = $request['cross_stuffing_status-array'];
        $detention_date = $request['detention_date-array'];
        
       DB::beginTransaction();

       $oldContainers = BookingContainers::where(["bl_no"=>$bl_no])->delete();

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
                'loading_port' => $container_loading[$i],
                'off_loading_port' => $container_offload[$i],
                'party' => '',
                'remarks' => '',
                'container_weight' => $weight[$i],
                'cross_stuffing_status' => $cross_stuffing_status[$i],
                'detention_start_date' => $detention_date[$i],
            ];
            
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
        access_guard(254);
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

    public function trashContainer($id = 0)
    {
        access_guard(254);
        DB::beginTransaction();
         try {
            BookingContainers::find($id)->delete();
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