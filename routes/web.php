<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\TicketAssignmentController;

use App\Http\Controllers\Agent\TicketController as AgentTicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect By Role
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'agent' => redirect()->route('agent.tickets.index'),
        default => redirect()->route('tickets.index'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Shared Ticket Reply Route
    |--------------------------------------------------------------------------
    */

    Route::post('/tickets/{ticket}/replies', [TicketReplyController::class, 'store'])
        ->name('tickets.replies.store');

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:user')->group(function () {
        Route::resource('tickets', TicketController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Agent Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:agent')
        ->prefix('agent')
        ->name('agent.')
        ->group(function () {
            Route::get('/tickets', [AgentTicketController::class, 'index'])
                ->name('tickets.index');
            Route::get('/tickets/{ticket}', [AgentTicketController::class, 'show'])
                ->name('tickets.show');
            Route::patch('/tickets/{ticket}/status', [AgentTicketController::class, 'updateStatus'])
                ->name('tickets.status');
        });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            
            Route::resource('categories', CategoryController::class);
            
            // IMPORTANT: Use AdminTicketController, not TicketController
            Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
            Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
            Route::patch('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.status');
            Route::patch('/tickets/{ticket}/priority', [AdminTicketController::class, 'updatePriority'])->name('tickets.priority');
            Route::patch('/tickets/{ticket}/category', [AdminTicketController::class, 'updateCategory'])->name('tickets.category');
            Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
            Route::post('/tickets/bulk-action', [AdminTicketController::class, 'bulkAction'])->name('tickets.bulk-action');
            Route::get('/tickets/export', [AdminTicketController::class, 'export'])->name('tickets.export');
            Route::get('/tickets/statistics', [AdminTicketController::class, 'getStatistics'])->name('tickets.statistics');
            
            Route::post('/tickets/{ticket}/assign', [TicketAssignmentController::class, 'store'])->name('tickets.assign');
            Route::resource('users', UserController::class)->except(['create', 'store', 'show']);
              Route::get('/tickets/export', [AdminTicketController::class, 'export'])
            ->name('tickets.export');
        });

    /*
    |--------------------------------------------------------------------------
    | Profile Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/debug-user-routes', [UserController::class, 'debugRoutes']);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';