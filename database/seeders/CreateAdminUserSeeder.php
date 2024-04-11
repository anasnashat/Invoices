<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'anas',
            'email' => 'anas@anas.com',
            'password' => bcrypt('123456789'),
            'roles_name' => ["owner"],
            'status' => 'active',
        ]);

        // Create roles
        $roles = [
            ['name' => 'owner', 'guard_name' => 'web'],
            ['name' => 'user', 'guard_name' => 'web']
        ];

// Insert roles into the database
        Role::insert($roles);

// Retrieve permissions
        $permissions = Permission::pluck('id')->all();

// Retrieve the roles from the database
        $ownerRole = Role::where('name', 'owner')->first();
        $userRole = Role::where('name', 'user')->first();

// Sync permissions to roles
        if ($ownerRole) {
            $ownerRole->syncPermissions($permissions);
        }

        if ($userRole) {
            $userRole->syncPermissions($permissions);
        }

// Assign roles to user(s)
//        $user = User::find($user->id); // Replace $userId with the ID of the user you want to assign roles to

        if ($user && $ownerRole) {
            $user->assignRole($ownerRole);
        }

    }
}
