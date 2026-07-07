<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /*
    |--------------------------------------------------------------------------
    | VIEW ANY
    |--------------------------------------------------------------------------
    */

    public function viewAny(User $user): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */

    public function view(User $user, Ticket $ticket): bool
    {
        // Admin can view all tickets
        if ($user->role === 'admin') {
            return true;
        }

        // User can view his own ticket
        if ($ticket->user_id === $user->id) {
            return true;
        }

        // Agent can view assigned ticket
        if ($ticket->assigned_to === $user->id) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(User $user): bool
    {
        return $user->role === 'user';
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(User $user, Ticket $ticket): bool
    {
        // Admin
        if ($user->role === 'admin') {
            return true;
        }

        // Assigned Agent
        if ($ticket->assigned_to === $user->id) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->role === 'admin';
    }
}