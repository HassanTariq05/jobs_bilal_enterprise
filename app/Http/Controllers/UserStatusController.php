<?php

namespace App\Http\Controllers;

use App\Models\UserStatus;
use App\Http\Requests\StoreUserStatusRequest;
use App\Http\Requests\UpdateUserStatusRequest;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "users-status/";
    public function index()
    {
        access_guard(215);
        $rows = UserStatus::withTrashed()->get();
        return view($this->root.'list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(216);
        return view($this->root.'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserStatusRequest $request)
    {
        access_guard(216);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        UserStatus::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserStatus $userStatus)
    {
        access_guard(215);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserStatus $userStatus, $id)
    {
        access_guard(217);
        $row = UserStatus::find($id);
        if(!$row){
            return redirect()->route('users-status');
        }
        return view($this->root.'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserStatusRequest $request, UserStatus $userStatus, $id)
    {
        access_guard(217);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title)
        ];
        UserStatus::where('id', $id)->update($data);
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
        access_guard(218);
        DB::beginTransaction();
         try {
            UserStatus::find($id)->delete();
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
        access_guard(219);
        DB::beginTransaction();
         try {
            UserStatus::withTrashed()->find($id)->restore();
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
        access_guard(220);
        DB::beginTransaction();
         try {
            UserStatus::withTrashed()->find($id)->forceDelete();
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
