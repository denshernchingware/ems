<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees') }}
        </h2>

    </x-slot>

<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($no_profile) && $no_profile)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Your employee profile is not yet set up. Please contact HR administrator.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Task Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-blue-100 rounded-full">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Pending Tasks</p>
                                    <p class="text-2xl font-semibold text-gray-700">{{ $tasks['pending'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-purple-100 rounded-full">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">In Progress</p>
                                    <p class="text-2xl font-semibold text-gray-700">{{ $tasks['in_progress'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-green-100 rounded-full">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Completed (This Month)</p>
                                    <p class="text-2xl font-semibold text-gray-700">{{ $tasks['completed_this_month'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Tasks & Leave Balance -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Tasks -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Tasks</h3>
                            <div class="space-y-3">
                                @forelse($recentTasks as $task)
                                    <div class="border-b pb-2">
                                        <p class="font-medium text-gray-900">{{ $task->title }}</p>
                                        <p class="text-sm text-gray-500">Due: {{ $task->due_date->format('M d, Y') }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($task->priority == 'urgent') bg-red-100 text-red-800
                                            @elseif($task->priority == 'high') bg-orange-100 text-orange-800
                                            @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No tasks assigned.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Leave Balance -->
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Balance ({{ date('Y') }})</h3>
                            <div class="space-y-3">
                                @foreach($leaveBalance as $name => $balance)
                                    <div>
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="font-medium text-gray-700">{{ $name }}</span>
                                            <span class="text-gray-600">{{ $balance['remaining'] }} / {{ $balance['total'] }} days</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($balance['used'] / $balance['total']) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($pendingLeave->count() > 0)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Pending Leave Requests</h4>
                                    @foreach($pendingLeave as $leave)
                                        <div class="text-sm text-yellow-600">
                                            {{ $leave->leaveType->name }} - {{ $leave->start_date->format('M d') }} to {{ $leave->end_date->format('M d, Y') }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance -->
                <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Attendance (Last 7 Days)</h3>
                        <div class="grid grid-cols-7 gap-2">
                            @php
                                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                $attendanceMap = [];
                                foreach($recentAttendance as $att) {
                                    $attendanceMap[$att->date->format('Y-m-d')] = $att;
                                }
                            @endphp

                            @for($i = 6; $i >= 0; $i--)
                                @php
                                    $date = now()->subDays($i);
                                    $attendance = $attendanceMap[$date->format('Y-m-d')] ?? null;
                                    $statusColor = match($attendance->status ?? 'absent') {
                                        'present' => 'bg-green-100 text-green-800',
                                        'late' => 'bg-yellow-100 text-yellow-800',
                                        'half_day' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-500'
                                    };
                                @endphp
                                <div class="text-center">
                                    <div class="text-xs text-gray-500 mb-1">{{ $days[$date->dayOfWeekIso - 1] }}</div>
                                    <div class="p-2 rounded-lg {{ $statusColor }}">
                                        <div class="text-sm font-medium">{{ $date->format('d') }}</div>
                                        <div class="text-xs">{{ ucfirst($attendance->status ?? 'Absent') }}</div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


</x-app-layout>
