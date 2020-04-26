<?php

use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'name' => 'Ruang Rapat 1',
            'capacity' => 15,
            'status' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('rooms')->insert([
            'name' => 'Ruang Rapat 2',
            'capacity' => 12,
            'status' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('rooms')->insert([
            'name' => 'Ruang Rapat 3',
            'capacity' => 10,
            'status' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('rooms')->insert([
            'name' => 'Ruang Rapat 4',
            'capacity' => 12,
            'status' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('rooms')->insert([
            'name' => 'Ruang Rapat 5',
            'capacity' => 30,
            'status' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('rooms')->insert([
            'name' => 'Ruang Lobi',
            'capacity' => 4,
            'status' => 1,
            'created_by' => 2,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
