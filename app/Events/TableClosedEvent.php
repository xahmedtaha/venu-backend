<?php

namespace App\Events;

use App\Models\BranchTable;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TableClosedEvent
{
    use Dispatchable, SerializesModels;

    const TYPE = 'table_closed';
    public $user;
    /**
     * @var BranchTable $table
     */
    public $table;
    public $userIds;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( BranchTable $table)
    {
        $this->userIds = $table->userIds();
        $this->table = $table;
    }

    public function getData()
    {
        return [
            'type' => self::TYPE,
        ];
    }
}
