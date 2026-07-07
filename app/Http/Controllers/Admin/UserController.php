<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users with search, filter, and sorting.
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $allowedSorts = ['name', 'email', 'role', 'created_at'];
        
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }
        
        $users = $query->paginate(15);
        
        // Statistics for dashboard cards
        $stats = [
            'total' => User::count(),
            'users' => User::where('role', 'user')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for editing user role.
     */
    public function edit(User $user)
    {
        // Prevent editing your own role
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot edit your own role.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the user's role.
     */
    public function update(Request $request, User $user)
{
    // SAFETY CHECK: Prevent any DELETE operation
    if ($request->isMethod('delete') || $request->input('_method') === 'DELETE') {
        abort(403, 'Delete operations are not allowed through the update method.');
    }
    
    // Log the request details
    \Log::info('Update request received', [
        'method' => $request->method(),
        'real_method' => $request->getRealMethod(),
        'input_method' => $request->input('_method'),
        'url' => $request->fullUrl(),
        'ip' => $request->ip(),
        'user_id' => $user->id,
        'request_data' => $request->except(['_token', '_method'])
    ]);
    
    // Check if user exists
    if (!$user) {
        \Log::error('User not found for update');
        return redirect()->route('admin.users.index')
            ->with('error', 'User not found.');
    }
    
    // Prevent changing your own role
    if ($user->id === auth()->id()) {
        \Log::warning('Self-role change attempt', ['user_id' => $user->id]);
        return redirect()->route('admin.users.index')
            ->with('error', 'You cannot change your own role.');
    }
    
    // Validate role
    $validRoles = ['user', 'agent', 'admin'];
    $newRole = $request->input('role');
    
    if (!in_array($newRole, $validRoles)) {
        \Log::error('Invalid role provided', ['role' => $newRole]);
        return redirect()->route('admin.users.index')
            ->with('error', 'Invalid role selected.');
    }
    
    $oldRole = $user->role;
    
    // Perform update with explicit column
    try {
        $user->role = $newRole;
        $saved = $user->save();
        
        if (!$saved) {
            throw new \Exception('Failed to save user');
        }
        
        \Log::info('User role updated successfully', [
            'user_id' => $user->id,
            'old_role' => $oldRole,
            'new_role' => $user->role
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error updating user role: ' . $e->getMessage());
        return redirect()->route('admin.users.index')
            ->with('error', 'Database error: ' . $e->getMessage());
    }
    
    // Verify the update
    $user->refresh();
    if ($user->role !== $newRole) {
        \Log::error('Role verification failed', [
            'expected' => $newRole,
            'actual' => $user->role
        ]);
    }
    
    $roleLabels = [
        'user' => 'Customer',
        'agent' => 'Support Agent',
        'admin' => 'Administrator',
    ];
    
    return redirect()
        ->route('admin.users.index')
        ->with('success', sprintf(
            "User '%s' role changed from %s to %s successfully.",
            $user->name,
            $roleLabels[$oldRole] ?? ucfirst($oldRole),
            $roleLabels[$newRole] ?? ucfirst($newRole)
        ));
}

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }
        
        // Prevent deleting the last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete the last administrator. Please assign admin role to another user first.');
        }
        
        $userName = $user->name;
        $user->delete();
        
        return redirect()
            ->route('admin.users.index')
            ->with('success', "User '{$userName}' has been deleted successfully.");
    }
    
    /**
     * Get user statistics (for AJAX calls)
     */
    public function getStats()
    {
        $stats = [
            'total' => User::count(),
            'users' => User::where('role', 'user')->count(),
            'agents' => User::where('role', 'agent')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'new_today' => User::whereDate('created_at', today())->count(),
            'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        
        return response()->json($stats);
    }

    public function debugRoutes()
{
    $routes = \Route::getRoutes();
    $userRoutes = [];
    
    foreach ($routes as $route) {
        if (str_contains($route->uri(), 'users')) {
            $userRoutes[] = [
                'uri' => $route->uri(),
                'methods' => $route->methods(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        }
    }
    
    return response()->json($userRoutes);
}
}