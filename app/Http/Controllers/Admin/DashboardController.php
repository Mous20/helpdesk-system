<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ticket Statistics
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'open')->count();
        $inProgressTickets = Ticket::where('status', 'in_progress')->count();
        $resolvedTickets = Ticket::where('status', 'resolved')->count();
        $closedTickets = Ticket::where('status', 'closed')->count();
        
        // Priority Statistics
        $lowPriority = Ticket::where('priority', 'low')->count();
        $mediumPriority = Ticket::where('priority', 'medium')->count();
        $highPriority = Ticket::where('priority', 'high')->count();
        $urgentPriority = Ticket::where('priority', 'urgent')->count();
        
        // User Statistics
        $totalUsers = User::where('role', 'user')->count();
        $totalAgents = User::where('role', 'agent')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        // Recent Tickets with relationships
        $recentTickets = Ticket::with(['user', 'category', 'assignedAgent'])
            ->latest()
            ->limit(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'closedTickets',
            'lowPriority',
            'mediumPriority',
            'highPriority',
            'urgentPriority',
            'totalUsers',
            'totalAgents',
            'totalAdmins',
            'recentTickets'
        ));
    }
}