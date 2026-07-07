<aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white flex-shrink-0 shadow-xl" 
       aria-label="Sidebar">
    <div class="h-full flex flex-col">
        
        <!-- Logo / Brand -->
        <div class="p-5 border-b border-gray-700">
            <h2 class="text-2xl font-bold tracking-tight">
                <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors duration-200">
                    HelpDesk
                </a>
            </h2>
            <p class="text-xs text-gray-400 mt-1">Support Ticket System</p>
        </div>
        
        <!-- Navigation Links -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto" aria-label="Main navigation">
            
            <!-- Dashboard - Redirects based on role -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
                Dashboard
            </x-nav-link>
            
            <!-- Admin Section -->
            @if(auth()->user()->role === 'admin')
                <div class="pt-4 mt-2">
                    <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Administration
                    </h3>
                    <div class="mt-2 space-y-1">
                        <x-nav-link :href="route('admin.dashboard')" 
                                    :active="request()->routeIs('admin.dashboard')"
                                    icon="admin-dashboard">
                            Admin Dashboard
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.tickets.index')" 
                                    :active="request()->routeIs('admin.tickets.*')"
                                    icon="tickets">
                            All Tickets
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.categories.index')" 
                                    :active="request()->routeIs('admin.categories.*')"
                                    icon="categories">
                            Categories
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.users.index')" 
                                    :active="request()->routeIs('admin.users.*')"
                                    icon="users">
                            Users
                        </x-nav-link>
                    </div>
                </div>
            @endif
            
            <!-- Agent Section -->
            @if(auth()->user()->role === 'agent')
                <div class="pt-4 mt-2">
                    <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Agent Panel
                    </h3>
                    <div class="mt-2 space-y-1">
                        <x-nav-link :href="route('agent.tickets.index')" 
                                    :active="request()->routeIs('agent.tickets.*')"
                                    icon="assigned">
                            Assigned Tickets
                        </x-nav-link>
                    </div>
                </div>
            @endif
            
            <!-- User Section -->
            @if(auth()->user()->role === 'user')
                <div class="pt-4 mt-2">
                    <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        My Support
                    </h3>
                    <div class="mt-2 space-y-1">
                        <x-nav-link :href="route('tickets.index')" 
                                    :active="request()->routeIs('tickets.*')"
                                    icon="my-tickets">
                            My Tickets
                        </x-nav-link>
                        
                        <x-nav-link :href="route('tickets.create')" 
                                    :active="request()->routeIs('tickets.create')"
                                    icon="new-ticket">
                            Create New Ticket
                        </x-nav-link>
                    </div>
                </div>
            @endif
            
            <!-- Profile Section (Common for all roles) -->
            <div class="pt-4 mt-2 border-t border-gray-700">
                <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Account
                </h3>
                <div class="mt-2 space-y-1">
                    <x-nav-link :href="route('profile.edit')" 
                                :active="request()->routeIs('profile.*')"
                                icon="profile">
                        Profile Settings
                    </x-nav-link>
                </div>
            </div>
            
        </nav>
        
        <!-- Sidebar Footer with User Info & Logout -->
        <div class="border-t border-gray-700 p-4">
            <div class="mb-3 pb-3 border-b border-gray-700">
                <p class="text-sm font-medium text-gray-200">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-400 mt-1">
                    <span class="capitalize">{{ auth()->user()->role }}</span>
                </p>
                <p class="text-xs text-gray-500 mt-1">{{ auth()->user()->email }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
        
    </div>
</aside>