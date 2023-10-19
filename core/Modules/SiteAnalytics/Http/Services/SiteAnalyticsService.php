<?php

namespace Modules\SiteAnalytics\Http\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\SiteAnalytics\Entities\PageView;

class SiteAnalyticsService
{
    public function __construct(private $period)
    {

    }

    public function periods(): array
    {
        return [
            'today'     => 'Today',
            'yesterday' => 'Yesterday',
            '1_week'    => 'Last 7 days',
            '30_days'   => 'Last 30 days',
            '6_months'  => 'Last 6 months',
            '12_months' => 'Last 12 months',
        ];
    }

    public function stats(): array
    {
        return [
            [
                'key'   => 'Unique Users',
                'value' => PageView::query()
                    ->scopes(['filter' => [$this->period]])
                    ->groupBy('session')
                    ->pluck('session')
                    ->count(),
            ],
            [
                'key'   => 'Page Views',
                'value' => PageView::query()
                    ->scopes(['filter' => [$this->period]])
                    ->count(),
            ],
        ];
    }

    public function pages(): Collection
    {
        return PageView::query()
            ->scopes(['filter' => [$this->period]])
            ->select('uri as page', DB::raw('count(*) as users'))
            ->groupBy('page')
            ->orderBy('users', 'desc')
            ->get();
    }

    public function pagesByDate(): Collection
    {
        return PageView::query()
            ->whereDate('created_at', today())
            ->select(DB::raw("DATE_FORMAT(created_at, '%h %p') as time"), DB::raw('count(*) as total_views'))
            ->groupBy('time')
            ->orderBy('time')
            ->get();
    }

    public function sources(): Collection
    {
        return PageView::query()
            ->scopes(['filter' => [$this->period]])
            ->select('source as page', DB::raw('count(*) as users'))
            ->whereNotNull('source')
            ->groupBy('source')
            ->orderBy('users', 'desc')
            ->get();
    }

    public function users(): Collection
    {
        return PageView::query()
            ->scopes(['filter' => [$this->period]])
            ->select('country', DB::raw('count(*) as users'))
            ->groupBy('country')
            ->orderBy('users', 'desc')
            ->get();
    }

    public function devices(): Collection
    {
        return PageView::query()
            ->scopes(['filter' => [$this->period]])
            ->select('device as type', DB::raw('count(*) as users'))
            ->groupBy('type')
            ->orderBy('users', 'desc')
            ->get();
    }

    public function utm(): Collection
    {
        return collect([
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
        ])->mapWithKeys(fn (string $key) => [$key => [
            'key'   => $key,
            'items' => PageView::query()
                ->select([$key, DB::raw('count(*) as count')])
                ->scopes(['filter' => [$this->period]])
                ->whereNotNull($key)
                ->groupBy($key)
                ->orderBy('count', 'desc')
                ->get()
                ->map(fn ($item) => [
                    'value' => $item->{$key},
                    'count' => $item->count,
                ]),
        ]])->filter(fn (array $set) => $set['items']->count() > 0);
    }
}
