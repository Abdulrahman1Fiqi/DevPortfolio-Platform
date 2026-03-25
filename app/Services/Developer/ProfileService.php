<?php

namespace App\Services\Developer;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateProfile(User $user, array $data):void
    {

        $user->update([
            'name' => $data['name'],
        ]);


        $avatarPath = $user->portfolio->avatar_path;

        if(isset($data['avatar'])){
            if($avatarPath){
                Storage::disk('public')->delete($avatarPath);
            }

            $avatarPath = $data['avatar']->store('avatars','public');
        }

        // Update the portfolio
        $user->portfolio->update([
            'headline'    => $data['headline']  ?? null,
            'bio'         => $data['bio']       ?? null,
            'location'    => $data['location']  ?? null,
            'avatar_path' => $avatarPath,

            'social_links'=>[
                'github' => $data['social_links']['github'] ?? null,
                'linkedin' => $data['social_links']['linkedin'] ?? null,
                'website' => $data['social_links']['website'] ?? null,
                'twitter' => $data['social_links']['twitter'] ?? null,
            ],
        ]);

    }
}