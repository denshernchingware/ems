<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Task;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboard extends Component
{
    public $employee;

    public function mount()
    {
        $this->employee = Auth::user()->employee;

        if (!$this->employee) {
            return;
        }
    }

    public function render()
    {
        if (!$this->employee) {
            return view('employees.index', [
                'no_profile' => true,
            ]);
        }

        // Task statistics
        $tasks = [
            'pending' => Task::where('assigned_to', $this->employee->id)
                ->where('status', 'pending')
                ->count(),
            'in_progress' => Task::where('assigned_to', $this->employee->id)
                ->where('status', 'in_progress')
                ->count(),
            'completed_this_month' => Task::where('assigned_to', $this->employee->id)
                ->where('status', 'completed')
                ->whereMonth('completed_at', now()->month)
                ->count(),
        ];

        // Recent tasks
        $recentTasks = Task::where('assigned_to', $this->employee->id)
            ->with('assigner')
            ->latest()
            ->limit(5)
            ->get();

        // Leave balance (simplified)
        $leaveBalance = [];
        $leaveTypes = LeaveType::all();
        foreach ($leaveTypes as $type) {
            $usedDays = LeaveRequest::where('employee_id', $this->employee->id)
                ->where('leave_type_id', $type->id)
                ->where('status', 'approved')
                ->whereYear('created_at', now()->year)
                ->sum('days_requested');

            $leaveBalance[$type->name] = [
                'total' => $type->days_allowed,
                'used' => $usedDays,
                'remaining' => $type->days_allowed - $usedDays,
            ];
        }

        // Pending leave requests
        $pendingLeave = LeaveRequest::where('employee_id', $this->employee->id)
            ->where('status', 'pending')
            ->with('leaveType')
            ->get();

        // Recent attendance (last 7 days)
        $recentAttendance = \App\Models\Attendance::where('employee_id', $this->employee->id)
            ->where('date', '>=', now()->subDays(7))
            ->orderBy('date', 'desc')
            ->get();

        return view('employees.index', [
            'tasks' => $tasks,
            'recentTasks' => $recentTasks,
            'leaveBalance' => $leaveBalance,
            'pendingLeave' => $pendingLeave,
            'recentAttendance' => $recentAttendance,
        ]);
    }
}