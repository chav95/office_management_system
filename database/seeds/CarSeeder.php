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
            'model' => 'Pribadi',
            'police_number' => '-',
            'status' => 1,
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'model' => 'Bluebird',
            'police_number' => '-',
            'status' => 1,
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'model' => 'Daihatsu Xenia',
            'police_number' => 'B 5213 BMD',
            'status' => 1,
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'model' => 'Toyota Avanza',
            'police_number' => 'B 1977 TYZ',
            'status' => 1,
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('cars')->insert([
            'model' => 'Toyota Avanza',
            'police_number' => 'B 1351 RTA',
            'status' => 1,
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
