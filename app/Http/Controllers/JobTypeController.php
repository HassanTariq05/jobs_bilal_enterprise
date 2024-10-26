<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use App\Http\Requests\StoreJobTypeRequest;
use App\Http\Requests\UpdateJobTypeRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "job-types/";
    public function index()
    {
        access_guard(179);
        $rows = JobType::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(180);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobTypeRequest $request)
    {
        access_guard(180);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        JobType::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobType $jobType)
    {
        access_guard(179);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobType $jobType, $id)
    {
        access_guard(181);
        $row = JobType::find($id);
        if(!$row){
            return redirect()->route('job-types');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobTypeRequest $request, JobType $jobType, $id)
    {
        access_guard(181);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        JobType::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash($id = 0)
    {
        access_guard(182);
        DB::beginTransaction();
         try {
            JobType::find($id)->delete();
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
        access_guard(183);
        DB::beginTransaction();
         try {
            JobType::withTrashed()->find($id)->restore();
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
        access_guard(184);
        DB::beginTransaction();
         try {
            JobType::withTrashed()->find($id)->forceDelete();
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
