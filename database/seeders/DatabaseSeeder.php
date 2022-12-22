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

        DB::table('semester')->insert([
            ['name' => 20151],
            ['name' => 20152],
            ['name' => 20161],
            ['name' => 20162],
            ['name' => 20171],
            ['name' => 20172],
            ['name' => 20181],
            ['name' => 20182],
            ['name' => 20191],
            ['name' => 20192],
            ['name' => 20201],
            ['name' => 20202],
            ['name' => 20211],
            ['name' => 20212],
            ['name' => 20221],
            ['name' => 20222],
            ['name' => 20231],
            ['name' => 20232],
            ['name' => 20241],
            ['name' => 20242],
            ['name' => 20251],
            ['name' => 20252],
            ['name' => 20261],
            ['name' => 20262],
            ['name' => 20271],
            ['name' => 20272],
            ['name' => 20281],
            ['name' => 20282],
            ['name' => 20291],
            ['name' => 20292],
            ['name' => 20301],
            ['name' => 20302]
        ]);
    }
}
