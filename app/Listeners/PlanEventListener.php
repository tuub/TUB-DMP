<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use File;

class PlanEventListener{

    public function onPlanCreate($event)
    {
        $content = 'PLAN CREATED: ';
        $content .= $event->plan->title . ' in ' . $event->plan->project->identifier;
        $content .= PHP_EOL;
            File::append(storage_path() . '/plans.log', $content);
    }

    public function onPlanUpdate($event)
    {
        $content = 'PLAN UPDATED: ';
        $content .= $event->plan->title . ' in ' . $event->plan->project->identifier;
        $content .= PHP_EOL ;
        File::append(storage_path() . '/plans.log', $content);
    }

    public function subscribe($events){
        $events->listen(
            'App\Events\PlanCreated',
            'App\Listeners\PlanEventListener@onPlanCreate'
        );

        $events->listen(
            'App\Events\PlanUpdated',
            'App\Listeners\PlanEventListener@onPlanUpdate'
        );
    }

}