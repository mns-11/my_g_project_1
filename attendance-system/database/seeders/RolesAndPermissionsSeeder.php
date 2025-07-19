<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions

        Permission::create(['name' => 'manage student_affairs']);
        Permission::create(['name' => 'create student_affairs']);
        Permission::create(['name' => 'edit student_affairs']);
        Permission::create(['name' => 'view student_affairs']);

        Permission::create(['name' => 'manage teachers']);
        Permission::create(['name' => 'create teachers']);
        Permission::create(['name' => 'edit teachers']);
        Permission::create(['name' => 'view teachers']);

        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'view students']);

        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'create courses']);
        Permission::create(['name' => 'edit courses']);
        Permission::create(['name' => 'view courses']);

        Permission::create(['name' => 'manage lectures']);
        Permission::create(['name' => 'create lectures']);
        Permission::create(['name' => 'edit lectures']);
        Permission::create(['name' => 'view lectures']);

        Permission::create(['name' => 'manage colleges']);
        Permission::create(['name' => 'create colleges']);
        Permission::create(['name' => 'edit colleges']);
        Permission::create(['name' => 'view colleges']);

        Permission::create(['name' => 'manage majors']);
        Permission::create(['name' => 'create majors']);
        Permission::create(['name' => 'edit majors']);
        Permission::create(['name' => 'view majors']);

        Permission::create(['name' => 'manage attendances']);
        Permission::create(['name' => 'create attendances']);
        Permission::create(['name' => 'edit attendances']);
        Permission::create(['name' => 'view attendances']);

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);

        $teacherRole = Role::create(['name' => 'teacher']);

        $studentRole = Role::create(['name' => 'student']);

        $coordinatorRole = Role::create(['name' => 'coordinator']);

        $chiefRole = Role::create(['name' => 'chief']);


        $adminRole->givePermissionTo(Permission::query()->get());

        $teacherRole->givePermissionTo([
            'view colleges',
            'view majors',
            'view students',
            'view courses',
            'view lectures',
            'edit lectures',
            'create lectures',
            'manage lectures',
            'view attendances',
            'create attendances',
//            'edit attendances',
//            'manage attendances',
        ]);

        $studentRole->givePermissionTo([
            'view colleges',
            'view majors',
            'view courses',
            'view lectures',
            'view attendances',
        ]);

        $chiefRole->givePermissionTo([
            'view colleges',
            'view majors',
            'view courses',
            'view students',
            'view attendances',
            'edit attendances',
        ]);


        $coordinatorRole->givePermissionTo([
            'view colleges',
            'view majors',
            'view courses',
            'view students',
            'view attendances',
            'create attendances',
            'edit attendances',
        ]);
    }
}
