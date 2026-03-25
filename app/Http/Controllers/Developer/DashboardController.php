<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('portfolio');

        return view('developer.dashboard',[
            'user' => $user,
            'portfolio' => $user->portfolio,
        ]);
    }
}
