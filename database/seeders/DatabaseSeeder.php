<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        $this->call([
            AccountNatureSeeder::class,
            AccountTitleSeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            DesignationSeeder::class,
            FleetManufacturerSeeder::class,
            FleetSeeder::class,
            FleetTypeSeeder::class,
            FuelIssueSeeder::class,
            FuelPurchaseSeeder::class,
            FuelSeeder::class,
            FuelTypeSeeder::class,
            JobBillDetailSeeder::class,
            JobBillSeeder::class,
            JobContainerSeeder::class,
            JobInvoiceDetailSeeder::class,
            JobInvoiceSeeder::class,
            JobSeeder::class,
            JobStatusSeeder::class,
            JobTypeSeeder::class,
            LocationSeeder::class,
            OperationSeeder::class,
            PartySeeder::class,
            PartyTypeSeeder::class,
            SalesTaxTerritorySeeder::class,
            TankSeeder::class,
            UserSeeder::class,
            UserStatusSeeder::class,
            PaymentModeSeeder::class,
            BankSeeder::class,
            BankAccountSeeder::class,
            UserRoleSeeder::class,
            PrivilegeCategorySeeder::class,
            PrivilegeGroupSeeder::class,
            PrivilegeSeeder::class,
            VoucherTypeSeeder::class,
        ]);

    }
}
