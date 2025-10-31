<?php

namespace App\Http\Controllers;

use App\Models\ScheduledActivity;
use App\Models\MaintenanceRequest;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Estadísticas para el dashboard
        $stats = [
            'asset_count' => Asset::count(),
            'pending_activities' => ScheduledActivity::where('status', 'pending')->count(),
            'completed_activities' => ScheduledActivity::where('status', 'completed')->count(),
            'urgent_activities' => ScheduledActivity::where('priority', 'urgent')
                ->where('status', 'pending')
                ->count(),
            'maintenance_requests' => MaintenanceRequest::where('estado', 'Pendiente')->count(),
            'users_count' => User::count(),
        ];

        // Actividades próximas para el usuario
        $upcomingActivities = ScheduledActivity::with(['assignedUser', 'asset'])
            ->where('assigned_to', $user->id)
            ->where('status', 'pending')
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        // Actividades urgentes
        $urgentActivities = ScheduledActivity::with(['assignedUser', 'asset'])
            ->where('status', 'pending')
            ->where('priority', 'urgent')
            ->where('start_date', '<=', now()->addDays(1))
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'upcomingActivities', 
            'urgentActivities', 
            'stats'
        ));
    }
}