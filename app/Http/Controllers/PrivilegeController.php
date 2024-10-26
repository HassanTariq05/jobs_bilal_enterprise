<?php

namespace App\Http\Controllers;

use App\Models\Privilege;
use App\Http\Requests\StorePrivilegeRequest;
use App\Http\Requests\UpdatePrivilegeRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "privileges-control-room/privileges/";
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
    public function store(StorePrivilegeRequest $request)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        $data = [
            'privilege_group_id' => $request->privilege_group_id,
            'title' => $request->title,
            'short_title' => $request->short_title,
            'slug' => Str::slug($request->title),
            'order_by' => $request->order_by,
        ];
        Privilege::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(Privilege $privilege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Privilege $privilege, $id)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   

        $row = Privilege::find($id);
        if (!$row) {
            return redirect()->route('store-privilege-category');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrivilegeRequest $request, Privilege $privilege, $id)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        $data = [
            'privilege_group_id' => $request->privilege_group_id,
            'title' => $request->title,
            'short_title' => $request->short_title,
            'slug' => Str::slug($request->title),
            'order_by' => $request->order_by,
        ];
        Privilege::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(Privilege $privilege)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Privilege $privilege)
    {
        //
    }
}
