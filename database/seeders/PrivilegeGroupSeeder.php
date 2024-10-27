<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PrivilegeGroup;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrivilegeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/privilege_groups.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            PrivilegeGroup::create([
                'privilege_category_id'=>$row->privilege_category_id,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
                'order_by'=>$row->order_by,
            ]);
        });  
    }
}
