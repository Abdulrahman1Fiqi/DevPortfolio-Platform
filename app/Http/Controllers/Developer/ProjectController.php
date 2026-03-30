<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Developer\StoreProjectRequest;
use App\Http\Requests\Developer\UpdateProjectRequest;
use App\Models\Project;
use App\Services\Developer\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private ProjectService $projectService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $portfolio = $request->user()->portfolio;

        $projects = $portfolio->projects()->paginate(10);

        return view('developer.projects.index',compact('projects'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('developer.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->projectService->createProject(
            $request->user()->portfolio,
            $request->validated()
        );

        return redirect()
                ->route('developer.projects.index')
                ->with('success','Project created successfully!');

    }

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Project $project)
    {
        $this->authorize('modify', $project);

        return view('developer.projects.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
         $this->authorize('modify', $project);

         $this->projectService->updateProject(
            $project,
            $request->validated()
         );

         return redirect()
                ->route('developer.projects.index')
                ->with('success','Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Project $project)
    {
        $this->authorize('modify', $project);

        $this->projectService->deleteProject($project);

        return back()->with('success','Project deleted.');
    }
}
