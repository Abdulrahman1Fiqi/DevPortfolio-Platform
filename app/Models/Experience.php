<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'portfolio_id',
        'company',
        'role',
        'start_date',
        'end_date',
        'description',
        'sort_order',
    ];

    protected function casts():array
    {
        return [
            'start_date'=>'date',
            'end_date'=>'date',
        ];
    }

    public function getEndLabelAttribute(): string
    {
        return $this->end_date
            ? $this->end_date->format('M Y')
            : 'Present';
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


}
