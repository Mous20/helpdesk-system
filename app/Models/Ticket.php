<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'assigned_agent_id',
        'agent_email',
        'category_id',
        'status',
        'priority',
    ];

    // Relationship with User (creator of the ticket)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with Assigned Agent
    public function assignedAgent()
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    // Relationship with Replies
    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    // Relationship with Attachments
    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }
    
    // Relationship with Status Logs - ADD THIS
    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class);
    }
    
    // Helper method to get agent name safely
    public function getAgentNameAttribute()
    {
        if ($this->assignedAgent) {
            return $this->assignedAgent->name;
        }
        
        if ($this->agent_email) {
            $user = User::where('email', $this->agent_email)->first();
            return $user ? $user->name : $this->agent_email;
        }
        
        return 'Not assigned';
    }
    
    // Helper method to get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'open' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    
    // Helper method to get priority badge class
    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            'low' => 'bg-gray-100 text-gray-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}