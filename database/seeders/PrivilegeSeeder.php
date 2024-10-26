<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Privilege;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/privileges.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Privilege::create([
                'privilege_group_id'=>$row->privilege_group_id,
                'title'=>$row->title,
                'short_title'=>$row->short_title,
                'slug'=>Str::slug($row->title),
                'order_by'=>$row->order_by,
            ]);
        });  
    }
}
