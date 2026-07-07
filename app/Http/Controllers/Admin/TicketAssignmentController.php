<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketAssignmentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);
        
        $agent = User::find($request->assigned_to);
        
        // Update both ID and email for redundancy
        $ticket->update([
            'assigned_agent_id' => $agent->id,
            'agent_email' => $agent->email
        ]);
        
        return redirect()->back()->with('success', 
            "Ticket #{$ticket->id} assigned to {$agent->name} ({$agent->email})"
        );
    }
    
    // Method to unassign ticket
    public function destroy(Ticket $ticket)
    {
        $ticket->update([
            'assigned_agent_id' => null,
            'agent_email' => null
        ]);
        
        return redirect()->back()->with('success', 'Ticket unassigned successfully.');
    }
}