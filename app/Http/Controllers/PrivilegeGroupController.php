<?php

namespace App\Http\Controllers;

use App\Models\PrivilegeGroup;
use App\Http\Requests\StorePrivilegeGroupRequest;
use App\Http\Requests\UpdatePrivilegeGroupRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class PrivilegeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "privileges-control-room/groups/";
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        return view($this->root . 'add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePrivilegeGroupRequest $request)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        $data = [
            'privilege_category_id' => $request->privilege_category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'order_by' => $request->order_by,
        ];
        PrivilegeGroup::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(PrivilegeGroup $privilegeGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivilegeGroup $privilegeGroup, $id)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   

        $row = PrivilegeGroup::find($id);
        if (!$row) {
            return redirect()->route('store-privilege-category');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrivilegeGroupRequest $request, PrivilegeGroup $privilegeGroup, $id)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        $data = [
            'privilege_category_id' => $request->privilege_category_id,
            'title' => $request->title,
            'order_by' => $request->order_by,
            'slug' => Str::slug($request->title)
        ];
        PrivilegeGroup::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(PrivilegeGroup $privilegeGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivilegeGroup $privilegeGroup)
    {
        //
    }
}
