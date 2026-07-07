<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Tickets Management
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Tickets</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $tickets->total() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Open</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['open'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Resolved</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['resolved'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">High Priority</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['high_priority'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Unassigned</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $stats['unassigned'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('admin.tickets.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search by title, user, or ID..." 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Statuses</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        
                        <div>
                            <select name="priority" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        
                        <div>
                            <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    @php
                                        $categoryId = data_get($category, 'id');
                                        $categoryName = data_get($category, 'name');
                                    @endphp
                                    <option value="{{ $categoryId }}" {{ request('category') == $categoryId ? 'selected' : '' }}>
                                        {{ $categoryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                Apply Filters
                            </button>
                            
                            @if(request()->anyFilled(['search', 'status', 'priority', 'category']))
                                <a href="{{ route('admin.tickets.index') }}" 
                                   class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition duration-200">
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} of {{ $tickets->total() }} tickets
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tickets Table -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('admin.tickets.index', array_merge(request()->query(), ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                                       class="flex items-center space-x-1 hover:text-gray-700">
                                        <span>ID/Ticket</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                        </svg>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title & User
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Agent
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono font-medium text-gray-900">
                                            #{{ $ticket->id }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ Str::limit($ticket->title, 40) }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            by {{ $ticket->user->name ?? 'Deleted User' }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">
                                            {{ $ticket->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'open' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'resolved' => 'bg-green-100 text-green-800',
                                                'closed' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityColors = [
                                                'low' => 'bg-gray-100 text-gray-800',
                                                'medium' => 'bg-blue-100 text-blue-800',
                                                'high' => 'bg-orange-100 text-orange-800',
                                                'urgent' => 'bg-red-100 text-red-800',
                                            ];
                                            $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityColor }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($ticket->assignedAgent)
                                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-gray-300 flex items-center justify-center text-xs font-medium">
                                                    {{ substr($ticket->assignedAgent->name, 0, 1) }}
                                                </div>
                                                <div class="ml-2 text-sm text-gray-900">
                                                    {{ $ticket->assignedAgent->name }}
                                                </div>
                                            @else
                                                <span class="text-xs text-red-600 font-medium">Unassigned</span>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->created_at->format('M d, Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition duration-150">
                                            View Details
                                        </a>
                                    </td>
                                
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No tickets found</h3>
                                            <p class="text-gray-500">
                                                @if(request()->anyFilled(['search', 'status', 'priority', 'category']))
                                                    No tickets match your filter criteria.
                                                @else
                                                    There are no tickets in the system yet.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($tickets->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tickets->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</x-app-layout>