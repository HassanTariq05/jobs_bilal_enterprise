<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Party;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/parties.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            Party::create([
                'short_name'=>$row->short_name,
                'party_type_id'=>$row->party_type_id,
                'title'=>$row->title,
                'slug'=>Str::slug($row->title),
                'email'=>$row->email,
                'contact'=>$row->contact,                
                'address'=>$row->address,                
                'bank_name'=>$row->bank_name,                
                'iban'=>$row->iban,                
                'contact_person'=>$row->contact_person,                
            ]);
        });  
    }
}
