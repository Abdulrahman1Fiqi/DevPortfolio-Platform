<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'portfolio_id',
        'event_type',
        'referrer',
        'country_code',
    ];

    const UPDATED_AT = null;

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
