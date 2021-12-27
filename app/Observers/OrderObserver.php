<?php

namespace App\Observers;

use App\FirestoreOperations;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        //
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $changes = $order->getChanges();
        // dd($changes);
        if(isset($changes['num_of_placed_items']))
        {
            $firestore = FirestoreOperations::getInstance();
            $firestore->updateOrder($order);
        }
        elseif (isset($changes['status']))
        {
            $firestore = FirestoreOperations::getInstance();
            $firestore->updateOrder($order);
        }
        elseif (isset($changes['table_id']))
        {
            $firestore = FirestoreOperations::getInstance();
            $firestore->updateOrder($order);
        }
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
