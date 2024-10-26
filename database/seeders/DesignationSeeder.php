<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/designations.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Designation::create([
                'title' => $row->title,
                'slug' => $row->slug
            ]);
        });
    }
}
