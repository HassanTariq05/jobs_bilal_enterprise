<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "projects/";
    public function index()
    {
        access_guard(173);
        $rows = Project::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(174);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        access_guard(174);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        Project::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        access_guard(173);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, $id)
    {
        access_guard(175);
        $row = Project::find($id);
        if(!$row){
            return redirect()->route('projects');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project, $id)
    {
        access_guard(175);
        $data = [
            'short_name' => $request->short_name,
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        Project::where('id', $id)->update($data);
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
        access_guard(176);
        DB::beginTransaction();
         try {
            Project::find($id)->delete();
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
        access_guard(177);
        DB::beginTransaction();
         try {
            Project::withTrashed()->find($id)->restore();
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
        access_guard(178);
        DB::beginTransaction();
         try {
            Project::withTrashed()->find($id)->forceDelete();
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
