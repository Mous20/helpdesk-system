<?php

namespace App\Http\Controllers\Admin;

use App\Models\TicketAttachment;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of tickets with filters and sorting.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'assignedAgent']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
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
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Sorting
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        
        // Allowed sortable columns
        $allowedSorts = ['id', 'title', 'status', 'priority', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }
        
        $tickets = $query->paginate(15);
        
        // Statistics for the dashboard cards
        $stats = [
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'high_priority' => Ticket::where('priority', 'high')->orWhere('priority', 'urgent')->count(),
            'unassigned' => Ticket::whereNull('assigned_agent_id')->count(),
        ];
        
        $categories = Category::all();
        
        return view('admin.tickets.index', compact('tickets', 'stats', 'categories'));
    }

    /**
     * Display the specified ticket with all details.
     */
   public function show(Ticket $ticket)
{
    // Authorization check
    if (auth()->user()->role !== 'admin') {
        abort(403, 'You do not have permission to view this ticket.');
    }
    
    // Load all relationships with proper error handling
    $ticket->load([
        'user', 
        'category', 
        'assignedAgent', 
        'replies' => function($query) {
            $query->with('user')->latest(); // 'latest()' to show newest replies first
        },
        'attachments'
    ]);
    
    // Get all agents for assignment dropdown
    $agents = User::where('role', 'agent')
                 ->orderBy('name')
                 ->get(['id', 'name', 'email']);
    
    // Get all available categories for editing (if you want to allow category change)
    $categories = Category::orderBy('name')->get();
    
    // Get related tickets from same user (excluding current ticket)
    $relatedTickets = Ticket::where('user_id', $ticket->user_id)
                           ->where('id', '!=', $ticket->id)
                           ->latest()
                           ->limit(5)
                           ->get(['id', 'title', 'status', 'created_at']);
    
    // Calculate response time (time until first agent reply)
    $responseTime = null;
    $firstReply = $ticket->replies()->where('user_id', '!=', $ticket->user_id)->first();
    if ($firstReply) {
        $responseTime = $ticket->created_at->diffInHours($firstReply->created_at);
    }
    
    // Calculate resolution time (total time to resolve/close)
    $resolutionTime = null;
    if (in_array($ticket->status, ['resolved', 'closed'])) {
        $resolutionTime = $ticket->created_at->diffInHours($ticket->updated_at);
    }
    
    return view('admin.tickets.show', compact(
        'ticket', 
        'agents', 
        'categories',
        'relatedTickets',
        'responseTime',
        'resolutionTime'
    ));
}
    /**
     * Update ticket status (called from AJAX or form)
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);
        
        $oldStatus = $ticket->status;
        $ticket->update(['status' => $request->status]);
        
        $message = "Ticket status changed from " . ucfirst($oldStatus) . " to " . ucfirst($request->status);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $ticket->status
            ]);
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Update ticket priority
     */
    public function updatePriority(Request $request, Ticket $ticket)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);
        
        $oldPriority = $ticket->priority;
        $ticket->update(['priority' => $request->priority]);
        
        return redirect()->back()->with('success', 
            "Ticket priority changed from " . ucfirst($oldPriority) . " to " . ucfirst($request->priority)
        );
    }

    /**
     * Update ticket category
     */
    public function updateCategory(Request $request, Ticket $ticket)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $ticket->update(['category_id' => $request->category_id]);
        
        $category = Category::find($request->category_id);
        
        return redirect()->back()->with('success', 
            "Ticket category updated to " . $category->name
        );
    }

    /**
     * Delete a ticket (admin only)
     */
    public function destroy(Ticket $ticket)
    {
        // Delete associated attachments first
        foreach ($ticket->attachments as $attachment) {
            // Delete file from storage
            \Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }
        
        // Delete all replies
        $ticket->replies()->delete();
        
        // Delete the ticket
        $ticket->delete();
        
        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket #' . $ticket->id . ' has been deleted successfully.');
    }

    /**
     * Bulk action for tickets
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'tickets' => 'required|array',
            'tickets.*' => 'exists:tickets,id',
            'action' => 'required|in:delete,resolved,closed,in_progress',
        ]);
        
        $tickets = Ticket::whereIn('id', $request->tickets);
        
        if ($request->action === 'delete') {
            $count = $tickets->count();
            foreach ($tickets->get() as $ticket) {
                // Delete attachments for each ticket
                foreach ($ticket->attachments as $attachment) {
                    \Storage::disk('public')->delete($attachment->file_path);
                }
            }
            $tickets->delete();
            $message = $count . ' tickets deleted successfully.';
        } else {
            $count = $tickets->update(['status' => $request->action]);
            $message = $count . ' tickets updated to ' . ucfirst(str_replace('_', ' ', $request->action)) . ' status.';
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Export tickets to CSV
     */
    public function export(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'assignedAgent']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        $tickets = $query->get();
        
        $fileName = 'tickets_export_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
        
        $callback = function() use ($tickets) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Title', 'User', 'Category', 'Status', 'Priority', 'Agent', 'Created Date', 'Last Updated']);
            
            // Add rows
            foreach ($tickets as $ticket) {
                fputcsv($file, [
                    $ticket->id,
                    $ticket->title,
                    $ticket->user->name ?? 'N/A',
                    $ticket->category->name ?? 'N/A',
                    $ticket->status,
                    $ticket->priority,
                    $ticket->assignedAgent->name ?? 'Unassigned',
                    $ticket->created_at->format('Y-m-d H:i:s'),
                    $ticket->updated_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get ticket statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'high_priority' => Ticket::where('priority', 'high')->orWhere('priority', 'urgent')->count(),
            'unassigned' => Ticket::whereNull('assigned_agent_id')->count(),
            'by_priority' => [
                'low' => Ticket::where('priority', 'low')->count(),
                'medium' => Ticket::where('priority', 'medium')->count(),
                'high' => Ticket::where('priority', 'high')->count(),
                'urgent' => Ticket::where('priority', 'urgent')->count(),
            ],
            'by_category' => Category::withCount('tickets')->get()->map(function($category) {
                return [
                    'name' => $category->name,
                    'count' => $category->tickets_count
                ];
            }),
        ];
        
        return response()->json($stats);
    }
}