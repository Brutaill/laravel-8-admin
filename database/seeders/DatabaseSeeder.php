<?php

namespace Database\Seeders;

use App\Models\Task;
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

        $permissionsArray = $this->generatePermissionsArray(['client', 'project', 'task', 'user', 'role', 'permission']);
        
        $role_super_admin = Role::create(['name' => 'Super Admin']);
        $role_admin = Role::create(['name' => 'Admin']);
        $role_guest = Role::create(['name' => 'Guest']);
        $role_manager = Role::create(['name' => 'Manager']);

        Permission::create(['name' => 'all']);
        $role_super_admin->givePermissionTo(1);

        foreach($permissionsArray as $permission) {
            Permission::create(['name' => $permission]);
        }

        // add default super admin user
        User::create([
            'name' => 'Jozef Mruz',
            'email' => 'jozef.mruz@gmail.com',
            'password' => 'administrator',
            'is_admin' => true,
        ])->assignRole($role_super_admin); 

        // add default admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'administrator@example.com',
            'password' => 'administrator',
            'is_admin' => true,
        ])->assignRole($role_admin); 

        // add default guest user
        User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => 'password',
            'is_admin' => false,
        ])->assignRole($role_guest); 

        // add default manager user
        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password',
            'is_admin' => false,
        ])->assignRole($role_manager); 

        User::factory(1)->create()->each(function($user) use($role_guest) { $user->assignRole($role_guest); }); 
        Client::factory(1)->create();        
        Project::factory(2)->create();

        $users = User::all();

        // Populate the pivot table
        Project::all()->each(function ($project) use ($users) { 
            $project->users()->attach(
                $users->random(rand(1, 5))->pluck('id')->toArray()
            );             
        });

        for($i=0; $i<5; $i++) {
            $project = Project::inRandomOrder()->first();
            // give task to random projects
            Task::factory([
                'client_id' => $project->client->id,
                'project_id' => $project->id,
                'user_id' => $project->users()->inRandomOrder()->first()->id,
            ])->create();
        }

    }

    private function generatePermissionsArray(array $array = [])
    {
        
        $result = [];        
        foreach($array as $a) {        
            $result[] = "{$a}_create";                
            $result[] = "{$a}_update";                
            $result[] = "{$a}_delete";                
            $result[] = "{$a}_view";                 
            $result[] = "{$a}_archive";                 
        }
        return $result;
    }
}
