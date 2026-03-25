<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Developer\UpdateProfileRequest;
use App\Services\Developer\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    ){}


    public function edit(Request $request)
    {
        $user = $request->user();
        $portfolio = $user->portfolio;

        return view('developer.profile.edit',[
            'user' => $user,
            'portfolio' => $portfolio,
        ]);
    }


    public function update(UpdateProfileRequest $request)
    {
        $this->profileService->updateProfile(
            $request->user(),
            $request->validated()
        );

        return back()->with('success','Profile updated successfully!');
    }

    public function togglePublish(Request $request)
    {
        $portfolio = $request->user()->portfolio;

        $portfolio->update([
            'is_published' => ! $portfolio->is_published,
        ]);

        $status = $portfolio->is_published ? 'published' : 'unpublished';

        return back()->with('success',"Your portfolio is now {$status}!");
    }
}
