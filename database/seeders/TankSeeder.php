<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use App\Models\Tank;

class TankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/tanks.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Tank::create([
                'user_id' => $row->user_id,
                'fuel_type_id' => $row->fuel_type_id,
                'title' => $row->title,
                'location' => $row->location,
                'capacity' => $row->capacity,
                'remarks' => $row->remarks
            ]);
        });
    }
}
