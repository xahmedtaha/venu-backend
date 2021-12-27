<?php

namespace App\Listeners;

use App\Events\TableClosedEvent;
use App\FirestoreOperations;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TableClosedListener
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
     * @param  TableClosedEvent  $event
     * @return void
     */
    public function handle(TableClosedEvent $event)
    {
        if(count($event->userIds) == 0)
            return;
        FirestoreOperations::getInstance()->pushBulkEvent($event->userIds,$event->getData());
    }
}
