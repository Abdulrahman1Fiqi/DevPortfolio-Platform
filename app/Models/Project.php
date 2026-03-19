<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    
    protected $fillable = [
        'portfolio_id',
        'title',
        'description',
        'tech_stack',
        'thumbnail_path',
        'demo_url',
        'repo_url',
        'is_featured',
        'sort_order',
    ];

    protected function casts():array
    {
        return [
            'tech_stack'=>'array',
            'is_featured'=>'boolean',
        ];
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

}
