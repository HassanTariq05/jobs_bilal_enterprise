<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\ContainerSize;
use DateTime;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class ContainerSizeController extends Controller
{
    //





    /**
     * Display a listing of the resource.
     */
    private $root = "container-sizes/";
    public function index()
    {
        
        access_guard(155);
        $rows = DB::select("SELECT * FROM container_sizes");
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(156);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        access_guard(156);
        $date = date('Y-m-d H:i:s');
        DB::beginTransaction();
        
        try {
            //ContainerSize::create($data);
            DB::insert("INSERT INTO `jobs`.`container_sizes` (`container_size`, `creatd_by`, `updated_by`, `created_at`, `updated_at`) VALUES ('{$request["container_size"]}', '15', '', '{$date}', '{$date}')
");
            $alert = array(
                'message' => 'Saved successfully.',
                'alert-type' => 'success'
        );
        }
        catch (\Exception $e) {
            DB::rollBack();
            $alert = array(
                'message' => 'Operation not successfull'. $e->getMessage(),
                'alert-type' => 'error'
        );
            return back()->with($alert);
            //dd($e->getMessage());
        }
        DB::commit();       
        return back()->with($alert);
    
        }

    /**
     * Display the specified resource.
     */
   /* public function show(Location $location)
    {
        access_guard(155);
    }
        */

    /**
     * Show the form for editing the specified resource.
     */
    /*
     public function edit(Location $location, $id)
    {
        access_guard(157);
        $row = Location::find($id);
        if (!$row) {
            return redirect()->route('locations');
        }
        return view($this->root . 'edit', compact('row'));
    }
        */

    /**
     * Update the specified resource in storage.
     */
    /*
     public function update(UpdateLocationRequest $request, Location $location, $id)
    {
        access_guard(157);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'address' => $request->address,
        ];
        Location::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }
        */

    /**
     * Trash the specified resource from storage.
     */
    /*
     public function trash($id = 0)
    {
        access_guard(158);
        DB::beginTransaction();
         try {
            Location::find($id)->delete();
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
        access_guard(159);
        DB::beginTransaction();
         try {
            Location::withTrashed()->find($id)->restore();
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
        access_guard(160);
        DB::beginTransaction();
         try {
            Location::withTrashed()->find($id)->forceDelete();
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
         */
}
