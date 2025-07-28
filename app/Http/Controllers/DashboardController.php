<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Audit;
use App\Models\Event;
use App\Models\Action;
use Illuminate\Http\Request;
use App\Models\ReadinessForm;
use App\Models\TalkAnimation;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class DashboardController extends Controller
{
    public function index()
    {
        // Define the date range for the last 7 days
        $startDate = Carbon::today()->subDays(6)->startOfDay(); // 7 days ago
        $endDate = Carbon::today()->endOfDay(); // Today

        // Initialize arrays for chart data
        $pendingActions = [];
        $dailyReadiness = [];
        $openEvents = [];
        $upcomingAudits = [];
        $upcomingTalks = [];

        // Get all dates in the range for consistent data points
        $dateRange = collect([]);
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dateRange->push($date->format('Y-m-d'));
        }

        // Fetch Pending Actions (count of pending events per day)
        $pendingActionsData = Event::where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('DATE(created_at)')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->get()
            ->pluck('count', 'date');

        // Fill the array with counts, defaulting to 0 for days with no data
        foreach ($dateRange as $date) {
            $pendingActions[] = $pendingActionsData->get($date, 0);
        }

        // Fetch Daily Readiness (average readiness score per day)
       $dailyReadinessData = ReadinessForm::whereBetween('created_at', [$startDate, $endDate])
        ->groupByRaw('DATE(created_at)')
        ->selectRaw('DATE(created_at) as date, AVG(readiness_rate) as average')
        ->get()
        ->pluck('average', 'date');

        // Fill the array, defaulting to 0 for days with no data
        foreach ($dateRange as $date) {
            $dailyReadiness[] = round($dailyReadinessData->get($date, 0), 2);
        }

        // Fetch Open Events (count of non-completed events per day)
       $openEventsData = Event::whereIn('status', ['pending', 'processing'])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupByRaw('DATE(created_at)')
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->get()
        ->pluck('count', 'date');

        // Fill the array with counts, defaulting to 0
        foreach ($dateRange as $date) {
            $openEvents[] = $openEventsData->get($date, 0);
        }

        // Fetch Upcoming Audits/Talks (count of audits scheduled per day)
        $upcomingAuditsData = Audit::whereBetween('date', [$startDate, $endDate])
            ->groupByRaw('DATE(date)')
            ->selectRaw('DATE(date) as date, COUNT(*) as count')
            ->get()
            ->pluck('count', 'date');

        // Fill the array with counts, defaulting to 0
        foreach ($dateRange as $date) {
            $upcomingAudits[] = $upcomingAuditsData->get($date, 0);
        }


        // Fetch Upcoming Audits/Talks (count of audits scheduled per day)
        $upcomingTalksData = TalkAnimation::whereBetween('date', [$startDate, $endDate])
            ->groupByRaw('DATE(date)')
            ->selectRaw('DATE(date) as date, COUNT(*) as count')
            ->get()
            ->pluck('count', 'date');

        // Fill the array with counts, defaulting to 0
        foreach ($dateRange as $date) {
            $upcomingTalks[] = $upcomingTalksData->get($date, 0);
        }

        // Fetch Events Status (total counts for pending, completed, processing)
        $pendingEvents = Action::where(function ($query) {
            $query->whereNull('start_date')
                ->whereNull('end_date');
        })->count();

        $completedEvents = Action::where(function ($query) {
            $query->whereNotNull('start_date')
                ->whereNotNull('end_date');
        })->count();

        $processingEvents = Action::where(function ($query) {
            $query->whereNotNull('start_date')
                ->whereNull('end_date');
        })->count();

        // Widgets data
        $pendingActionsCount = $pendingEvents; // Total pending actions
        $dailyReadinessCount = ReadinessForm::count(); // Total readiness forms
        $upcomingAuditsCount = Audit::whereBetween('date', [now(), now()->addDays(7)])->count();
        $upcomingTalksCount = TalkAnimation::whereBetween('date', [now(), now()->addDays(7)])->count();

        // Chart data
        $chartData = [
            'pending_actions' => $pendingActions,
            'daily_readiness' => $dailyReadiness,
            'open_events' => $openEvents,
            'upcoming_audits' => $upcomingAudits,
            'upcoming_talks' => $upcomingTalks,
            'events_status' => [
                'pending' => $pendingEvents,
                'completed' => $completedEvents,
                'processing' => $processingEvents
            ],
        ];

        return view('dashboard', compact(
            'pendingActionsCount',
            'dailyReadinessCount',
            'pendingEvents',
            'upcomingAuditsCount',
            'upcomingTalksCount',
            'chartData'
        ));
    }

    // DashboardController.php

    public function getEventsData(Request $request)
    {
        $timeframe = $request->get('timeframe', 'Last 7 Days');

        // Example logic, replace with real queries
        $pending = Event::where('status', 'pending')->count();
        $completed = Event::where('status', 'completed')->count();
        $processing = Event::where('status', 'processing')->count();

        return response()->json([
            'pending' => $pending,
            'completed' => $completed,
            'processing' => $processing,
        ]);
    }

    public function getChartData(Request $request)
    {
        $timeframe = $request->query('timeframe', '30'); // Default to 30 days
        $days = $timeframe === '7' ? 7 : 30;

        // Define date range
        $startDate = Carbon::today()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::today()->endOfDay();

        // Create date range array
        $dateRange = [];
        for ($i = 0; $i < $days; $i++) {
            $dateRange[] = Carbon::today()->subDays($days - 1 - $i)->format('Y-m-d');
        }

        // Initialize arrays
        $pendingActions = [];
        $dailyReadiness = [];
        $openEvents = [];
        $upcomingAudits = [];

        // Fetch Upcoming Audits/Talks
        $upcomingAuditsData = Audit::whereBetween('date', [$startDate, $endDate])
            ->groupByRaw('DATE(date)')
            ->selectRaw('DATE(date) as date, COUNT(*) as count')
            ->get()
            ->pluck('count', 'date');

        // Fill arrays with data (example, modify queries as needed)
        foreach ($dateRange as $date) {
            $upcomingAudits[] = $upcomingAuditsData->get($date, 0);
            $pendingActions[] = 0; // Replace with actual query
            $dailyReadiness[] = 0; // Replace with actual query
            $openEvents[] = 0; // Replace with actual query
        }

        return response()->json([
            'pending_actions' => $pendingActions,
            'daily_readiness' => $dailyReadiness,
            'open_events' => $openEvents,
            'upcoming_audits' => $upcomingAudits,
        ]);
    }
}
