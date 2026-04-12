<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Portfolio::with('user')
                        ->withCount(['projects','skills','analyticsEvents']);

        // Filter by published status
        if($request->filled('status')){
            $query->where('is_published', $request->status === 'published');
        }

        // Search by developer name
        if($request->filled('search')){
            $query->whereHas('user',function ($q) use ($request){
                $q->where('name','like',"%{$request}%")
                  ->orWhere('username','like',"%{$request->search}%");
            });
        }

        $portfolios = $query->latest()->paginate(20);

        return view('admin.portfolios.index',compact('portfolios'));
    }


    public function unpublish(Portfolio $portfolio)
    {
        $portfolio->update(['is_published' => false]);

        return back()->with('success',
            "{$portfolio->user->name}'s portfolio has been unpublished."
        );
    }
}
