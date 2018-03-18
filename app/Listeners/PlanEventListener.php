<?php
declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Http\File;


/**
 * Class PlanEventListener
 *
 * @package App\Listeners
 */
class PlanEventListener{

    /**
     * Writes plan create event to logfile.
     *
     * Current file: storage_path() . '/plans.log'
     *
     * @param $event
     * @return void
     */
    public function onPlanCreate($event)
    {
        $content = 'PLAN CREATED: ';
        $content .= $event->plan->title . ' in ' . $event->plan->project->identifier;
        $content .= PHP_EOL;
        File::append(storage_path() . '/plans.log', $content);
    }


    /**
     * Writes plan update event to logfile.
     *
     * Current file: storage_path() . '/plans.log'
     *
     * @param $event
     * @return void
     */
    public function onPlanUpdate($event)
    {
        $content = 'PLAN UPDATED: ';
        $content .= $event->plan->title . ' in ' . $event->plan->project->identifier;
        $content .= PHP_EOL ;
        File::append(storage_path() . '/plans.log', $content);
    }


    /**
     * Subscribes to the events.
     *
     * @param $events
     * @return void
     */
    public function subscribe($events){
        $events->listen(
            'App\Events\PlanCreated::class',
            'App\Listeners\PlanEventListener@onPlanCreate'
        );

        $events->listen(
            'App\Events\PlanUpdated::class',
            'App\Listeners\PlanEventListener@onPlanUpdate'
        );
    }

}