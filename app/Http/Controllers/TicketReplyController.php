<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        // Check if user has permission to reply to this ticket
        $user = Auth::user();
        
        // Check permissions based on role
        $canReply = false;
        
        if ($user->role === 'admin') {
            // Admin can reply to any ticket
            $canReply = true;
        } 
        elseif ($user->role === 'agent') {
            // Agent can only reply to tickets assigned to them
            $canReply = ($ticket->assigned_agent_id == $user->id || $ticket->agent_email == $user->email);
        } 
        elseif ($user->role === 'user') {
            // User can only reply to their own tickets
            $canReply = ($ticket->user_id == $user->id);
        }
        
        if (!$canReply) {
            abort(403, 'You do not have permission to reply to this ticket.');
        }
        
        // Validate the request
        $request->validate([
            'message' => 'required|string|min:1|max:5000',
        ]);
        
        // Create the reply
        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);
        
        // Update ticket status if it was closed
        if ($ticket->status === 'closed') {
            $ticket->update(['status' => 'open']);
        }
        
        return redirect()->back()->with('success', 'Reply sent successfully.');
    }
}