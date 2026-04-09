<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Recruiter\SendConnectionRequest;
use App\Models\User;
use App\Services\ConnectionService;

class ConnectionController extends Controller
{
    public function __construct(
        private ConnectionService $connectionService
    ){}


    public function index(Request $request)
    {
        $connections = $request->user()
                ->sentConnectionRequests()
                ->with('developer.portfolio')
                ->latest()
                ->paginate(15);

        return view('recruiter.connections.index',compact('connections'));
    }

    public function store(SendConnectionRequest $request, string $username)
    {
        $developer = User::where('username',$username)
                        ->where('role','developer')
                        ->where('is_active',true)
                        ->firstOrFail();

        $result = $this->connectionService->sendRequest(
            recruiter: $request->user(),
            developer: $developer,
            message: $request->validated('message')
        );

        if($result === 'already_exists'){
            return back()->with('info',
            'You already have a pending request with this developer.'
            );
        }

        return back()->with('success',
            'Connection request sent! You\'ll be notified when they respond.'
            );

    }


    public function destroy(Request $request, $id)
    {
        $connection = $request->user()
                            ->sentConnectionRequests()
                            ->findOrFail($id);

        
        if(! $connection->isPending()){
            return back()->with('error',
                'You can only cancel pending requests.');
        }

        $connection->delete();

        return back()->with('success',
                'Connection request cancelled.');
                
    }


}
