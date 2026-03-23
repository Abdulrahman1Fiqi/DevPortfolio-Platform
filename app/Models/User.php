<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active'=>'boolean',
        ];
    }

    // Role helpers
    public function isDeveloper():bool
    {
        return $this->role === 'developer';
    }

    public function isRecruiter():bool
    {
        return $this->role === 'recruiter';
    }

    public function isAdmin():bool
    {
        return $this->role === 'admin';
    }

    // Relationships
    public function portfolio()
    {
        return $this->hasOne(Portfolio::class);
    }

    public function sentConnectionRequests()
    {
        return $this->hasMany(ConnectionRequest::class,'recruiter_id');
    }

    public function receivedConnectionRequests()
    {
        return $this->hasMany(ConnectionRequest::class,'developer_id');
    }


    // Helper method
    public function dashboardRoute(): string
    {
        return match($this->role ){
            'admin'=>'admin.dashboard',
            'recruiter'=>'recruiter.dashboard',
            'developer'=>'developer.dashboard',
             default => 'home',
         };
    }

}
