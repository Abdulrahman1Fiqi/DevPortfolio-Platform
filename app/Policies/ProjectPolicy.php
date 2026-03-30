<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    public function modify(User $user, Project $project): bool
    {
        return $project->portfolio->user_id === $user->id;
    }

    
}
