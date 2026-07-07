<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit User Role: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" 
               class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    
                    <!-- User Info Card -->
                    <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <span class="text-white font-semibold text-xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                <p class="text-xs text-gray-400 mt-1">Joined: {{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- UPDATE FORM -->
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Current Role
                            </label>
                            <div class="mb-4">
                                @php
                                    $roleLabels = [
                                        'user' => '👤 Customer',
                                        'agent' => '⭐ Support Agent',
                                        'admin' => '👑 Administrator',
                                    ];
                                    $roleDescriptions = [
                                        'user' => 'Can create and manage their own tickets',
                                        'agent' => 'Can view assigned tickets and reply to customers',
                                        'admin' => 'Full access to manage users, categories, and all tickets',
                                    ];
                                @endphp
                                <div class="text-sm text-gray-900 mb-2">
                                    Current: <span class="font-semibold">{{ $roleLabels[$user->role] ?? ucfirst($user->role) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                New Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role" 
                                    id="role"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('role') border-red-500 @enderror"
                                    required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>👤 Customer</option>
                                <option value="agent" {{ old('role', $user->role) == 'agent' ? 'selected' : '' }}>⭐ Support Agent</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                            </select>
                            
                            @error('role')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            
                            <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-800" id="role-description">
                                    {{ $roleDescriptions[$user->role] ?? 'Select a role to see permissions' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center pt-4 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                                    Update Role
                                </button>
                                
                                <a href="{{ route('admin.users.index') }}" 
                                   class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition duration-200">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                    <!-- END OF UPDATE FORM -->
                    
                    <!-- DELETE FORM - SEPARATE, OUTSIDE THE UPDATE FORM -->
                    @if($user->id !== auth()->id())
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-200">
                                    Delete User
                                </button>
                            </form>
                        </div>
                    @endif
                    
                </div>
            </div>
            
            <!-- User Activity Summary -->
            <div class="mt-6 bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">User Activity Summary</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ $user->tickets_count ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Tickets Created</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600">{{ $user->replies_count ?? 0 }}</p>
                            <p class="text-sm text-gray-600">Replies Sent</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    // Update role description when selection changes
    const roleSelect = document.getElementById('role');
    const roleDescription = document.getElementById('role-description');
    
    const descriptions = {
        'user': '👤 Can create and manage their own tickets only',
        'agent': '⭐ Can view assigned tickets, reply to customers, and update ticket status',
        'admin': '👑 Full access: manage users, categories, all tickets, and system settings'
    };
    
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            roleDescription.textContent = descriptions[this.value] || 'Select a role to see permissions';
        });
    }
</script>
@endpush