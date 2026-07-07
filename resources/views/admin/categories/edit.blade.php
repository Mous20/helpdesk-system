<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Category: {{ $category->name }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" 
               class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Warning Messages -->
            @if($category->tickets_count ?? 0 > 0)
                <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="font-medium">Warning: Category has associated tickets</p>
                            <p class="text-sm mt-1">
                                This category is currently used by {{ $category->tickets_count }} ticket(s). 
                                Changing the name won't affect existing tickets, but consider creating a new category instead.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6">
                    @csrf
                    @method('PATCH')

                    <!-- Category Info Card -->
                    <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <span class="text-gray-600">Category ID:</span>
                                <span class="font-mono text-gray-800 ml-2">#{{ $category->id }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Created:</span>
                                <span class="text-gray-800 ml-2">{{ $category->created_at->format('F d, Y g:i A') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Last Updated:</span>
                                <span class="text-gray-800 ml-2">{{ $category->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Name Field -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name"
                               name="name" 
                               value="{{ old('name', $category->name) }}" 
                               placeholder="e.g., Technical Support, Billing, General Inquiry"
                               class="w-full border rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @else border-gray-300 @enderror"
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
                        
                        <div class="mt-2 flex items-center space-x-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 transition-all duration-300" 
                                     style="width: {{ min(100, (strlen(old('name', $category->name)) / 50) * 100) }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500" id="char-count">
                                {{ strlen(old('name', $category->name)) }}/100
                            </span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">
                            Enter a unique name for the category (max 100 characters).
                        </p>
                    </div>

                    <!-- Description Field -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description" 
                                  rows="6" 
                                  placeholder="Describe what types of issues this category covers..."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                        
                        @error('description')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <div class="mt-2 flex justify-between items-center">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden mr-2">
                                <div class="h-full bg-green-500 transition-all duration-300" 
                                     style="width: {{ min(100, (strlen(old('description', $category->description)) / 500) * 100) }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500" id="desc-char-count">
                                {{ strlen(old('description', $category->description)) }}/500
                            </span>
                        </div>
                        <p class="text-gray-500 text-xs mt-1">
                            Provide a brief description of what this category is for (max 500 characters, optional but recommended).
                        </p>
                    </div>

                    <!-- Live Preview Section -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Live Preview</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900" id="preview-name">{{ $category->name }}</div>
                                    <div class="text-xs text-gray-500" id="preview-description">{{ $category->description ?: 'No description provided' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Update Category
                                </div>
                            </button>
                            
                            <a href="{{ route('admin.categories.index') }}" 
                               class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition duration-200">
                                Cancel
                            </a>
                        </div>
                        
                        @if($category->tickets_count ?? 0 === 0)
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Category
                                    </div>
                                </button>
                            </form>
                        @endif
                    </div>
                    
                </form>
                
            </div>
            
            <!-- Help Section -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tips for editing categories:
                </h3>
                <ul class="text-sm text-blue-700 space-y-1 ml-7">
                    <li>• Keep category names consistent with your support structure</li>
                    <li>• Updating a category name will affect future ticket creation</li>
                    <li>• Existing tickets will retain their original category assignment</li>
                    <li>• Consider archiving instead of deleting if category has many tickets</li>
                </ul>
            </div>
            
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
    // Live preview for category name and description
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const previewName = document.getElementById('preview-name');
    const previewDesc = document.getElementById('preview-description');
    const charCount = document.getElementById('char-count');
    const descCharCount = document.getElementById('desc-char-count');
    const nameProgressBar = document.querySelector('#name').closest('.mb-6').querySelector('.h-full');
    const descProgressBar = document.querySelector('#description').closest('.mb-6').querySelector('.h-full');
    
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            // Update preview
            if (previewName) {
                previewName.textContent = this.value || '{{ $category->name }}';
            }
            
            // Update character counter
            if (charCount) {
                const length = this.value.length;
                charCount.textContent = `${length}/100`;
                
                // Update progress bar
                const percentage = Math.min(100, (length / 100) * 100);
                if (nameProgressBar) {
                    nameProgressBar.style.width = `${percentage}%`;
                    if (length > 90) {
                        nameProgressBar.classList.add('bg-red-500');
                        nameProgressBar.classList.remove('bg-blue-500');
                    } else {
                        nameProgressBar.classList.add('bg-blue-500');
                        nameProgressBar.classList.remove('bg-red-500');
                    }
                }
                
                // Change color when接近 limit
                if (length > 90) {
                    charCount.classList.add('text-red-600');
                } else {
                    charCount.classList.remove('text-red-600');
                }
            }
        });
    }
    
    if (descInput) {
        descInput.addEventListener('input', function() {
            // Update preview
            if (previewDesc) {
                previewDesc.textContent = this.value || 'No description provided';
            }
            
            // Update character counter
            if (descCharCount) {
                const length = this.value.length;
                descCharCount.textContent = `${length}/500`;
                
                // Update progress bar
                const percentage = Math.min(100, (length / 500) * 100);
                if (descProgressBar) {
                    descProgressBar.style.width = `${percentage}%`;
                    if (length > 450) {
                        descProgressBar.classList.add('bg-red-500');
                        descProgressBar.classList.remove('bg-green-500');
                    } else {
                        descProgressBar.classList.add('bg-green-500');
                        descProgressBar.classList.remove('bg-red-500');
                    }
                }
                
                // Change color when接近 limit
                if (length > 450) {
                    descCharCount.classList.add('text-red-600');
                } else {
                    descCharCount.classList.remove('text-red-600');
                }
            }
        });
    }
</script>
@endpush