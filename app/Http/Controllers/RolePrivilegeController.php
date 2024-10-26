<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Models\RolePrivilege;
use App\Models\PrivilegeCategory;
use App\Http\Requests\StoreRolePrivilegeRequest;
use App\Http\Requests\UpdateRolePrivilegeRequest;

use Illuminate\Support\Facades\DB;

class RolePrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $root = "role-privileges/";
    public function index()
    {
        access_guard(145);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        access_guard(146);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRolePrivilegeRequest $request)
    {
        access_guard(146);
    }

    /**
     * Display the specified resource.
     */
    public function show(RolePrivilege $rolePrivilege)
    {
        access_guard(145);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RolePrivilege $rolePrivilege, $id = 0)
    {
        access_guard(147);
        $role = UserRole::find($id);
        $privileges = PrivilegeCategory::all();
        //$role_privileges = RolePrivilege::where('role_id', $id)->get();
        $role_privileges_ids = RolePrivilege::get_privileges_ids_by_role($id);
        return view($this->root . 'list', compact('role', 'privileges', 'role_privileges_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRolePrivilegeRequest $request, RolePrivilege $rolePrivilege, $id)
    {
        access_guard(147);
        RolePrivilege::where('role_id', $id)->delete();
        $privileges = $request->privilege;
        if (COUNT($privileges)) {
            foreach ($privileges as $p) {
                $data = [
                    'role_id' => $id,
                    'privilege_id' => $p
                ];
                RolePrivilege::create($data);
            }
        }
        $alert = array(
            'message' => 'Saved successfully.',
            'alert-type' => 'success'
        );
        return back()->with($alert);
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash()
    {
        access_guard(148);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        access_guard(148);
    }
}
