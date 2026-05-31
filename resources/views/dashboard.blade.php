<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Employees -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-indigo-100 rounded-full">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Employees</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $stats['total_employees'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Present Today -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-full">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Present Today</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $stats['present_today'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- On Leave Today -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">On Leave Today</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $stats['on_leave_today'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overdue Tasks -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-red-100 rounded-full">
                                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Overdue Tasks</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $stats['overdue_tasks'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Row Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Leave Requests</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['pending_leave'] }}</p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">New Hires (This Month)</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['new_hires_this_month'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Employees & Upcoming Leave -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Employees -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Employees</h3>
                        <div class="space-y-3">
                            @forelse($recentEmployees as $employee)
                                <div class="flex items-center justify-between border-b pb-2">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $employee->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $employee->department->name ?? 'N/A' }} - {{ $employee->jobTitle->title ?? 'N/A' }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $employee->created_at->diffForHumans() }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">No employees found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Upcoming Leave -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Leave</h3>
                        <div class="space-y-3">
                            @forelse($upcomingLeave as $leave)
                                <div class="flex items-center justify-between border-b pb-2">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $leave->employee->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $leave->leaveType->name }} - {{ $leave->start_date->format('M d') }} to {{ $leave->end_date->format('M d, Y') }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $leave->days_requested }} days
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500">No upcoming leave requests.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h3>
                    <div class="space-y-2">
                        @forelse($recentActivities as $activity)
                            <div class="text-sm text-gray-600 border-b pb-2">
                                <span class="font-medium">{{ $activity->user->name ?? 'System' }}</span>
                                <span>{{ $activity->description }}</span>
                                <span class="text-gray-400 text-xs">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500">No activities recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
