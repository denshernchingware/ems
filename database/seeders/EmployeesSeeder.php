<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::insert([
            ['name' => 'Engineering', 'code' => 'ENG', 'description' => 'Software and infrastructure engineering', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'Human resources and personnel management', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'code' => 'MKT', 'description' => 'Marketing and brand management', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Financial planning and accounting', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Business operations and logistics', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $engineering = Department::where('code', 'ENG')->first();
        $hr = Department::where('code', 'HR')->first();
        $marketing = Department::where('code', 'MKT')->first();
        $finance = Department::where('code', 'FIN')->first();
        $operations = Department::where('code', 'OPS')->first();

        $jobTitles = JobTitle::insert([
            ['title' => 'Senior Software Engineer', 'department_id' => $engineering->id, 'level' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Junior Software Engineer', 'department_id' => $engineering->id, 'level' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'HR Manager', 'department_id' => $hr->id, 'level' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Marketing Specialist', 'department_id' => $marketing->id, 'level' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Financial Analyst', 'department_id' => $finance->id, 'level' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $seniorEng = JobTitle::where('title', 'Senior Software Engineer')->first();
        $juniorEng = JobTitle::where('title', 'Junior Software Engineer')->first();
        $hrMgr = JobTitle::where('title', 'HR Manager')->first();
        $mktSpec = JobTitle::where('title', 'Marketing Specialist')->first();
        $finAnalyst = JobTitle::where('title', 'Financial Analyst')->first();

        $employees = [
            [
                'user' => ['name' => 'Alice Chen', 'email' => 'alice@ems.com', 'password' => Hash::make('password'), 'is_active' => true],
                'employee' => [
                    'employee_code' => 'EMP001',
                    'first_name' => 'Alice', 'last_name' => 'Chen',
                    'gender' => 'F', 'date_of_birth' => '1990-03-15',
                    'national_id' => 'NID-001', 'phone' => '555-0101',
                    'personal_email' => 'alice.chen@email.com', 'address' => '123 Main St, City',
                    'department_id' => $engineering->id, 'job_title_id' => $seniorEng->id,
                    'employment_type' => 'full_time', 'employment_status' => 'active',
                    'hire_date' => '2022-01-10', 'basic_salary' => 95000,
                ],
            ],
            [
                'user' => ['name' => 'Bob Martinez', 'email' => 'bob@ems.com', 'password' => Hash::make('password'), 'is_active' => true],
                'employee' => [
                    'employee_code' => 'EMP002',
                    'first_name' => 'Bob', 'last_name' => 'Martinez',
                    'gender' => 'M', 'date_of_birth' => '1995-07-22',
                    'national_id' => 'NID-002', 'phone' => '555-0102',
                    'personal_email' => 'bob.martinez@email.com', 'address' => '456 Oak Ave, City',
                    'department_id' => $engineering->id, 'job_title_id' => $juniorEng->id,
                    'employment_type' => 'full_time', 'employment_status' => 'active',
                    'hire_date' => '2023-06-01', 'basic_salary' => 70000,
                ],
            ],
            [
                'user' => ['name' => 'Carol Johnson', 'email' => 'carol@ems.com', 'password' => Hash::make('password'), 'is_active' => true],
                'employee' => [
                    'employee_code' => 'EMP003',
                    'first_name' => 'Carol', 'last_name' => 'Johnson',
                    'gender' => 'F', 'date_of_birth' => '1988-11-05',
                    'national_id' => 'NID-003', 'phone' => '555-0103',
                    'personal_email' => 'carol.johnson@email.com', 'address' => '789 Pine Rd, City',
                    'department_id' => $hr->id, 'job_title_id' => $hrMgr->id,
                    'employment_type' => 'full_time', 'employment_status' => 'active',
                    'hire_date' => '2021-09-15', 'basic_salary' => 85000,
                ],
            ],
            [
                'user' => ['name' => 'David Kim', 'email' => 'david@ems.com', 'password' => Hash::make('password'), 'is_active' => true],
                'employee' => [
                    'employee_code' => 'EMP004',
                    'first_name' => 'David', 'last_name' => 'Kim',
                    'gender' => 'M', 'date_of_birth' => '1992-02-14',
                    'national_id' => 'NID-004', 'phone' => '555-0104',
                    'personal_email' => 'david.kim@email.com', 'address' => '321 Elm St, City',
                    'department_id' => $marketing->id, 'job_title_id' => $mktSpec->id,
                    'employment_type' => 'full_time', 'employment_status' => 'active',
                    'hire_date' => '2020-03-20', 'basic_salary' => 72000,
                ],
            ],
            [
                'user' => ['name' => 'Eve Thompson', 'email' => 'eve@ems.com', 'password' => Hash::make('password'), 'is_active' => true],
                'employee' => [
                    'employee_code' => 'EMP005',
                    'first_name' => 'Eve', 'last_name' => 'Thompson',
                    'gender' => 'F', 'date_of_birth' => '1993-09-30',
                    'national_id' => 'NID-005', 'phone' => '555-0105',
                    'personal_email' => 'eve.thompson@email.com', 'address' => '654 Maple Dr, City',
                    'department_id' => $finance->id, 'job_title_id' => $finAnalyst->id,
                    'employment_type' => 'full_time', 'employment_status' => 'active',
                    'hire_date' => '2022-11-01', 'basic_salary' => 78000,
                ],
            ],
        ];

        $createdEmployees = [];

        foreach ($employees as $data) {
            $user = User::create($data['user']);

            $employeeData = $data['employee'];
            $employeeData['user_id'] = $user->id;

            $createdEmployees[] = Employee::create($employeeData);
        }

        Department::where('code', 'OPS')->update(['parent_id' => $engineering->id]);
        Department::where('code', 'HR')->update(['parent_id' => $operations->id]);
    }
}
