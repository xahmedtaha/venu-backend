<?php

namespace App\Observers;

use App\FirestoreOperations;
use App\Models\OrderedItem;

class OrderedItemObserver
{
    /**
     * Handle the ordered item "created" event.
     *
     * @param  \App\OrderedItem  $orderedItem
     * @return void
     */
    public function created(OrderedItem $orderedItem)
    {

    }

    /**
     * Handle the ordered item "updated" event.
     *
     * @param  \App\OrderedItem  $orderedItem
     * @return void
     */
    public function updated(OrderedItem $orderedItem)
    {
        $changes = $orderedItem->getChanges();
        // dd($changes);
        if(isset($changes['is_in_kitchen']))
        {
            $firestore = FirestoreOperations::getInstance();
            $firestore->updateOrder($orderedItem->order);
        }
    }

    /**
     * Handle the ordered item "deleted" event.
     *
     * @param  \App\OrderedItem  $orderedItem
     * @return void
     */
    public function deleted(OrderedItem $orderedItem)
    {
        //
    }

    /**
     * Handle the ordered item "restored" event.
     *
     * @param  \App\OrderedItem  $orderedItem
     * @return void
     */
    public function restored(OrderedItem $orderedItem)
    {
        //
    }

    /**
     * Handle the ordered item "force deleted" event.
     *
     * @param  \App\OrderedItem  $orderedItem
     * @return void
     */
    public function forceDeleted(OrderedItem $orderedItem)
    {
        //
    }
}
