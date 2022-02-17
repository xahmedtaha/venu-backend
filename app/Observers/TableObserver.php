<?php

namespace App\Observers;

use App\FirestoreOperations;
use App\Models\BranchTable;
use Illuminate\Support\Facades\Log;

class TableObserver
{
    /**
     * Handle the branch table "created" event.
     *
     * @param  \App\BranchTable  $branchTable
     * @return void
     */
    public function created(BranchTable $branchTable)
    {
        Log::debug("Created for table $branchTable->id");
        $firestore = FirestoreOperations::getInstance();
        $firestore->addTable($branchTable);
    }

    /**
     * Handle the branch table "updated" event.
     *
     * @param  \App\BranchTable  $branchTable
     * @return void
     */
    public function updated(BranchTable $branchTable)
    {

        Log::debug("Update for table $branchTable->id");
        $changes = $branchTable->getChanges();
        Log::debug("table state $branchTable->state");
        if(isset($changes['deleted_at']))
        {
            return ;
        }
        $firestore = FirestoreOperations::getInstance();
        $firesStoreUpdates = [];
        if(isset($changes['state']))
        {
//            $firestore->updateTableActive($branchTable,(boolean)$branchTable->state);
            $firesStoreUpdates[FirestoreOperations::TABLE_IS_ACTIVE] = (boolean)$branchTable->state;
        }
        if(isset($changes['is_requesting_checkout']))
        {
//            $firestore->updateTableRequestingCheckout($branchTable,(boolean)$branchTable->is_requesting_checkout);
            $firesStoreUpdates[FirestoreOperations::TABLE_REQUESTING_CHECKOUT] = (boolean)$branchTable->is_requesting_checkout;
        }
        if(isset($changes['is_calling_waiter']))
        {
//            $firestore->updateTableCallWaiter($branchTable,(boolean)$branchTable->is_calling_waiter);
            $firesStoreUpdates[FirestoreOperations::TABLE_CALLING_WAITER] = (boolean)$branchTable->is_calling_waiter;
        }
        if(array_key_exists('merged_into',$changes))
        {
//            $firestore->updateTableCallWaiter($branchTable,(boolean)$branchTable->is_calling_waiter);
            $firesStoreUpdates[FirestoreOperations::TABLE_PART_OF_ANOTHER_TABLE] = $branchTable->merged_into? true : false;
        }


        if(count($firesStoreUpdates))
            $firestore->updateTable($branchTable,$firesStoreUpdates);
    }

    /**
     * Handle the branch table "deleted" event.
     *
     * @param  \App\BranchTable  $branchTable
     * @return void
     */
    public function deleted(BranchTable $branchTable)
    {

        $firestore = FirestoreOperations::getInstance();
        $firestore->deleteTable($branchTable);
    }

    /**
     * Handle the branch table "restored" event.
     *
     * @param  \App\BranchTable  $branchTable
     * @return void
     */
    public function restored(BranchTable $branchTable)
    {
        //
    }

    /**
     * Handle the branch table "force deleted" event.
     *
     * @param  \App\BranchTable  $branchTable
     * @return void
     */
    public function forceDeleted(BranchTable $branchTable)
    {
        //
    }
}
