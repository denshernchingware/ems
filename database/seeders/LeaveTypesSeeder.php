<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Annual Leave',
                'days_allowed' => 20,
                'is_paid' => true,
                'requires_document' => false,
                'description' => 'Standard paid annual vacation leave',
            ],
            [
                'name' => 'Sick Leave',
                'days_allowed' => 12,
                'is_paid' => true,
                'requires_document' => true,
                'description' => 'Paid sick leave with medical certificate required for more than 2 days',
            ],
            [
                'name' => 'Unpaid Leave',
                'days_allowed' => 30,
                'is_paid' => false,
                'requires_document' => false,
                'description' => 'Unpaid personal leave',
            ],
            [
                'name' => 'Maternity Leave',
                'days_allowed' => 90,
                'is_paid' => true,
                'requires_document' => true,
                'description' => 'Maternity leave benefits',
            ],
            [
                'name' => 'Paternity Leave',
                'days_allowed' => 10,
                'is_paid' => true,
                'requires_document' => true,
                'description' => 'Paternity leave benefits',
            ],
            [
                'name' => 'Bereavement Leave',
                'days_allowed' => 5,
                'is_paid' => true,
                'requires_document' => false,
                'description' => 'Leave for family bereavement',
            ],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::create($leaveType);
        }
    }
}
