<?php 

namespace App\Services\Developer;

use App\Models\AnalyticsEvent;
use App\Models\Portfolio;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AnalyticsDashboardService
{
    public function getStats(Portfolio $portfolio, int $days): array
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();

        return [
            'total_views' => $this->getTotalViews($portfolio),
            'views_in_range' => $this->getViewsInRange($portfolio, $startDate),
            'views_per_day' => $this->getViewsPerDay($portfolio, $startDate),
            'top_projects' => $this->getTopProjects($portfolio, $startDate),
            'total_connections' => $this->getTotalConnections($portfolio),
            'pending_connections' => $this->getPendingConnections($portfolio),
            'referrers' => $this->getTopReferrers($portfolio, $startDate),
        ];
    }

    private function getTotalViews(Portfolio $portfolio):int
    {
        return AnalyticsEvent::where('portfolio_id', $portfolio->id)
                            ->where('event_type','page_view')
                            ->count();
    }

    private function getViewsInRange(Portfolio $portfolio, Carbon $startDate):int
    {
        return AnalyticsEvent::where('portfolio_id', $portfolio->id)
                            ->where('event_type','page_view')
                            ->where('created_at','>=', $startDate)
                            ->count();
    }

    private function getViewsPerDay(Portfolio $portfolio, Carbon $startDate): array
    {
        $rawData = AnalyticsEvent::where('portfolio_id',$portfolio->id)
            ->where('event_type', 'page_view')
            ->where('created_at','>=',$startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count','date')
            ->toArray();

        // Handle days with 0 views
        $result = [];
        
        $current = $startDate->copy();
        $today = Carbon::today();

        while($current <= $today){
            $dateKey = $current->format('Y-m-d');
            $result[$dateKey] = $rawData[$dateKey] ?? 0;
            $current->addDay();
        }

        return $result;
    }

    private function getTopProjects(Portfolio $portfolio, Carbon $startDate): array
    {
        $clicks = AnalyticsEvent::where('portfolio_id', $portfolio->id)
            ->whereIn('event_type',['demo_click','repo_click'])
            ->where('created_at','>=',$startDate)
            ->select(
                DB::raw('COUNT(*) as clicks'),
                'event_type'
            )
            ->groupBy('event_type')
            ->get();


        $demoClicks = $clicks['demo_click'] ?? 0;
        $repoClicks = $clicks['repo_click'] ?? 0;

        return [
            'demo_clicks' => $demoClicks,
            'repo_clicks' => $repoClicks,
            'total_clicks' => $demoClicks + $repoClicks,
        ];
    }


    private function getTotalConnections(Portfolio $portfolio): int
    {
        return $portfolio->user
                        ->receivedConnectionRequests()
                        ->count();
    }

    private function getPendingConnections(Portfolio $portfolio): int
    {
        return $portfolio->user
                        ->receivedConnectionRequests()
                        ->where('status','pending')
                        ->count();
    }

    private function getTopReferrers(Portfolio $portfolio, Carbon $startDate): array
    {
        return AnalyticsEvent::where('portfolio_id',$portfolio->id)
            ->where('event_type','page_view')
            ->where('created_at','>=', $startDate)
            ->whereNotNull('referrer')
            ->select(
                'referrer',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('referrer')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('count','referrer')
            ->toArray();
    }
}