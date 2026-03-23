<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:30','alpha_dash','unique:users',],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' =>['required','in:developer,recruiter'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username'=>strtolower($request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' =>$request->role,
        ]);


        if ($user->isDeveloper()){
            Portfolio::create([
                'user_id' => $user->id,
                'is_published'=>false,
            ]);
        }


        event(new Registered($user));

        Auth::login($user);



        return $this->redirectBasedOnRole($user);
    }

    private function redirectBasedOnRole(User $user): RedirectResponse
    {
        return match($user->role){
            'admin'=> redirect()->route('admin.dashboard'),
            'recruiter'=> redirect()->route('recruiter.dashboard'),
            'developer'=> redirect()->route('developer.dashboard'),
        };
    }
}
