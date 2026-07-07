<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Tickets
            </h2>
            <a href="{{ route('tickets.create') }}" 
               class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Ticket
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
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

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
                            <p class="text-2xl font-semibold text-yellow-600">{{ $stats['open'] ?? 0 }}</p>
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
                            <p class="text-2xl font-semibold text-green-600">{{ $stats['resolved'] ?? 0 }}</p>
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
                            <p class="text-2xl font-semibold text-red-600">{{ $stats['high_priority'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('tickets.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by title or ticket ID..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div class="w-48">
                        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <div class="w-48">
                        <select name="priority" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">All Priority</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'status', 'priority']))
                            <a href="{{ route('tickets.index') }}" 
                               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition duration-200">
                                Clear
                            </a>
                        @endif
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
                                    Ticket
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
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            #{{ $ticket->id }} - {{ Str::limit($ticket->title, 50) }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ Str::limit($ticket->description, 80) }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ $ticket->category->name ?? 'Uncategorized' }}</span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'open' => 'bg-yellow-100 text-yellow-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'resolved' => 'bg-green-100 text-green-800',
                                                'closed' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $statusIcons = [
                                                'open' => '🟡',
                                                'in_progress' => '🔵',
                                                'resolved' => '🟢',
                                                'closed' => '⚫',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$ticket->status] ?? 'bg-gray-100' }}">
                                            {{ $statusIcons[$ticket->status] ?? '📌' }} {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
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
                                            $priorityIcons = [
                                                'low' => '📋',
                                                'medium' => '📌',
                                                'high' => '⚠️',
                                                'urgent' => '🚨',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityColors[$ticket->priority] ?? 'bg-gray-100' }}">
                                            {{ $priorityIcons[$ticket->priority] ?? '📌' }} {{ ucfirst($ticket->priority) }}
                                        </span>
                                     </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($ticket->assignedAgent)
                                                <div class="flex-shrink-0 h-6 w-6 rounded-full bg-green-100 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-green-600">
                                                        {{ strtoupper(substr($ticket->assignedAgent->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                                <div class="ml-2 text-sm text-gray-900">
                                                    {{ $ticket->assignedAgent->name }}
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500">Not assigned</span>
                                            @endif
                                        </div>
                                     </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->created_at->format('M d, Y') }}
                                        <br>
                                        <span class="text-xs">{{ $ticket->created_at->diffForHumans() }}</span>
                                     </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('tickets.show', $ticket) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition duration-150 inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </a>
                                     </td>
                                 </tr>
                            @empty
                                 <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No tickets found</h3>
                                            <p class="text-gray-500">
                                                @if(request()->anyFilled(['search', 'status', 'priority']))
                                                    No tickets match your filter criteria.
                                                @else
                                                    You haven't created any tickets yet.
                                                @endif
                                            </p>
                                            <a href="{{ route('tickets.create') }}" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                                Create Your First Ticket
                                            </a>
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