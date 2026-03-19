<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'headline',
        'bio',
        'location',
        'avatar_path',
        'is_published',
        'social_links',
    ];

    protected function casts(): array
    {
        return [
            'is_published'=>'boolean',
            'social_links'=>'array',
        ];
    }

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->orderBy('sort_order');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class)->orderBy('sort_order');;
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class)->where('is_approved',true);
    }

    public function allTestimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function analyticsEvents()
    {
        return $this->hasMany(AnalyticsEvent::class);
    }

    


}
