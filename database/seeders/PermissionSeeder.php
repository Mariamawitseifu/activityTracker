<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate(['name' => 'read:childemployees']);

        $manager = Role::where('name', 'Manager')->first();
        $manager->syncPermissions([
            'read:users',
            'read:childemployees',
            'read:childunit',
            'read:unitstatus',
            'read:plan',
            'create:plan',
            'update:plan',
            'delete:plan',
            'read:task',
            'create:task',
            'update:task',
            'delete:task',
            'read:subtask',
            'create:subtask',
            'update:subtask',
            'delete:subtask',
            'read:childunit',
            'create:changestatus',
            'read:pendingtask',
            'create:approvetask',
            'read:planreport',
            'create:planreport',
            'update:planreport',
            'delete:planreport',
            'read:remark',
            'create:remark',
            'update:remark',
            'delete:remark',
            'read:fiscalyear',
            'read:monitoring',
            'create:monitoring',
            'update:monitoring',
            'delete:monitoring',
        ]);
    }
}
