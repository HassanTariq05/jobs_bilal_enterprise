<?php

namespace App\Http\Controllers;

use App\Models\UserPrivilege;
use App\Models\PrivilegeCategory;
use App\Http\Requests\StoreUserPrivilegeRequest;
use App\Http\Requests\UpdateUserPrivilegeRequest;

use Illuminate\Support\Facades\DB;

class UserPrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "users-privileges/";
    public function index()
    {
        //
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
    public function store(StoreUserPrivilegeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPrivilege $userPrivilege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserPrivilege $userPrivilege, $id=0)
    {
        $privileges = PrivilegeCategory::all();
        $user_privileges = UserPrivilege::where('user_id', $id)->get();
        return view($this->root.'list', compact('privileges', 'user_privileges',));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPrivilegeRequest $request, UserPrivilege $userPrivilege)
    {
        echo "<pre>";
        print_r($request->all());
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(UserPrivilege $userPrivilege)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPrivilege $userPrivilege)
    {
        //
    }
}
