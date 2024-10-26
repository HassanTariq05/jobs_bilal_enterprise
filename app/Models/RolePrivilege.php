<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'privilege_id',
    ];


    static function get_privileges_ids_by_role($id=0)
    {
        $output = [];
        $privileges = RolePrivilege::where('role_id', $id)->get();
        if($privileges->count()){
            foreach($privileges as $privilege){
                $output[] = $privilege->privilege_id;
            }
        }
        return $output;
    }







}
