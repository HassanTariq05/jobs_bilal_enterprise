<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\AccountTitle;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AccountTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/account_titles.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            AccountTitle::create([
                'account_nature_id'=>$row->account_nature_id,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
            ]);
        });  
    }
}
