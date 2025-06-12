<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Event;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class DashboardController extends Controller
{
     public function index()
    {
        // Filters ke liye data
        // $projects = Project::all();
        // $sites = Site::all();

        // Widgets ke data
        $pendingActions = Event::where('status', 'pending')->count();
        $dailyReadiness = 92; // Ya calculate karke percentage nikaal lo
        $openEvents = Event::where('status', 'open')->count();
        $upcomingAudits = Audit::whereBetween('date', [now(), now()->addDays(7)])->count();

        // Charts ke data (dummy structure, aap apne logic ke hisaab se fill karo)
        $chartData = [
            'pending_actions' => [5, 4, 3, 6, 7, 2, 1],
            'daily_readiness' => [88, 90, 92, 93, 91, 95, 92],
            'open_events' => [2, 1, 3, 2, 4, 2, 3],
            'upcoming_audits' => [0, 1, 0, 2, 0, 1, 1],
            'events_status' => [
                'open' => 3,
                'closed' => 10,
                'in_progress' => 5
            ],
        ];

        return view('dashboard', compact(
            'projects',
            'sites',
            'pendingActions',
            'dailyReadiness',
            'openEvents',
            'upcomingAudits',
            'chartData'
        ));
    }
}
