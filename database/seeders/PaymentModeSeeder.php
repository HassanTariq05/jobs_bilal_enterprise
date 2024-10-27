<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use App\Models\PaymentMode;
use Illuminate\Support\Str;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/payment_mode.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            PaymentMode::create([
                'short_name' => $row->short_name,
                'title' => $row->title,
                'slug' => Str::slug($row->title)
            ]);
        });
    }
}
