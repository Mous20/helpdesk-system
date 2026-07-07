<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket Details: #{{ $ticket->id }} - {{ Str::limit($ticket->title, 50) }}
            </h2>
            <a href="{{ route('agent.tickets.index') }}" 
               class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Tickets
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6">
                    
                    <!-- Ticket Header with Status and Priority -->
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $ticket->title }}</h2>
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
                    
                    <!-- Ticket Information Grid -->
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
                                    <p class="text-sm font-medium text-gray-900">{{ $ticket->user->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-500">{{ $ticket->user->email ?? 'No email' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-gray-500">Category</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-gray-500">Created</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket->created_at->format('F d, Y g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        
                        <div class="border rounded-lg p-4">
                            <p class="text-sm text-gray-500">Last Updated</p>
                            <p class="text-sm font-medium text-gray-900 mt-1">{{ $ticket->updated_at->format('F d, Y g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-700 whitespace-pre-wrap">{{ $ticket->description }}</p>
                        </div>
                    </div>
                    
                    <!-- Status Update Section -->
                    <div class="mb-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Update Status
                        </h3>
                        <form method="POST" action="{{ route('agent.tickets.status', $ticket) }}" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>🟡 Open</option>
                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>🟢 Resolved</option>
                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>⚫ Closed</option>
                            </select>
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                                Update Status
                            </button>
                        </form>
                    </div>
                    
                    <!-- Status History Section -->
                    @if($ticket->statusLogs && $ticket->statusLogs->count() > 0)
                        <div class="mb-6 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status History
                            </h3>
                            <div class="space-y-2">
                                @foreach($ticket->statusLogs as $log)
                                    <div class="border rounded-lg p-3 bg-gray-50">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-sm">
                                                    <strong>{{ ucfirst($log->old_status) }}</strong>
                                                    → 
                                                    <strong>{{ ucfirst($log->new_status) }}</strong>
                                                </span>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-500">
                                                    By {{ $log->changedBy->name ?? 'Unknown' }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ $log->created_at->format('M d, Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Replies Section -->
                    <div class="mb-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Conversation ({{ $ticket->replies->count() }} replies)
                        </h3>
                        
                        @forelse($ticket->replies as $reply)
                            <div class="border rounded-lg p-4 mb-4 {{ $reply->user_id === $ticket->user_id ? 'bg-gray-50' : 'bg-blue-50' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 rounded-full {{ $reply->user_id === $ticket->user_id ? 'bg-gray-400' : 'bg-blue-500' }} flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">
                                                {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-2">
                                            <p class="text-sm font-medium text-gray-900">{{ $reply->user->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">{{ $reply->created_at->format('M d, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                    @if($reply->user_id === $ticket->user_id)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Customer</span>
                                    @else
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Agent</span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mt-2">{{ $reply->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-gray-500">No replies yet. Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Add Reply Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Add Reply
                        </h3>
                        <form method="POST" action="{{ route('tickets.replies.store', $ticket) }}">
                            @csrf
                            <textarea name="message" 
                                      rows="4" 
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('message') border-red-500 @enderror" 
                                      placeholder="Write your response to the user..."
                                      required>{{ old('message') }}</textarea>
                            
                            @error('message')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            
                            <div class="flex justify-end mt-3">
                                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
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
    </div>
</x-app-layout>