<?php

namespace App\Events;

use App\Plan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlanCreated
{
    use InteractsWithSockets, SerializesModels;

    public $plan;

    /**
     * Create a new event instance.
     *
     * @param  Plan  $plan
     * @return void
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
