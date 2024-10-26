<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Http\Requests\StoreOperationRequest;
use App\Http\Requests\UpdateOperationRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "operations/";
    public function index()
    {
        access_guard(161);
        $rows = Operation::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(162);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperationRequest $request)
    {
        access_guard(162);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        Operation::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Operation $operation)
    {
        access_guard(161);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operation $operation, $id)
    {
        access_guard(163);
        $row = Operation::find($id);
        if(!$row){
            return redirect()->route('operations');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperationRequest $request, Operation $operation, $id)
    {
        access_guard(163);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        Operation::where('id', $id)->update($data);
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
        access_guard(164);
        DB::beginTransaction();
         try {
            Operation::find($id)->delete();
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
        access_guard(165);
        DB::beginTransaction();
         try {
            Operation::withTrashed()->find($id)->restore();
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
        access_guard(166);
        DB::beginTransaction();
         try {
            Operation::withTrashed()->find($id)->forceDelete();
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
