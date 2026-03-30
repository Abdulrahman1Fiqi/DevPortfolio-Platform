<?php

namespace App\Services\Developer;

use App\Models\Portfolio;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function createProject(Portfolio $portfolio, array $data): Project
    {
        $thumbnailPath = null;
        if(isset($data['thumbnail'])){
            $thumbnailPath = $data['thumbnail']->store('thumbnails','public');
        }

        return $portfolio->projects()->create([
            'title'         => $data['title'],
            'description'   => $data['description'] ?? null,
            'tech_stack'    => $data['tech_stack'] ?? [],
            'thumbnail_path'=> $thumbnailPath,
            'demo_url'      => $data['demo_url'] ?? null,
            'repo_url'      => $data['repo_url'] ?? null,
            'is_featured'   => $data['is_featured'] ?? false,
        ]);
    }


    public function updateProject(Project $project, array $data): void
    {
        $thumbnailPath = $project->thumbnail_path;

        if(isset($data['thumbnail'])){

            if($thumbnailPath){
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailPath = $data['thumbnail']->store('thumbnails','public');
        }

        $project->update([
                'title'         => $data['title'],
                'description'   => $data['description'] ?? null,
                'tech_stack'    => $data['tech_stack'] ?? [],
                'thumbnail_path'=> $thumbnailPath,
                'demo_url'      => $data['demo_url'] ?? null,
                'repo_url'      => $data['repo_url'] ?? null,
                'is_featured'   => $data['is_featured'] ?? false,
        ]);

    }


    public function deleteProject(Project $project): void
    {
        if($project->thumbnail_path){
            Storage::disk('public')->delete($project->thumbnail_path);
        }

        $project->delete();
    }   

}