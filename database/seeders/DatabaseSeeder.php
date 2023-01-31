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

        $permissionsArray = $this->generatePermissionsArray(['client','project','user', 'role', 'permission']);
        
        $role_super_admin = Role::create(['name' => 'Super Admin']);
        $role_admin = Role::create(['name' => 'Admin']);
        $role_guest = Role::create(['name' => 'Guest']);
        $role_guest = Role::create(['name' => 'Manager']);

        Permission::create(['name' => 'all_access']);
        $role_super_admin->givePermissionTo(1);

        foreach($permissionsArray as $permission) {
            Permission::create(['name' => $permission]);
        }

        // add default super admin user
        User::create([
            'name' => 'Jozef Mruz',
            'email' => 'jozef.mruz@gmail.com',
            'password' => Hash::make('brutallik'),
            'is_admin' => true,
        ])->assignRole($role_super_admin); 

        // add default admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'administrator@example.com',
            'password' => Hash::make('administrator'),
            'is_admin' => true,
        ])->assignRole($role_admin); 

        // add default guest user
        User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ])->assignRole($role_guest); 

        $users = User::factory(50)->create(); 
        Client::factory(20)->create();        
        Project::factory(20)->create();

        // Populate the pivot table
        Project::all()->each(function ($project) use ($users) { 
            $project->users()->attach(
                $users->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });

    }

    private function generatePermissionsArray(array $array = [])
    {
        
        $result = [];        
        foreach($array as $a) {        
            $result[] = "{$a}_create";                
            $result[] = "{$a}_update";                
            $result[] = "{$a}_delete";                
            $result[] = "{$a}_view";                 
        }
        return $result;
    }
}
