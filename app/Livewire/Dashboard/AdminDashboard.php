<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('employment_status', 'active')->count(),
            'present_today' => Attendance::whereDate('date', today())
                ->where('status', 'present')
                ->count(),
            'on_leave_today' => LeaveRequest::where('status', 'approved')
                ->whereDate('start_date', '<=', today())
                ->whereDate('end_date', '>=', today())
                ->count(),
            'pending_leave' => LeaveRequest::where('status', 'pending')->count(),
            'overdue_tasks' => Task::where('due_date', '<', today())
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count(),
            'new_hires_this_month' => Employee::whereMonth('hire_date', now()->month)
                ->whereYear('hire_date', now()->year)
                ->count(),
            'departments_count' => \App\Models\Department::count(),
        ];

        // Recent activities
        $recentActivities = \App\Models\ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Recent employees
        $recentEmployees = Employee::with(['department', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        // Upcoming leave
        $upcomingLeave = LeaveRequest::with(['employee', 'leaveType'])
            ->where('status', 'approved')
            ->where('start_date', '>=', today())
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'recentEmployees' => $recentEmployees,
            'upcomingLeave' => $upcomingLeave,
        ]);
    }
}