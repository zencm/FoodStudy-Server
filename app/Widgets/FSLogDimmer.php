<?php

namespace App\Widgets;

use App\FSLogFood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

use Illuminate\Support\Carbon;

class FSLogDimmer extends BaseDimmer
{
    
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $now = new Carbon();

        $from = $now->startOfDay();
        $until = (clone $now)->endOfDay();
        $todayCount = FSLogFood::whereBetween('date', [$from->toDateTimeString(), $until->toDateTimeString()])->count();

        $now = (clone $now)->sub('day', 1);
        $from = $now->startOfDay();
        $until = (clone $now)->endOfDay();
        $yesterdayCount = FSLogFood::whereBetween('date', [$from->toDateTimeString(), $until->toDateTimeString()])->count();


        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-data',
            'title'  => "FSLog entries",
            'text'   => "{$todayCount} today, {$yesterdayCount} yesterday",
            'button' => [
                'text' => 'show entries',
                'link' => '/admin/foodapp',
            ],
            'image' => voyager_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
