<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket Details: #{{ $ticket->id }} - {{ Str::limit($ticket->title, 50) }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.tickets.index') }}" 
                   class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Tickets
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Content (Left Column) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Ticket Details Card -->
                    <div class="bg-white overflow-hidden shadow-md rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $ticket->title }}</h1>
                                    <p class="text-sm text-gray-500 mt-1">Ticket #{{ $ticket->id }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    @php
                                        $statusColors = [
                                            'open' => 'bg-yellow-100 text-yellow-800',
                                            'in_progress' => 'bg-blue-100 text-blue-800',
                                            'resolved' => 'bg-green-100 text-green-800',
                                            'closed' => 'bg-gray-100 text-gray-800',
                                        ];
                                        $priorityColors = [
                                            'low' => 'bg-gray-100 text-gray-800',
                                            'medium' => 'bg-blue-100 text-blue-800',
                                            'high' => 'bg-orange-100 text-orange-800',
                                            'urgent' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$ticket->status] ?? 'bg-gray-100' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityColors[$ticket->priority] ?? 'bg-gray-100' }}">
                                        {{ ucfirst($ticket->priority) }} Priority
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div class="border rounded-lg p-4">
                                    <p class="text-sm text-gray-500">Customer</p>
                                    <div class="flex items-center mt-1">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-medium">
                                                {{ strtoupper(substr($ticket->user->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $ticket->user->name ?? 'Unknown User' }}</p>
                                            <p class="text-xs text-gray-500">{{ $ticket->user->email ?? 'No email' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border rounded-lg p-4">
                                    <p class="text-sm text-gray-500">Category</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket->category->name ?? 'Uncategorized' }}</p>
                                    @if($ticket->category && $ticket->category->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($ticket->category->description, 100) }}</p>
                                    @endif
                                </div>
                                
                                <div class="border rounded-lg p-4">
                                    <p class="text-sm text-gray-500">Assigned Agent</p>
                                    @if($ticket->assignedAgent)
                                        <div class="flex items-center mt-1">
                                            <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-green-600 font-medium">
                                                    {{ strtoupper(substr($ticket->assignedAgent->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $ticket->assignedAgent->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $ticket->assignedAgent->email }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-sm text-red-600 mt-1">Not assigned yet</p>
                                    @endif
                                </div>
                                
                                <div class="border rounded-lg p-4">
                                    <p class="text-sm text-gray-500">Timeline</p>
                                    <p class="text-sm text-gray-900 mt-1">Created: {{ $ticket->created_at->format('M d, Y g:i A') }}</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                                    @if($ticket->updated_at != $ticket->created_at)
                                        <p class="text-sm text-gray-900 mt-1">Updated: {{ $ticket->updated_at->format('M d, Y g:i A') }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->description }}</p>
                                </div>
                            </div>
                            
                            @if($ticket->attachments && $ticket->attachments->count() > 0)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Attachments</h3>
                                    <div class="space-y-2">
                                        @foreach($ticket->attachments as $attachment)
                                            <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3 border border-gray-200">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-700">{{ basename($attachment->file_path) }}</span>
                                                </div>
                                                <a href="{{ Storage::url($attachment->file_path) }}" 
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Download
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Replies Section -->
                    <div class="bg-white overflow-hidden shadow-md rounded-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                                Conversation ({{ $ticket->replies->count() }} replies)
                            </h3>
                            
                            @if($ticket->replies->count() > 0)
                                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                                    @foreach($ticket->replies as $reply)
                                        <div class="flex {{ $reply->user_id === $ticket->user_id ? 'justify-start' : 'justify-end' }}">
                                            <div class="{{ $reply->user_id === $ticket->user_id ? 'bg-gray-100' : 'bg-blue-100' }} rounded-lg p-4 max-w-3xl">
                                                <div class="flex items-center mb-2">
                                                    <div class="flex-shrink-0 h-6 w-6 rounded-full {{ $reply->user_id === $ticket->user_id ? 'bg-gray-400' : 'bg-blue-500' }} flex items-center justify-center">
                                                        <span class="text-white text-xs font-medium">
                                                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-2">
                                                        <p class="text-xs font-medium text-gray-900">{{ $reply->user->name ?? 'Unknown' }}</p>
                                                        <p class="text-xs text-gray-500">{{ $reply->created_at->format('M d, Y g:i A') }}</p>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-700">{{ $reply->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 bg-gray-50 rounded-lg mb-6">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-gray-500">No replies yet. Be the first to respond!</p>
                                </div>
                            @endif
                            
                            <!-- Add Reply Form -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Add Reply</h4>
                                <form method="POST" action="{{ route('tickets.replies.store', $ticket) }}">
                                    @csrf
                                    <textarea
                                        name="message"
                                        rows="4"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('message') border-red-500 @enderror"
                                        placeholder="Write your response to the user..."
                                        required
                                    >{{ old('message') }}</textarea>
                                    
                                    @error('message')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    
                                    <div class="flex justify-end mt-3">
                                        <button type="submit"
                                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Send Reply
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Right Column - Actions & Info -->
                <div class="space-y-6">
                    
                    <!-- Assignment Card -->
                    <div class="bg-white overflow-hidden shadow-md rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Assign Ticket
                            </h3>
                            
                            <form method="POST" action="{{ route('admin.tickets.assign', $ticket) }}">
                                @csrf
                                <select name="assigned_to" 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mb-3" 
                                        required>
                                    <option value="">Select an agent</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}"
                                            @selected($ticket->assigned_agent_id == $agent->id)>
                                            {{ $agent->name }} - {{ $agent->email }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <button type="submit"
                                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                                    Assign Agent
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Quick Actions Card -->
                    <div class="bg-white overflow-hidden shadow-md rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Quick Actions
                            </h3>
                            
                            <div class="space-y-3">
                                <form method="POST" action="{{ route('admin.tickets.status', $ticket) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mb-2"
                                            onchange="this.form.submit()">
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>🟡 Open</option>
                                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>🟢 Resolved</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>⚫ Closed</option>
                                    </select>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.tickets.priority', $ticket) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="priority" 
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                            onchange="this.form.submit()">
                                        <option value="low" {{ $ticket->priority == 'low' ? 'selected' : '' }}>📋 Low</option>
                                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>📌 Medium</option>
                                        <option value="high" {{ $ticket->priority == 'high' ? 'selected' : '' }}>⚠️ High</option>
                                        <option value="urgent" {{ $ticket->priority == 'urgent' ? 'selected' : '' }}>🚨 Urgent</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ticket Info Card -->
                    <div class="bg-white overflow-hidden shadow-md rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ticket Information
                            </h3>
                            
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Ticket ID:</span>
                                    <span class="font-mono font-medium">#{{ $ticket->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Created:</span>
                                    <span>{{ $ticket->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Last Updated:</span>
                                    <span>{{ $ticket->updated_at->diffForHumans() }}</span>
                                </div>
                                @if(isset($responseTime))
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Response Time:</span>
                                        <span class="text-green-600">{{ $responseTime }} hours</span>
                                    </div>
                                @endif
                                @if(isset($resolutionTime))
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Resolution Time:</span>
                                        <span class="text-blue-600">{{ $resolutionTime }} hours</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Tickets -->
                    @if(isset($relatedTickets) && $relatedTickets->count() > 0)
                        <div class="bg-white overflow-hidden shadow-md rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                    Related Tickets
                                </h3>
                                
                                <div class="space-y-2">
                                    @foreach($relatedTickets as $related)
                                        <a href="{{ route('admin.tickets.show', $related) }}" 
                                           class="block p-3 hover:bg-gray-50 rounded-lg transition duration-150">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">#{{ $related->id }} - {{ Str::limit($related->title, 40) }}</p>
                                                    <p class="text-xs text-gray-500">{{ $related->created_at->diffForHumans() }}</p>
                                                </div>
                                                <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$related->status] ?? 'bg-gray-100' }}">
                                                    {{ ucfirst($related->status) }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>