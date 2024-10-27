<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PrivilegeCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrivilegeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/privilege_categories.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            PrivilegeCategory::create([
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
                'order_by'=>$row->order_by,
            ]);
        });  
    }
}
