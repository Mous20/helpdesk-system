<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create New Ticket
            </h2>
            <a href="{{ route('tickets.index') }}" 
               class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Tickets
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-medium">Please fix the following errors:</p>
                            <ul class="list-disc list-inside text-sm mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="p-6">
                    
                    <!-- Form Header -->
                    <div class="mb-6 pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Ticket Information</h3>
                        <p class="text-sm text-gray-500 mt-1">Fill in the details below to create a new support ticket</p>
                    </div>

                    <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-5">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20h10M7 4h10M7 4v16M17 4v16M3 8h2m-2 4h2m-2 4h2M19 8h2m-2 4h2m-2 4h2M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                                <input type="text"
                                       id="title"
                                       name="title"
                                       value="{{ old('title') }}"
                                       placeholder="Brief summary of your issue"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('title') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Use a clear and descriptive title (max 255 characters)</p>
                        </div>

                        <!-- Description -->
                        <div class="mb-5">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="6"
                                      placeholder="Please provide detailed information about your issue..."
                                      class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('description') border-red-500 @enderror"
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-gray-500">Include steps to reproduce, expected behavior, and screenshots if possible</p>
                                <span class="text-xs text-gray-400" id="charCount">0 characters</span>
                            </div>
                        </div>

                        <!-- Priority & Category Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                    Priority <span class="text-red-500">*</span>
                                </label>
                                <select id="priority"
                                        name="priority"
                                        class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('priority') border-red-500 @enderror"
                                        required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low - Normal request</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🔵 Medium - Important</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🟠 High - Urgent</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>🔴 Urgent - Critical issue</option>
                                </select>
                                @error('priority')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id"
                                        name="category_id"
                                        class="w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 @error('category_id') border-red-500 @enderror"
                                        required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Attachment -->
                        <div class="mb-6">
                            <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                                Attachment (Optional)
                            </label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition duration-150">
                                <input type="file"
                                       id="attachment"
                                       name="attachment"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       accept="image/*, .pdf, .doc, .docx, .txt">
                                <div class="space-y-2">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium text-blue-600 hover:text-blue-500">Click to upload</span>
                                        <span class="text-gray-500"> or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PNG, JPG, PDF, DOC up to 2MB
                                    </p>
                                </div>
                            </div>
                            <div id="fileName" class="mt-2 text-sm text-gray-600 hidden">
                                <span class="font-medium">Selected file:</span> <span id="selectedFileName"></span>
                            </div>
                            @error('attachment')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Ticket
                                    </div>
                                </button>
                                
                                <a href="{{ route('tickets.index') }}" 
                                   class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition duration-200">
                                    Cancel
                                </a>
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                <span class="text-red-500">*</span> Required fields
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
            
            <!-- Tips Section -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-blue-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tips for creating an effective ticket:
                </h3>
                <ul class="text-sm text-blue-700 space-y-1 ml-7">
                    <li>• Be specific and provide as much detail as possible</li>
                    <li>• Include steps to reproduce the issue</li>
                    <li>• Attach screenshots or error messages if available</li>
                    <li>• Choose the appropriate priority level</li>
                    <li>• Select the correct category for faster response</li>
                </ul>
            </div>
            
        </div>
    </div>
    
    @push('scripts')
    <script>
        // Character counter for description
        const description = document.getElementById('description');
        const charCount = document.getElementById('charCount');
        
        if (description && charCount) {
            function updateCharCount() {
                const length = description.value.length;
                charCount.textContent = length + ' characters';
                if (length > 1000) {
                    charCount.classList.add('text-red-500');
                    charCount.classList.remove('text-gray-400');
                } else {
                    charCount.classList.remove('text-red-500');
                    charCount.classList.add('text-gray-400');
                }
            }
            
            description.addEventListener('input', updateCharCount);
            updateCharCount();
        }
        
        // File name display
        const fileInput = document.getElementById('attachment');
        const fileNameDiv = document.getElementById('fileName');
        const selectedFileName = document.getElementById('selectedFileName');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    selectedFileName.textContent = this.files[0].name;
                    fileNameDiv.classList.remove('hidden');
                } else {
                    fileNameDiv.classList.add('hidden');
                }
            });
        }
    </script>
    @endpush
</x-app-layout>