<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions by module
        $permissions = [
            // Employee Management
            'employees.view',
            'employees.create',
            'employees.edit',
            'employees.delete',

            // Department Management
            'departments.view',
            'departments.create',
            'departments.edit',
            'departments.delete',

            // Job Titles
            'job_titles.view',
            'job_titles.create',
            'job_titles.edit',
            'job_titles.delete',

            // Attendance
            'attendance.view',
            'attendance.mark',
            'attendance.edit',

            // Leave Management
            'leave.apply',
            'leave.view',
            'leave.approve',
            'leave.reject',

            // Tasks
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'tasks.assign',

            // Reports
            'reports.view',
            'reports.export',

            // Activity Logs
            'activity_logs.view',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $adminRole = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
            'display_name' => 'Administrator',
            'description' => 'Full system access'
        ]);

        $hrManagerRole = Role::create([
            'name' => 'hr_manager',
            'guard_name' => 'web',
            'display_name' => 'HR Manager',
            'description' => 'Manage employees, approve leave, view all attendance'
        ]);

        $departmentManagerRole = Role::create([
            'name' => 'department_manager',
            'guard_name' => 'web',
            'display_name' => 'Department Manager',
            'description' => 'Manage own department tasks and attendance'
        ]);

        $employeeRole = Role::create([
            'name' => 'employee',
            'guard_name' => 'web',
            'display_name' => 'Employee',
            'description' => 'Basic employee access'
        ]);

        // Assign permissions to Admin (all permissions)
        $adminRole->givePermissionTo(Permission::all());

        // Assign permissions to HR Manager
        $hrManagerRole->givePermissionTo([
            'employees.view',
            'employees.create',
            'employees.edit',
            'departments.view',
            'job_titles.view',
            'attendance.view',
            'attendance.mark',
            'leave.view',
            'leave.approve',
            'leave.reject',
            'reports.view',
            'reports.export',
            'activity_logs.view',
        ]);

        // Assign permissions to Department Manager
        $departmentManagerRole->givePermissionTo([
            'employees.view',
            'departments.view',
            'job_titles.view',
            'attendance.view',
            'leave.view',
            'leave.approve',
            'leave.reject',
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'tasks.assign',
            'reports.view',
        ]);

        // Assign permissions to Employee
        $employeeRole->givePermissionTo([
            'leave.apply',
            'attendance.view',
            'tasks.view',
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@ems.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create HR Manager user
        $hrManager = User::create([
            'name' => 'HR Manager',
            'email' => 'hr@ems.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $hrManager->assignRole('hr_manager');

        // Create Department Manager user
        $deptManager = User::create([
            'name' => 'Department Manager',
            'email' => 'manager@ems.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $deptManager->assignRole('department_manager');

        // Create Employee user
        $employee = User::create([
            'name' => 'John Employee',
            'email' => 'employee@ems.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $employee->assignRole('employee');
    }
}