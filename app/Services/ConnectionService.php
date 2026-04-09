<?php

namespace App\Services;

use App\Models\ConnectionRequest;
use App\Models\User;
use App\Notifications\ConnectionRequestReceived;
use App\Notifications\ConnectionRequestAccepted;

class ConnectionService
{
    public function sendRequest(
        User $recruiter,
        User $developer,
        ?string $message
    ): string {
        // Check if a request already exists
        $existing = ConnectionRequest::where('recruiter_id',$recruiter->id)
                                    ->where('developer_id',$developer->id)
                                    ->first();

        if($existing){
            return 'already_exists';
        }                           
        
        // Create the connection request
        $connection = ConnectionRequest::create([
            'recruiter_id' => $recruiter->id,
            'developer_id' => $developer->id,
            'message' => $message,
            'status' => 'pending',
        ]);


        // Notify the developer by email
        $developer->notify(new ConnectionRequestReceived($connection));

        return 'sent';
    }


    public function acceptRequest(ConnectionRequest $connection): void
    {
        $connection->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);

        $connection->recruiter->notify(
            new ConnectionRequestAccepted($connection)
        );
    }

    public function declineRequest(ConnectionRequest $connection): void
    {
        $connection->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

    }

}