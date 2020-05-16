<?php

use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cars')->insert([
            'company_id' => 1,
            'type' => 'HRV Matic',
            'engine_cc' => 1500,
            'police_number' => 'B 1444 PIU',
            'driver_id' => 1,
            'lease_start' => '2017-10-01',
            'lease_due' => '2020-10-01',
            'lease_price' => null,
            'vendor_id' => 1,
            'division_id' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_id' => 1,
            'type' => 'Innova Manual',
            'engine_cc' => 1500,
            'police_number' => 'B 1491 PIU',
            'driver_id' => 2,
            'lease_start' => '2017-10-01',
            'lease_due' => '2020-10-01',
            'lease_price' => null,
            'vendor_id' => 1,
            'division_id' => 2,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_id' => 2,
            'type' => 'Grand New Avanza Manual',
            'engine_cc' => 1300,
            'police_number' => 'B 1097 PIW',
            'driver_id' => 3,
            'lease_start' => '2017-11-16',
            'lease_due' => '2020-11-15',
            'lease_price' => null,
            'vendor_id' => 2,
            'division_id' => 3,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_id' => 1,
            'type' => 'Nissan Xtrail Matic-',
            'engine_cc' => 2000,
            'police_number' => 'B 2399 SZR',
            'driver_id' => 4,
            'lease_start' => '2018-02-15',
            'lease_due' => '2021-02-14',
            'lease_price' => null,
            'vendor_id' => 3,
            'division_id' => 4,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_id' => 3,
            'type' => 'Innova Matic',
            'engine_cc' => 2000,
            'police_number' => 'B 1756 SM',
            'driver_id' => 5,
            'lease_start' => '2018-07-01',
            'lease_due' => null,
            'lease_price' => null,
            'vendor_id' => 4,
            'division_id' => 5,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_id' => 1,
            'type' => 'Innova Manual',
            'engine_cc' => 2000,
            'police_number' => 'B 2497 SFV',
            'driver_id' => 6,
            'lease_start' => '2019-02-06',
            'lease_due' => '2021-08-10',
            'lease_price' => null,
            'vendor_id' => 5,
            'division_id' => 6,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_id' => 1,
            'type' => 'Innova Matic',
            'engine_cc' => 2000,
            'police_number' => 'B 2155 TYK',
            'driver_id' => 7,
            'lease_start' => '2019-01-04',
            'lease_due' => '2022-01-04',
            'lease_price' => null,
            'vendor_id' => 6,
            'division_id' => 7,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
