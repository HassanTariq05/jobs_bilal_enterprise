<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/users.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            User::create([
                'designation_id'=>$row->designation_id,
                'status_id'=>$row->status_id,
                'email'=>$row->email,
                'name'=>$row->name,
                'password'=>Hash::make('password'),
                'remarks'=>$row->remarks,
            ]);
        });        
    }
}
