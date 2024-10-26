<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SalesTaxTerritory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SalesTaxTerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/sales_tax_territories.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            SalesTaxTerritory::create([
                'short_name'=>$row->short_name,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}
