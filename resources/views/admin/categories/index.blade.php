<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories Management
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.categories.create') }}"
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Category
                </a>
            </div>
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

            <!-- Search and Filter Section -->
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search categories by name or description..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.categories.index') }}" 
                               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition duration-200">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Categories Table -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <span>Name</span>
                                        <a href="{{ route('admin.categories.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                           class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tickets Count
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $category->name }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    ID: {{ $category->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-md">
                                            {{ $category->description ?: '—' }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $category->tickets_count ?? 0 }} tickets
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $category->created_at->format('M d, Y') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 transition duration-150 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete the category "{{ $category->name }}"? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 transition duration-150 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No categories found</h3>
                                            <p class="text-gray-500 mb-4">
                                                @if(request('search'))
                                                    No categories match your search criteria.
                                                @else
                                                    Get started by creating your first category.
                                                @endif
                                            </p>
                                            @if(!request('search'))
                                                <a href="{{ route('admin.categories.create') }}" 
                                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                                                    Create Category
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                        
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $categories->appends(request()->query())->links() }}
                    </div>
                @endif
                
            </div>
            
            <!-- Statistics Section -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Categories</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $categories->total() }}</p>
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
                            <p class="text-sm font-medium text-gray-500">Last Created</p>
                            <p class="text-sm text-gray-900">
                                {{ $categories->first() ? $categories->first()->created_at->diffForHumans() : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Quick Actions</p>
                            <a href="{{ route('admin.categories.create') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                + Create New Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>