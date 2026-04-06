<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;

class DeveloperDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::with(['user','skills'])
                        ->where('is_published',true)
                        ->whereHas('user',fn($q) => 
                            $q->where('is_active',true)
                              ->where('role','developer')
                                );

        // Search
        if($request->filled('search')){
            $search = $request->search;

            $query->where(function($q) use ($search){
                $q->where('headline','like',"%{$search}%")
                  ->where('bio','like',"%{$search}%")
                  ->orWhereHas('user',fn($q) => 
                      $q->where('name','like',"%{$search}%")
                    );
            });
        }


        //Filter
        if($request->filled('skill')){
            $query->whereHas('skills',fn($q) => 
                      $q->where('name','like',"%{$request->skill}%")
            );
        }

        $portfolios = $query->latest()->paginate(12);

        return view('public.developers',compact('portfolios'));

    }
}
