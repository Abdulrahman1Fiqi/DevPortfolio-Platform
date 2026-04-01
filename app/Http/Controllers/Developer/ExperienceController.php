<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Developer\StoreExperienceRequest;
use App\Http\Requests\Developer\UpdateExperienceRequest;
use App\Models\Experience;
class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $experiences = $request->user()
                            ->portfolio
                            ->experiences()
                            ->orderByDesc('start_date')
                            ->get();

        return view('developer.experience.index',compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('developer.experience.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request)
    {
        $request->user()->portfolio->experiences()
                    ->create(
                        $request->validated()
                    );

        return redirect()
                ->route('developer.experience.index')
                ->with('success','Experience added!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Experience $experience)
    {
        if($experience->portfolio->user_id !== $request->user()->id){
            abort(403);
        }

        return view('developer.experience.edit',compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        if($experience->portfolio->user_id !== $request->user()->id){
            abort(403);
        }

        $experience->update($request->validated());

        return redirect()
            ->route('developer.experience.index')
            ->with('success','Experience updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Experience $experience)
    {
        if($experience->portfolio->user_id !== $request->user()->id){
            abort(403);
        }

        $experience->delete();

        return back()->with('success','Experience removed.');
    }
}
