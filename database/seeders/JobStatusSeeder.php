<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\JobStatus;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class JobStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/job_statuses.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            JobStatus::create([
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}
