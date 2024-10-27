<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Privilege;
use App\Models\PrivilegeGroup;
use App\Models\PrivilegeCategory;


use Illuminate\Support\Facades\DB;


class PrivilegeControlRoom extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "privileges-control-room/";
    public function index()
    {
        if(Auth::User()->id>1){
            abort(403);
        }        

        $privileges = Privilege::withTrashed()->orderBy('privilege_group_id')->get();
        $privilege_groups = PrivilegeGroup::all();
        $privilege_category = PrivilegeCategory::all();

        return view($this->root . 'list', compact('privileges', 'privilege_groups', 'privilege_category'));
    }

    public function generate_privilege_json()
    {
        if(Auth::User()->id>1){
            abort(403);
        }        

        $rows = Privilege::orderBy('id')->get();
        return view($this->root . 'privilege-json', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
