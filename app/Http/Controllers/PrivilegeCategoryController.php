<?php

namespace App\Http\Controllers;

use App\Models\PrivilegeCategory;
use App\Http\Requests\StorePrivilegeCategoryRequest;
use App\Http\Requests\UpdatePrivilegeCategoryRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;


class PrivilegeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "privileges-control-room/categories/";
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
    public function store(StorePrivilegeCategoryRequest $request)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        if (Auth::User()->id > 1) {
            abort(403);
        }
        $data = [
            'title' => $request->title,
            'order_by' => $request->order_by,
            'slug' => Str::slug($request->title)
        ];
        PrivilegeCategory::create($data);
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(PrivilegeCategory $privilegeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivilegeCategory $privilegeCategory, $id)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   

        $row = PrivilegeCategory::find($id);
        if (!$row) {
            return redirect()->route('store-privilege-category');
        }
        return view($this->root . 'edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePrivilegeCategoryRequest $request, PrivilegeCategory $privilegeCategory, $id)
    {
        if(Auth::User()->id>1){
            abort(403);
        }   
        $data = [
            'title' => $request->title,
            'order_by' => $request->order_by,
            'slug' => Str::slug($request->title)
        ];
        PrivilegeCategory::where('id', $id)->update($data);
        $alert = array(
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(PrivilegeCategory $privilegeCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivilegeCategory $privilegeCategory)
    {
        //
    }
}
