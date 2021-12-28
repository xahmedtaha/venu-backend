<?php

namespace App;

use App\Models\Branch;
use App\Models\BranchTable;
use App\Models\Order;
use App\Models\OrderedItem;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Factory;

class FirestoreOperations
{
    /**
     * @var FirestoreClient $database
     */
    private $database;

    /**
     * @var FirestoreOperations $instance
     */
    private static $instance;

    const TABLE_CALLING_WAITER = 'is_calling_waiter';
    const TABLE_REQUESTING_CHECKOUT = 'is_requesting_checkout';
    const TABLE_IS_ACTIVE = 'is_active';
    const TABLE_HAS_NEW_ITEMS = 'has_new_items';
    const TABLE_PART_OF_ANOTHER_TABLE = 'is_part_of_another_table';


    private function __construct()
    {
        $factory = new Factory();
        $firestore = $factory->withServiceAccount(config('app.firebase_service_account'))->createFirestore();
        $this->database = $firestore->database();
    }

    /**
     * @return FirestoreOperations
     */
    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new FirestoreOperations();
        }
        return self::$instance;
    }

    public function addBranch(Branch $branch)
    {
        $branchesDocument = $this->database->collection('branches')->document("{$branch->id}")->create([]);
    }

    public function addTable(BranchTable $branchTable)
    {
        $branch = $branchTable->branch;
        $branchesDocument = $this->database->collection('resturants')
                                           ->document("$branch->resturant_id")
                                           ->collection('branches')->document("$branch->id")
                                           ->set([
                                                    "$branchTable->id" => [
                                                        'number' => $branchTable->number,
                                                        'id' => $branchTable->id,
                                                        'is_active' => (boolean)$branchTable->state,
                                                        'is_calling_waiter' => false,
                                                        'is_requesting_checkout' => false,
                                                        'has_new_items' => false,
                                                        'is_part_of_another_table' => false,
                                                        'is_merge_table' => (boolean)$branchTable->is_merged_table,
                                                    ]
                                                ],['merge'=>1]);
    }

    public function changeTableStatus()
    {

    }

    public function updateOrder(Order $order)
    {
        $notInKitchenItemsCount = $order->placedItems()->count() - $order->orderedItems()->count();
        $branchRef = $this->database->collection('resturants')
                                   ->document("$order->resturant_id")
                                   ->collection('branches')
                                   ->document("$order->branch_id");
        // dd("{$order->table_id}.has_new_items");
        $updates = [];
        if( $notInKitchenItemsCount > 0 && $order->status == Order::STATUS_ACTIVE)
        {
//            $branchRef->update([['path'=>"{$order->table_id}.has_new_items",'value'=>true]]);
            $updates[] = ['path'=>"{$order->table_id}.has_new_items",'value'=>true];
        }
        else
        {
//            $branchRef->update([['path'=>"{$order->table_id}.has_new_items",'value'=>false]]);
            $updates[] = ['path'=>"{$order->table_id}.has_new_items",'value'=>false];
        }
        if(count($updates))
            $branchRef->update($updates);
    }

    public function updateTableActive(BranchTable $branchTable, bool $isActive)
    {
        $branchRef = $this->getBranchRef($branchTable->branch->resturant_id,$branchTable->branch_id);

        $branchRef->update([['path'=>"{$branchTable->id}.is_active",'value'=>$isActive]]);
    }

    public function updateTableRequestingCheckout(BranchTable $branchTable, bool $isRequestingCheckout)
    {
        $branchRef = $this->getBranchRef($branchTable->branch->resturant_id,$branchTable->branch_id);

        $branchRef->update([['path'=>"{$branchTable->id}.is_requesting_checkout",'value'=>$isRequestingCheckout]]);
    }

    public function updateTableCallWaiter(BranchTable $branchTable, bool $isCallingWaiter)
    {
        $branchRef = $this->getBranchRef($branchTable->branch->resturant_id,$branchTable->branch_id);

        $branchRef->update([['path'=>"{$branchTable->id}.is_calling_waiter",'value'=>$isCallingWaiter]]);
    }

    public function updateTable(BranchTable $branchTable,array $attrs)
    {
        $branchRef = $this->getBranchRef($branchTable->branch->resturant_id,$branchTable->branch_id);
        $updates = [];
        foreach ($attrs as $key=>$value)
        {
            $updates[] = ['path'=>"{$branchTable->id}.{$key}",'value'=>$value];
        }
        if(count($updates))
            $branchRef->update($updates);
    }

    public function deleteTable(BranchTable $branchTable)
    {
        $branchRef = $this->getBranchRef($branchTable->branch->resturant_id,$branchTable->branch_id);
        $branchRef->update([['path'=>"{$branchTable->id}",'value'=>FieldValue::deleteField()]]);
    }

    private function getBranchRef($resturantId,$branchId)
    {
        return $this->database->collection('resturants')
                              ->document("$resturantId")
                              ->collection('branches')
                              ->document("$branchId");
    }

    public function testBulkUpdate()
    {
        return $this->database->collection('resturants')
            ->document("1")
            ->collection('branches')
            ->document("3")->update([
                ['path'=>"23.has_new_items",'value'=>false],
                ['path'=>"23.is_calling_waiter",'value'=>false],
                ['path'=>"23.is_requesting_checkout",'value'=>false],
            ]);
    }

    public function pushEvent($user_id,array $eventData)
    {
        $timeStamp = FieldValue::serverTimestamp();
        $eventData['created_at'] = $timeStamp;
        $this->database->collection('users')->document($user_id)->collection('events')->add($eventData);
    }

    public function pushBulkEvent($user_ids,array $eventData)
    {
        $timeStamp = FieldValue::serverTimestamp();
        $eventData['created_at'] = $timeStamp;
        $batch = $this->database->batch();
        foreach ($user_ids as $user_id)
        {
            $doc = $this->database->collection('users')->document($user_id)->collection('events')->newDocument();
            $batch->create($doc,$eventData);
        }
        $batch->commit();
    }

    public function readEvents($user_id)
    {
        $events = $this->database->collection('users')->document($user_id)->collection('events')->documents();
        foreach ($events as $event)
        {
            printf('Document data for document %s:' . PHP_EOL, $event->id());
            print_r($event->data());
            printf(PHP_EOL);
        }
    }

    public function addBranchItemAvailability(Branch $branch, $item_id, $availability){
        $branchesDocument = $this->database->collection('resturants')
                                           ->document("$branch->resturant_id")
                                           ->collection('branchItems')->document("$branch->id")
                                           ->set([
                                                    "$item_id" => [
                                                        'is_available' => $availability,
                                                    ]
                                                ],['merge'=>1]);
    }

    private function getBranchItemRef($resturantId,$branchId)
    {
        return $this->database->collection('resturants')
                              ->document("$resturantId")
                              ->collection('branchItems')
                              ->document("$branchId");
    }

    public function updateBranchItemAvailability(Branch $branch, $item_id, $availability) {
        $branchItemRef = $this->getBranchItemRef($branch->resturant_id,$branch->id);
        $branchRef->update([['path'=>"{$item_id}.is_available",'value'=>$availability]]);
    }
}
