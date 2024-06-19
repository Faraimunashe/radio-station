<?php

namespace App\Events;

use App\Models\Schedule;
use App\Models\ScheduleEngineer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EngineerScheduled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $schedule_engineer;
    /**
     * Create a new event instance.
     */
    public function __construct(ScheduleEngineer $schedule_engineer)
    {
        $this->schedule_engineer = $schedule_engineer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
