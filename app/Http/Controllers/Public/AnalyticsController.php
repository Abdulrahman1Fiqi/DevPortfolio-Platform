<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Services\AnalyticsService;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsService $analyticsService
    ){}

    public function track(Request $request)
    {
        $request->validate([
            'event_type' => ['required','in:demo_click,repo_click'],
            'portfolio_id' =>['required','integer','exists:portfolios,id'],
        ]);
        
        $portfolio = Portfolio::find($request->portfolio_id);

        if(auth()->id() === $portfolio->user_id){
            return response()->json(['ok'=>true]);
        }

        $this->analyticsService->recordProjectClick(
            $portfolio,
            $request->event_type
        );

        return response()->json(['ok'=>true]);
    }
}
