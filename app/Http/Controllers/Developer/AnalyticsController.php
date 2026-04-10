<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Developer\AnalyticsDashboardService;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsDashboardService $analyticsService
    ){}

    public function index(Request $request)
    {
        $portfolio = $request->user()->portfolio;

        $range = (int) $request->get('range', 30);

        $range = in_array($range, [7,30,90]) ? $range : 30;

        $stats = $this->analyticsService->getStats($portfolio, $range);

        return view('developer.analytics.index', compact('stats','range','portfolio'));        
    }
}
