<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * KEY : MULTIPERMISSION
     */
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Add new Modules permission here
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-show',
            'user-delete',
            'role-list',
            'role-create',
            'role-show',
            'role-edit',
            'role-delete',
            'talk_animation-list',
            'talk_animation-create',
            'talk_animation-edit',
            'talk_animation-delete',
            'talk_animation-show',
            'daily_readiness-list',
            'daily_readiness-create',
            'daily_readiness-edit',
            'daily_readiness-delete',
            'daily_readiness-show',
            'audit-list',
            'audit-create',
            'audit-edit',
            'audit-show',
            'audit-delete',
            'action-list',
            'action-create',
            'action-edit',
            'action-delete',
            'action-show',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'event-show',
            'checklist-list',
            'checklist-create',
            'checklist-edit',
            'checklist-delete',
            'checklist-show',

        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
