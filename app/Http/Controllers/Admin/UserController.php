<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $query = User::withCount([
            'portfolio',
            'receivedConnectionRequests',
        ]);

        // Filters

        // Search by name or email
        if($request->filled('search')){
            $search = $request->search;
            $query->where(function ($q) use ($search){
                $q->where('name','like',"%{search}%")
                  ->orwhere('email','like',"%{search}%")
                  ->orwhere('username','like',"%{search}%");
            });
        }

        // Filter by role
        if($request->filled('role')){
            $query->where('role',$request->role);
        }

        // Filter by status
        if($request->filled('status')){
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index',compact('users'));

    }

    
    public function show(User $user)
    {
        $user->load('portfolio.projects','portfolio.skills');

        return view('admin.users.show',compact('user'));
    }


    public function suspend(User $user)
    {
        if($user->isAdmin()){
            return back()->with('error','Cannot suspend an admin account.');
        }

        $user->update(['is_active' => false]);

        return back()->with('success',
                "{$user->name}'s account has been suspended.");
    }


    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return back()->with('success',
             "{$user->name}'s account has been activated.");

    }


    public function destroy(User $user)
    {

        if($user->isAdmin()){
            return back()->with('error',
            'Cannot delete an admin account.');
        }

        $name = $user->name;

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success',"{$name}'s account has been permanently deleted.");
    }

}
