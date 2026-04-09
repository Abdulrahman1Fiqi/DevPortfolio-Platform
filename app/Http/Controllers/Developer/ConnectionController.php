<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConnectionRequest;
use App\Services\ConnectionService;

class ConnectionController extends Controller
{
    public function __construct(
        private ConnectionService $connectionService
    ){}

    public function index(Request $request)
    {
        $connections = $request->user()
                ->receivedConnectionRequests()
                ->with('recruiter')
                ->latest()
                ->paginate(15);


        $pendingCount = $request->user()
            ->receivedConnectionRequests()
            ->where('status','pending')
            ->count();


        return view('developer.connections.index',compact('connections','pendingCount'));
    }


    public function accept(Request $request, ConnectionRequest $connection)
    {
        $this->authorizeConnection($request, $connection);

        $this->connectionService->acceptRequest($connection);

        return back()->with('success',
            'Connection accepted! The recruiter can now see your contact email.'
            );
    }

    public function decline(Request $request, ConnectionRequest $connection)
    {
        $this->authorizeConnection($request, $connection);

        $this->connectionService->declineRequest($connection);

        return back()->with('success',
            'Connection request declined.'
            );
    }


    private function authorizeConnection(Request $request, ConnectionRequest $connection)
    {
        if($connection->developer_id !== $request->user()->id){
            abort(403);
        }

        if(! $connection->isPending()){
            abort(422,'This request has already been responded to.');
        }
    }
    
}
