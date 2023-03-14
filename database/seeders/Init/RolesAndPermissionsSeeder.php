<?php

namespace Database\Seeders\Init;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayOfPermissionNames = [
            'teacher-view', 'student-view', 'class-view', 'marks-view',
            'class-add', 'mark-edit', 'mark-add', 'task-add', 'add-student-to-class',
        ];
        $isExists = Permission::whereIn('name', $arrayOfPermissionNames)->exists();
        if (! $isExists) {
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
            $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
                return ['name' => $permission, 'guard_name' => 'web'];
            });
            Permission::insert($permissions->toArray());
            Role::create(['name' => 'admin'])->givePermissionTo($arrayOfPermissionNames);
            Role::create(['name' => 'teacher'])->givePermissionTo(['student-view', 'class-view', 'add-student-to-class', 'mark-edit', 'mark-add', 'task-add']);
            Role::create(['name' => 'student'])->givePermissionTo(['class-view', 'marks-view', 'teacher-view']);
        }
    }
}
