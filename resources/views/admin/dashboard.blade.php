<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Dashboard
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.tickets.index') }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    Manage Tickets
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Message -->
            <div class="mb-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                        <p class="text-blue-100">Here's what's happening with your support system today.</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <!-- Total Tickets -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Total Tickets</p>
                                <p class="text-3xl font-semibold text-gray-900">{{ $totalTickets }}</p>
                                <p class="text-xs text-gray-500 mt-1">All time</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Open Tickets -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Open Tickets</p>
                                <p class="text-3xl font-semibold text-yellow-600">{{ $openTickets }}</p>
                                <p class="text-xs text-gray-500 mt-1">Needs attention</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">In Progress</p>
                                <p class="text-3xl font-semibold text-indigo-600">{{ $inProgressTickets }}</p>
                                <p class="text-xs text-gray-500 mt-1">Being worked on</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resolved Tickets -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Resolved</p>
                                <p class="text-3xl font-semibold text-green-600">{{ $resolvedTickets }}</p>
                                <p class="text-xs text-gray-500 mt-1">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Second Row of Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <!-- Closed Tickets -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Closed</p>
                                <p class="text-3xl font-semibold text-red-600">{{ $closedTickets }}</p>
                                <p class="text-xs text-gray-500 mt-1">Archived</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Total Users</p>
                                <p class="text-3xl font-semibold text-purple-600">{{ $totalUsers }}</p>
                                <p class="text-xs text-gray-500 mt-1">Registered accounts</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agents -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-teal-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Support Agents</p>
                                <p class="text-3xl font-semibold text-teal-600">{{ $totalAgents }}</p>
                                <p class="text-xs text-gray-500 mt-1">Active agents</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admins -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-lg transition duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-pink-100 rounded-lg p-3">
                                <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500 uppercase">Administrators</p>
                                <p class="text-3xl font-semibold text-pink-600">{{ $totalAdmins }}</p>
                                <p class="text-xs text-gray-500 mt-1">System admins</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Priority Distribution -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                <!-- Tickets by Priority -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Tickets by Priority
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Low Priority</span>
                                    <span class="text-sm text-gray-600">{{ $lowPriority ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gray-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($lowPriority ?? 0) / $totalTickets * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Medium Priority</span>
                                    <span class="text-sm text-gray-600">{{ $mediumPriority ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($mediumPriority ?? 0) / $totalTickets * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">High Priority</span>
                                    <span class="text-sm text-gray-600">{{ $highPriority ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($highPriority ?? 0) / $totalTickets * 100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Urgent Priority</span>
                                    <span class="text-sm text-gray-600">{{ $urgentPriority ?? 0 }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($urgentPriority ?? 0) / $totalTickets * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-md rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.tickets.index') }}" 
                               class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                View All Tickets
                            </a>
                            <a href="{{ route('admin.categories.index') }}" 
                               class="block w-full text-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200">
                                Manage Categories
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                               class="block w-full text-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition duration-200">
                                Manage Users
                            </a>
                           
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Tickets -->
            @isset($recentTickets)
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Tickets
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-2 px-3">ID</th>
                                    <th class="text-left py-2 px-3">Title</th>
                                    <th class="text-left py-2 px-3">User</th>
                                    <th class="text-left py-2 px-3">Status</th>
                                    <th class="text-left py-2 px-3">Priority</th>
                                    <th class="text-left py-2 px-3">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTickets as $ticket)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-3">#{{ $ticket->id }}</td>
                                    <td class="py-2 px-3">{{ Str::limit($ticket->title, 40) }}</td>
                                    <td class="py-2 px-3">{{ $ticket->user->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-3">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $ticket->status == 'open' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $ticket->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $ticket->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $ticket->status == 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $ticket->priority == 'low' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $ticket->priority == 'medium' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $ticket->priority == 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $ticket->priority == 'urgent' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-sm">{{ $ticket->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.tickets.index') }}" class="text-blue-600 hover:text-blue-800">View All Tickets →</a>
                    </div>
                </div>
            </div>
            @endisset

        </div>
    </div>
</x-app-layout>