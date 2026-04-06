<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class AnalyticsService
{
    public function __construct(
        private Request $request
    ) {}

    public function recordPageView(Portfolio $portfolio): void
    {
        AnalyticsEvent::create([
            'portfolio_id' => $portfolio->id,
            'event_type' => 'page_view',
            'referrer' => $this->getReferrer(),
            'country_code' => null,
        ]);
    }


    public function recordProjectClick(Portfolio $portfolio, string $type): void
    {
        AnalyticsEvent::create([
            'portfolio_id' => $portfolio->id,
            'event_type' => $type,
            'referrer' => null,
            'country_code' => null,
        ]);
    }


    private function getReferrer(): ?string
    {
        $referrer = $this->request->headers->get('referer');


        if($referrer){
            $host = parse_url($referrer, PHP_URL_HOST);
            return $host ?: null;
        }

        return null;
    }
}