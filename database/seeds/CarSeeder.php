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
            'company_name' => 'JTD',
            'type' => 'HRV Matic',
            'engine_cc' => 1500,
            'police_number' => 'B 1444 PIU',
            'driver_name' => 'Syaipuloh',
            'lease_start' => '2017-10-01',
            'lease_due' => '2020-10-01',
            'lease_price' => null,
            'vendor_name' => 'Agungrent/ PPO BTN',
            'division_name' => 'Keuangan/FIY',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_name' => 'JTD',
            'type' => 'Innova Manual',
            'engine_cc' => 1500,
            'police_number' => 'B 1491 PIU',
            'driver_name' => 'Adi Winarno',
            'lease_start' => '2017-10-01',
            'lease_due' => '2020-10-01',
            'lease_price' => null,
            'vendor_name' => 'Agungrent/ PPO BTN',
            'division_name' => 'Umum/CE',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_name' => 'PJI',
            'type' => 'Grand New Avanza Manual',
            'engine_cc' => 1300,
            'police_number' => 'B 1097 PIW',
            'driver_name' => 'Hidayat',
            'lease_start' => '2017-11-16',
            'lease_due' => '2020-11-15',
            'lease_price' => null,
            'vendor_name' => 'Agungrent',
            'division_name' => 'Operasional',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_name' => 'JTD',
            'type' => 'Nissan Xtrail Matic-',
            'engine_cc' => 2000,
            'police_number' => 'B 2399 SZR',
            'driver_name' => 'Solehudin',
            'lease_start' => '2018-02-15',
            'lease_due' => '2021-02-14',
            'lease_price' => null,
            'vendor_name' => 'Prima Armada Raya',
            'division_name' => 'Teknik/DS',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_name' => 'JCM',
            'type' => 'Innova Matic',
            'engine_cc' => 2000,
            'police_number' => 'B 1756 SM',
            'driver_name' => 'Tono',
            'lease_start' => '2018-07-01',
            'lease_due' => null,
            'lease_price' => null,
            'vendor_name' => 'Ibu Maya/Jaya CM',
            'division_name' => 'Teknik/HM',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_name' => 'JTD',
            'type' => 'Innova Manual',
            'engine_cc' => 2000,
            'police_number' => 'B 2497 SFV',
            'driver_name' => 'Asep Resmana',
            'lease_start' => '2019-02-06',
            'lease_due' => '2021-08-10',
            'lease_price' => null,
            'vendor_name' => 'Prima Armada Raya',
            'division_name' => 'Proyek /ID',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'company_name' => 'JTD',
            'type' => 'Innova Matic',
            'engine_cc' => 2000,
            'police_number' => 'B 2155 TYK',
            'driver_name' => 'Kurniawan',
            'lease_start' => '2019-01-04',
            'lease_due' => '2022-01-04',
            'lease_price' => null,
            'vendor_name' => 'CSM Corporatama',
            'division_name' => 'PPLHK/HH',
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
