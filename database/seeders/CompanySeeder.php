<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Company;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/companines.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Company::create([
                'short_name'=>$row->short_name,
                'logo'=>$row->logo,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
                'address'=>$row->address,
                'phone'=>$row->phone,
                'email'=>$row->email,
                'contact_person'=>$row->contact_person,
                'ntn'=>$row->ntn
            ]);
        });  
    }
}
