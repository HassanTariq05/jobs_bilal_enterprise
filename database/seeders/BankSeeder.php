<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Bank;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/banks.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Bank::create([
                'title' => $row->title,
                'slug'=>Str::slug($row->title),
                'short_name' => $row->short_name,
                'address' => $row->address,
                'email' => $row->email,
                'contact' => $row->contact,
                'contact_person' => $row->contact_person
            ]);
        });
    }
}
