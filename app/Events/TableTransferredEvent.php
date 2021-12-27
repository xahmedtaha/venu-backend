<?php

namespace App\Events;

use App\Models\BranchTable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TableTransferredEvent
{
    use Dispatchable, SerializesModels;

    const TYPE = 'transfer';

    /**
     * @var BranchTable $sourceTable
     */
    public $sourceTable;
    /**
     * @var BranchTable $destinationTable
     */
    public $destinationTable;

    public $userIds;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BranchTable $sourceTable,BranchTable $destinationTable)
    {
        $this->sourceTable = $sourceTable;
        $this->destinationTable = $destinationTable;
        $this->userIds = $destinationTable->userIds();
    }

    public function getData()
    {
        return [
            'type' => self::TYPE,
            'data' => [
                'message' => __('messages.table_transfer',['fromTable' => $this->sourceTable->number,'toTable'=>$this->destinationTable->number])
            ]
        ];
    }
}
