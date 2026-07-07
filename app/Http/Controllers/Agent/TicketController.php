<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketStatusLog;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Get agent's email and ID
        $agentEmail = auth()->user()->email;
        $agentId = auth()->id();
        
        // Query tickets assigned to this agent (by ID OR email)
        $query = Ticket::where(function($q) use ($agentId, $agentEmail) {
                $q->where('assigned_agent_id', $agentId)
                  ->orWhere('agent_email', $agentEmail);
            })
            ->with(['user', 'category']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        // Order by priority and creation date
        $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')")
              ->latest();
        
        $tickets = $query->paginate(15);
        
        // Statistics
        $stats = [
            'open' => Ticket::where(function($q) use ($agentId, $agentEmail) {
                        $q->where('assigned_agent_id', $agentId)
                          ->orWhere('agent_email', $agentEmail);
                    })->where('status', 'open')->count(),
            'in_progress' => Ticket::where(function($q) use ($agentId, $agentEmail) {
                        $q->where('assigned_agent_id', $agentId)
                          ->orWhere('agent_email', $agentEmail);
                    })->where('status', 'in_progress')->count(),
            'resolved' => Ticket::where(function($q) use ($agentId, $agentEmail) {
                        $q->where('assigned_agent_id', $agentId)
                          ->orWhere('agent_email', $agentEmail);
                    })->where('status', 'resolved')->count(),
            'closed' => Ticket::where(function($q) use ($agentId, $agentEmail) {
                        $q->where('assigned_agent_id', $agentId)
                          ->orWhere('agent_email', $agentEmail);
                    })->where('status', 'closed')->count(),
        ];
        
        return view('agent.tickets.index', compact('tickets', 'stats'));
    }
    
    public function show(Ticket $ticket)
    {
        $agentEmail = auth()->user()->email;
        $agentId = auth()->id();
        
        // Check if ticket is assigned to this agent
        if ($ticket->assigned_agent_id != $agentId && $ticket->agent_email != $agentEmail) {
            abort(403, 'You do not have permission to view this ticket.');
        }
        
        $ticket->load(['user', 'category', 'replies.user', 'attachments', 'statusLogs.changedBy']);
        
        return view('agent.tickets.show', compact('ticket'));
    }
    
    // ADD THIS METHOD - Update Ticket Status
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $agentEmail = auth()->user()->email;
        $agentId = auth()->id();
        
        // Check if ticket is assigned to this agent
        if ($ticket->assigned_agent_id != $agentId && $ticket->agent_email != $agentEmail) {
            abort(403, 'You do not have permission to update this ticket.');
        }
        
        // Validate the request
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);
        
        // Store old status for logging
        $oldStatus = $ticket->status;
        
        // Update the ticket status
        $ticket->update([
            'status' => $request->status
        ]);
        
        // Log the status change if TicketStatusLog model exists
        if (class_exists(\App\Models\TicketStatusLog::class)) {
            \App\Models\TicketStatusLog::create([
                'ticket_id' => $ticket->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'changed_by' => auth()->id(),
            ]);
        }
        
        return redirect()->back()->with('success', 
            "Ticket status changed from " . ucfirst($oldStatus) . " to " . ucfirst($request->status)
        );
    }
}