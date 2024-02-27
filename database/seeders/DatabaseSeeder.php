<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'deejayvoke@gmail.com',
            'password' => Hash::make('N@li@k@2030'),
            'organization_id' => 1,
            'role_id' => 1
        ]);


       $role = Role::create(['name' => 'Super Admin']);
       $role = Role::create(['name' => 'Admin']);
       $role = Role::create(['name' => 'Support']);
       $role = Role::create(['name' => 'Customer']);




    }
}
