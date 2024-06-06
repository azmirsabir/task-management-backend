<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      User::factory()->create([
        'name' => 'azmir',
        'email' => 'azmir@gmail.com',
        'password' => Hash::make('1234567'),
      ]);
      
      User::factory()->create([
        'name' => 'azmir1',
        'email' => 'azmir1@gmail.com',
        'password' => Hash::make('1234567'),
      ]);
      
      User::factory()->create([
        'name' => 'azmir2',
        'email' => 'azmir2@gmail.com',
        'password' => Hash::make('1234567'),
      ]);
      
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
      
        $productOwner=Role::create(['name' => 'product_owner']);
        $developer=Role::create(['name' => 'developer']);
        $tester=Role::create(['name' => 'tester']);
        
        $product_owner_permissions = [
            "create task",
            "view task",
            "update task",
            "delete task",
            "assign tasks to developers",
            "review completed tasks",
            "move tasks to DONE",
            "move tasks to INPROGRESS",
            "create user",
            "delete user",
            "update user",
            "view user",
            "assign title to user"
          ];
        
        $developer_permissions = [
          "move tasks to READYFORTEST",
          "move tasks to INPROGRESS",
        ];
      
        $tester_permissions = [
          "move tasks to POREVIEW",
          "move tasks to INPROGRESS",
        ];
      
        // Merge the arrays
        $permissions = array_merge(
          $product_owner_permissions,
          $developer_permissions,
          $tester_permissions
        );
  
        // Remove duplicates
        $permissions = array_unique($permissions);
        
        // Create permissions
        foreach ($permissions as $permission) {
          Permission::create(["name" => $permission]);
        }
        
        $productOwner->syncPermissions($product_owner_permissions);
        $developer->syncPermissions($developer_permissions);
        $tester->syncPermissions($tester_permissions);
        
        User::find(1)->syncRoles(['product_owner']);
        User::find(2)->syncRoles(['developer']);
        User::find(3)->syncRoles(['tester']);
    }
}
