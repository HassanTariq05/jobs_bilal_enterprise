<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Http\Requests\StoreUserRoleRequest;
use App\Http\Requests\UpdateUserRoleRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "user-roles/";
    public function index()
    {
        access_guard(139);
        $rows = UserRole::withTrashed()->orderBy('title')->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(140);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRoleRequest $request)
    {
        access_guard(140);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        UserRole::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRole $userRole)
    {
        access_guard(139);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRole $userRole, $id=0)
    {
        access_guard(141);
        $row = UserRole::find($id);
        if(!$row){
            return redirect()->route('designations');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRoleRequest $request, UserRole $userRole, $id=0)
    {
        access_guard(141);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        UserRole::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(UserRole $userRole, $id=0)
    {
        access_guard(142);
        DB::beginTransaction();
         try {
            UserRole::find($id)->delete();
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
    public function restore(UserRole $userRole, $id=0)
    {
        access_guard(143);
        DB::beginTransaction();
         try {
            UserRole::withTrashed()->find($id)->restore();
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
    public function destroy(UserRole $userRole, $id=0)
    {
        access_guard(144);
        DB::beginTransaction();
         try {
            UserRole::withTrashed()->find($id)->forceDelete();
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
