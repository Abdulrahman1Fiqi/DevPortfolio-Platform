<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'portfolio_id',
        'submitter_name',
        'submitter_role',
        'company',
        'message',
        'rating',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved'=>'boolean',
            'rating'=>'integer',
        ];
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
