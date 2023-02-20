<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
           'name' => 'Admin'
        ]);

        Role::create([
            'name' => 'Workman'
         ]);

         Role::create([
            'name' => 'Chief'
         ]);

         Role::create([
            'name' => 'Director'
         ]);

         Role::create([
            'name' => 'Bugalter'
         ]);
    }
}