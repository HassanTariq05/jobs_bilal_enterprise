<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\VoucherType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class VoucherTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */     
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/voucher_types.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            VoucherType::create([
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}