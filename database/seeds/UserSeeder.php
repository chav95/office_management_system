<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Chavin Pradana',
            'email' => 'chavinpradana@gmail.com',
            'position' => 'Admin',
            'password' => Hash::make('password123'),
            'privilege' => 'super_admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'position' => '',
            'password' => Hash::make('password123'),
            'privilege' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => 'Reni',
            'email' => 'reni@gmail.com',
            'position' => 'Admin Teknik',
            'password' => Hash::make('password123'),
            'privilege' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => 'Michel',
            'email' => 'michel@gmail.com',
            'position' => 'Admin Support',
            'password' => Hash::make('password123'),
            'privilege' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => 'Doni',
            'email' => 'doni@gmail.com',
            'position' => 'Admin Pjl',
            'password' => Hash::make('password123'),
            'privilege' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => 'Dian',
            'email' => 'dian@gmail.com',
            'position' => '',
            'password' => Hash::make('password123'),
            'privilege' => 'user',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}