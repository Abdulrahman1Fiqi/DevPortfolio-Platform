<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Public\StoreTestimonialRequest;
use App\Models\Portfolio;

class TestimonialController extends Controller
{
    public function show(string $token)
    {
        $portfolio = Portfolio::where('testimonial_token',$token)
                            ->with('user')
                            ->firstOrFail();

        if(! $portfolio->is_published){
            abort(404);
        }

        return view('public.testimonial',[
            'portfolio' => $portfolio,
            'user' => $portfolio->user,
        ]);
    }

    public function store(StoreTestimonialRequest $request, string $token)
    {
        $portfolio = Portfolio::where('testimonial_token',$token)
                            ->firstOrFail();

        if(! $portfolio->is_published){
            abort(404);
        }
        
        $portfolio->allTestimonials()->create([
            'submitter_name' => $request->validated('submitter_name'),
            'submitter_role' => $request->validated('submitter_role'),
            'company'        => $request->validated('company'),
            'message'        => $request->validated('message'),
            'rating'         => $request->validated('rating'),
            'is_approved'    => false,
        ]);

        return redirect()
                ->route('testimonial.show', $token)
                ->with('success',
                'Thank you! Your testimonial has been submitted and will appear after review.'
                );
    }
}
