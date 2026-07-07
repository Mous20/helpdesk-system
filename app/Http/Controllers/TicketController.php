<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;





class TicketController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Ticket::where('user_id', auth()->id())
        ->with(['category', 'assignedAgent']);
    
    // Search functionality
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
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
    
    $tickets = $query->latest()->paginate(10);
    
    // Statistics
    $stats = [
        'open' => Ticket::where('user_id', auth()->id())->where('status', 'open')->count(),
        'resolved' => Ticket::where('user_id', auth()->id())->where('status', 'resolved')->count(),
        'high_priority' => Ticket::where('user_id', auth()->id())
            ->whereIn('priority', ['high', 'urgent'])->count(),
    ];
    
    return view('tickets.index', compact('tickets', 'stats'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'priority' => 'required|in:low,medium,high,urgent',
        'category_id' => 'required|exists:categories,id',
    ]);

    $data['user_id'] = auth()->id();

    $data['status'] = 'open';

    Ticket::create($data);

    return redirect()
        ->route('tickets.index')
        ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(
            'category',
            'assignedAgent',
            'replies.user',
            'attachments'
        );

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}