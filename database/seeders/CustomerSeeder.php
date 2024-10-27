<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/customers.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Customer::create([
                'name'=>$row->name,
                'slug'=>Str::slug($row->name),
                'email'=>$row->email,
                'contact'=>$row->contact,
            ]);
        });  
    }
}
