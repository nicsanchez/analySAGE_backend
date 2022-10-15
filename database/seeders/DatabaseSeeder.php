<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Administrador',
                'lastname' => 'Udea',
                'email' => 'adminudea@udea.edu.co',
                'document' => 1234567890,
                'rol' => 1,
                'status' => 1,
                'username' => 'admin',
                'password' => Hash::make('Admin123456@')
            ]
        );

        DB::table('roles')->insert(
            [
                'name' => 'Administrador',
                'key' => 'ADMIN'
            ]
        );

        DB::table('roles')->insert(
            [
                'name' => 'Usuario',
                'key' => 'USER'
            ]
        );
    }
}
