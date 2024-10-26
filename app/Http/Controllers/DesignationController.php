<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    private $root = "designations/";
    public function index()
    {
        access_guard(133);
        $rows = Designation::withTrashed()->orderBy('title')->get();
        return view($this->root . 'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(134);
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDesignationRequest $request)
    {
        access_guard(134);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        Designation::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        access_guard(133);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation, $id)
    {
        access_guard(135);
        $row = Designation::find($id);
        if (!$row) {
            return redirect()->route('designations');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesignationRequest $request, Designation $designation, $id)
    {
        access_guard(135);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        Designation::where('id', $id)->update($data);
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
        access_guard(136);
        DB::beginTransaction();
        try {
            Designation::find($id)->delete();
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
        access_guard(137);
        DB::beginTransaction();
        try {
            Designation::withTrashed()->find($id)->restore();
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
        access_guard(138);
        $record = Designation::withTrashed()->find($id);
        if (!is_null($record)) {
            $record->forceDelete();
            $alert = array(
                'message' => 'Record deleted successfully',
                'alert-type' => 'success'
            );
        } else {
            $alert = array(
                'message' => 'Unable to delete record.',
                'alert-type' => 'error'
            );
        }
        return back()->with($alert);
    }
}
