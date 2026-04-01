<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Developer\StoreSkillRequest;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $skills = $request->user()
                        ->portfolio
                        ->skills()
                        ->orderBy('category')
                        ->orderBy('name')
                        ->get();

        $groupedSkills = $skills->groupBy('category');

        return view('developer.skills.index',compact('groupedSkills'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSkillRequest $request)
    {
        $request->user()->portfolio->skills()
                        ->create(
                            $request->validated()
                        );

        return back()->with('success','Skill added!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Skill $skill)
    {
        if($skill->portfolio->user_id !== $request->user()->id){
            abort(403);
        }

        $skill->delete();

        return back()->with('success','Skill removed.');
    }
}
