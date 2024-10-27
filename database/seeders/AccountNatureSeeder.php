<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AccountNature;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AccountNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/account_natures.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            AccountNature::create([
                'code'=>$row->code,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}
