<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PartyType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/party_types.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            PartyType::create([
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}
