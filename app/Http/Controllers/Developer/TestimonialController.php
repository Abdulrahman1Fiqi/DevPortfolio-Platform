<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $portfolio = $request->user()->portfolio;

        $pending = $portfolio->allTestimonials()
                             ->where('is_approved',false)
                             ->latest()
                             ->get();

        $approved = $portfolio->allTestimonials()
                             ->where('is_approved',true)
                             ->latest()
                             ->get();

        return view('developer.testimonials.index',[
            'pending' => $pending,
            'approved' => $approved,
            'testimonialLink' => route('testimonial.show', $portfolio->testimonial_token),
        ]);
    }

    public function approve(Request $request, Testimonial $testimonial)
    {
        $this->authorizeTestimonial($request, $testimonial);

        $testimonial->update(['is_approved' =>true]);

        return back()->with('success','Testimonial approved and now visible on your portfolio!');
    }

    public function destroy(Request $request, Testimonial $testimonial)
    {
        $this->authorizeTestimonial($request, $testimonial);

        $testimonial->delete();

        return back()->with('success','Testimonial removed.');
    }

    private function authorizeTestimonial(Request $request, Testimonial $testimonial): void
    {
        if($testimonial->portfolio->user_id !== $request->user()->id){
            abort(403);
        }
    }
}
