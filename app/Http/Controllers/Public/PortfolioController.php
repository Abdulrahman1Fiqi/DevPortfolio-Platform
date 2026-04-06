<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AnalyticsService;

class PortfolioController extends Controller
{
    public function __construct(
        private AnalyticsService $analyticsService
    ){}

    public function show(string $username)
    {
        $user = User::where('username', $username)
                    ->where('is_active', true)
                    ->firstOrFail();

        $portfolio = $user->portfolio()
                        ->with([
                            'projects' => fn($q) => $q->orderBy('sort_order'),
                            'skills',
                            'experiences' => fn($q) => $q->orderByDesc('start_date'),
                            'testimonials',                           
                        ])
                        ->first();

        if(! $portfolio || ! $portfolio->is_published){

            if(auth()->id() !== $user->id){
                abort(404);
            }
        }

        $groupedSkills = $portfolio->skills->groupBy('category');
        
        if(auth()->id() !== $user->id){
            $this->analyticsService->recordPageView($portfolio);
        }

        return view('public.portfolio',compact('user','portfolio','groupedSkills'));
        
    }
}
