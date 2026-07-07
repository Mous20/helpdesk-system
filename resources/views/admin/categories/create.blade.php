<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Category
            </h2>
            <a href="{{ route('admin.categories.index') }}" 
               class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200">
                Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                
                <form method="POST" action="{{ route('admin.categories.store') }}" class="p-6">
                    @csrf

                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name"
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="e.g., Technical Support, Billing, General Inquiry"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                               required 
                               autofocus>
                        
                        @error('name')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <p class="text-gray-500 text-xs mt-1">
                            Enter a unique name for the category. This will be visible to users when creating tickets.
                        </p>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description" 
                                  rows="5" 
                                  placeholder="Describe what types of issues this category covers..."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        
                        @error('description')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <p class="text-gray-500 text-xs mt-1">
                            Provide a brief description of what this category is for (optional but recommended).
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Category
                            </div>
                        </button>
                        
                        <button type="reset" 
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition duration-200">
                            Reset Form
                        </button>
                    </div>
                </form>
                
                <!-- Tips Section -->
                <div class="bg-gray-50 p-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">💡 Tips for creating categories:</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Use clear, descriptive names that users can easily understand
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create categories based on common support issues
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Keep category names concise (1-3 words)
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Add helpful descriptions to guide users to the right category
                        </li>
                    </ul>
                </div>
                
            </div>
            
        </div>
    </div>
</x-app-layout>
@push('scripts')
<script>
    // Live preview for category name and description
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            // You can add real-time validation or preview here
            const preview = document.getElementById('name-preview');
            if (preview) {
                preview.textContent = this.value || 'Category Name';
            }
        });
    }
    
    // Character counter for description
    if (descInput) {
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 mt-1';
        counter.id = 'char-counter';
        descInput.parentNode.appendChild(counter);
        
        const updateCounter = () => {
            const length = descInput.value.length;
            counter.textContent = `${length} characters (recommended: 100-500)`;
            if (length > 500) {
                counter.classList.add('text-yellow-600');
            } else {
                counter.classList.remove('text-yellow-600');
            }
        };
        
        descInput.addEventListener('input', updateCounter);
        updateCounter();
    }
</script>
@endpush