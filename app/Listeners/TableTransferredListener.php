<?php

namespace App\Listeners;

use App\Events\TableTransferredEvent;
use App\FirestoreOperations;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TableTransferredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TableTransferredEvent  $event
     * @return void
     */
    public function handle(TableTransferredEvent $event)
    {
        if(count($event->userIds) == 0)
            return;
        FirestoreOperations::getInstance()->pushBulkEvent($event->userIds,$event->getData());
    }
}
