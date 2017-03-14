<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use File;

class PlanEventListener{

    public function onPlanCreate($event)
    {
        $content = 'Plan created!';
        $content .= $event->plan->project->identifier;
        File::append(storage_path() . '/plans.log', $content);
    }

    public function onPlanUpdate($event)
    {
        $content = 'Plan updated!';
        $content .= $event->plan->title;
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