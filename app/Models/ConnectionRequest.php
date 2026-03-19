<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectionRequest extends Model
{
    protected $fillable = [
        'recruiter_id',
        'developer_id',
        'message',
        'status',
        'responded_at',
    ];

    protected function casts(): array
    {
        return[
            'responded_at'=>'datetime',
        ];
    }

    // Relationships
    public function recruiter()
    {
        return $this->belongsTo(User::class,'recruiter_id');
    }
    public function developer()
    {
        return $this->belongsTo(User::class,'developer_id');
    }

    // Status
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    
}
