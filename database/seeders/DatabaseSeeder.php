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

        DB::table('gender')->insert([
            ['name' => 'FEMENINO'],
            ['name' => 'MASCULINO']
        ]);

        DB::table('stratum')->insert([
            ['number' => 1],
            ['number' => 2],
            ['number' => 3],
            ['number' => 4],
            ['number' => 5],
            ['number' => 6]
        ]);

        DB::table('modality')->insert([
            ['name' => 'DISTANCIA'],
            ['name' => 'PRESENCIAL'],
            ['name' => 'VIRTUAL']
        ]);

        DB::table('acceptance_type')->insert([
            ['name' => 'DEPORT'],
            ['name' => 'INDIGENA'],
            ['name' => 'LEY1084B'],
            ['name' => 'NEGRITUD'],
            ['name' => 'POR-EXAM']
        ]);

        DB::table('registration_type')->insert([
            ['name' => 'DEPORT'],
            ['name' => 'INDIGENA'],
            ['name' => 'LEY1084B'],
            ['name' => 'NEGRITUD'],
            ['name' => 'POR-EXAM'],
            ['name' => 'NORMAL']
        ]);

    }
}
