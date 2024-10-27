<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\BankAccount;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jSonData = File::get(path: 'database/json_data/bank_accounts.json');
        $data = collect(json_decode($jSonData));
        $data->each(function ($row) {
            BankAccount::create([
                'bank' => $row->bank,
                'address' => $row->address,
                'title' => $row->title,
                'iban' => $row->iban,
                'company_id' => $row->company_id
            ]);
        });
    }
}

