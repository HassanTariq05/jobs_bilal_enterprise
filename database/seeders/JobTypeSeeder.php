<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\JobType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/job_types.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            JobType::create([
                'short_name'=>$row->short_name,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}
