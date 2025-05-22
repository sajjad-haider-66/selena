<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * KEY : MULTIPERMISSION
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'User', 
            'email' => 'user@gmail.com',
            'password' => Hash::make('user@123456')
        ]);             

        $role = Role::findByName('User');      
        $grantPermissions = [
            // 'role-list', 
            // 'role-create', 
            // 'role-edit', 
            // 'role-delete', 
            // 'product-list', 
            // 'product-create', 
            // 'product-edit', 
            // 'product-delete',
            'order-list', 
            'order-create', 
            // 'order-edit', 
            // 'order-delete'  
         ]; 

        $permissions = Permission::whereIn('name',$grantPermissions)->pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
