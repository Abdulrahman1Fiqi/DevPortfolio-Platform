<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnalyticsEvent;
use App\Models\ConnectionRequest;
use App\Models\Portfolio;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            // User counts
            'total_users' => User::count(),
            'total_developers' => User::where('role','developer')->count(),
            'total_recruiters' => User::where('role','recruiter')->count(),
            'suspended_users' => User::where('is_active',false)->count(),

            // Portfolio counts
            'total_portfolios' => Portfolio::count(),
            'published_portfolios' => Portfolio::where('is_published',true)->count(),

            // Connection stats
            'total_connections' => ConnectionRequest::count(),
            'accepted_connections' => ConnectionRequest::where('status','accepted')->count(),

            // Platform-wide page views
            'total_page_views' => AnalyticsEvent::where('event_type','page_view')->count(),

            // New users in last 30 days
            'new_users_this_month' => User::where(
                'created_at','>=',Carbon::now()->subDays(30)
            )->count(),

            // Recently registered users
            'recent_users' => User::latest()
                                    ->take(5)
                                    ->get(['id','name','email','role','created_at']),
        ];

        return view('admin.dashboard',compact('stats'));
    }
}
