<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Guest']);

        Permission::create(['name' => 'all permission']);

        // add default admin user
        User::create([
            'name' => 'Jozef Mruz',
            'email' => 'jozef.mruz@gmail.com',
            'password' => Hash::make('brutallik'),
            'is_admin' => true,
        ])->assignRole(1); 

        // add default guest user
        User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ])->assignRole(2); 

        User::factory(10)->create(); 
        Client::factory(10)->create();        
        Project::factory(10)->create();


        // Get all users
        $users = User::all();

        // Populate the pivot table
        Project::all()->each(function ($project) use ($users) { 
            $project->users()->attach(
                $users->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

    }
}
