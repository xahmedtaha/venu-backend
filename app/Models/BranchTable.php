<?php

namespace App\Models;

use App\Events\TableClosedEvent;
use App\Events\TableTransferredEvent;
use App\FirestoreOperations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class BranchTable extends Model
{
    use SoftDeletes;

    public const STATE_AVAILABLE = 0;
    public const STATE_BUSY = 1;
    protected $guarded = ['id'];

    protected $casts = [
        'branch_id' => 'integer',
        'state' => 'integer',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class)->with('resturant');
    }

    public function getResturantAttribute()
    {
        return $this->branch->resturant;
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'table_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,'table_id');
    }

    /**
     * returns the tables which are merged together into this table
     */
    public function mergedTables()
    {
        return $this->hasMany(BranchTable::class,'merged_into');
    }

    public function clear()
    {
        $this->update([
                        'state'=>self::STATE_AVAILABLE,
                        'share_code' => null,
                        'is_requesting_checkout' => false,
                        'is_calling_waiter'=> false,
                        'merged_into' => null,
                      ]);
        event(new TableClosedEvent($this));
        $this->carts()->update(['active'=>false]);
        if($this->is_merged_table) {
            foreach ($this->mergedTables as $mergedTable) {
                $mergedTable->clear();
            }
            $this->delete();
        }
    }

    public function transferOrderFromTable(BranchTable $sourceTable,bool $is_merge = false)
    {
        if($this->status == BranchTable::STATE_BUSY && $is_merge == false) { //to prevent transfer to a busy table
            return false;
        }
        /**
         * @var Order $order
         */
        $order = $sourceTable->getActiveOrder();
        if($is_merge){
            if($order)
                $order->mergeInto($this->getActiveOrder());
        } else {
            $order->update(['table_id'=>$this->id]);
            $order->refresh();
            $order->carts()->update(['table_id' => $this->id]);
        }
        event(new TableTransferredEvent($sourceTable,$this));
        FirestoreOperations::getInstance()->updateTable($sourceTable,[FirestoreOperations::TABLE_HAS_NEW_ITEMS=>false]);
        $this->update([
            'state'                  => self::STATE_BUSY,
            'share_code'             => null,
            'is_requesting_checkout' => $sourceTable->is_requesting_checkout,
            'is_calling_waiter'      => $sourceTable->is_calling_waiter
        ]);
        if($is_merge == false)
            $sourceTable->clear();
        else {
            $sourceTable->update(['merged_into'=>$this->id,'state' => self::STATE_BUSY]);
        }
        return true;
    }

    /**
     * @param Collection<BranchTable> $tablesToMerge
     */
    public function mergeTablesWithMe(Collection $tablesToMerge)
    {
        $this->initOrder();
        $order = $this->getActiveOrder();
        /**
         * @var BranchTable $tableToMerge
         */
        foreach ($tablesToMerge as $tableToMerge){
            $this->transferOrderFromTable($tableToMerge,true);
        }
    }
    /**
     * @return Order
     */
    public function getActiveOrder()
    {
        return $this->orders()->where('status',Order::STATUS_ACTIVE)->first();
    }

    public function initOrder()
    {
        $this->orders()->update(['status'=>Order::STATUS_CLOSED]);
        $order_number = $this->branch->getNewOrderNumber();

        $share_code = self::generateUniqueShareKey();
        $this->update(['state'=>self::STATE_BUSY,'share_code' => $share_code]);

        $order = $this->orders()->create([
            "resturant_id" => $this->resturant->id,
            "branch_id" => $this->branch_id,
            "sub_total" => 0,
            "tax" => $this->resturant->vat_value,
            "tax_value" => 0,
            "total" => 0,
            "status" => Order::STATUS_ACTIVE,
            "order_number" => $order_number,
            "number_of_products" => 0,
            "discount" => 0
        ]);

        return $order;
    }

    public function requestCheckout()
    {
        $this->update(['is_requesting_checkout'=>true]);
    }

    public function setCallWaiter($value)
    {
        $this->update(['is_calling_waiter'=>$value]);
    }

    public static function generateUniqueShareKey($length = 5)
    {
        return substr(md5(time()), 0, $length);
    }

    /**
     * This function will be called by the cron job to verify table timers logic
     */
    public static function updateTableTimers()
    {
        self::query()->chunk(100,function ($tables)
        {
            foreach($tables as $table)
            {
                $table->updateTimer();
            }
        });
    }

    /**
     * Checks for the last cart activity to check the last cart activity
     * to detect if the table is empty
     */
    public function updateTimer()
    {
        $activeCartIds = $this->carts()->where('active',true)->pluck('id')->toArray();
        $hasItems = OrderedItem::whereIn('cart_id',$activeCartIds)->count();
        if($hasItems>0)
        {
            $hasInOrderItems = OrderedItem::whereIn('cart_id',$activeCartIds)->where('state',OrderedItem::STATE_IN_ORDER)->count();
            if($hasInOrderItems==0)
            {
                $lastOrderedItem = OrderedItem::whereIn('cart_id',$activeCartIds)->latest()->first();
                $timeDiff = Carbon::now()->diffInMinutes($lastOrderedItem->created_at);
                if($timeDiff>15)
                {
                    $this->clear();
                }
            }
        }
        else
        {
            $timeDiff = Carbon::now()->diffInMinutes($this->updated_at);
            if($timeDiff>15)
            {
                $this->clear();
            }
        }
    }

    /**
     * @return array
     */
    public function userIds()
    {
        return $this->carts()->where('active',true)->distinct()->get(['user_id'])->pluck('user_id')->toArray();
    }

    public function setNfcUidAttribute($value) {
        if ( empty($value) ) {
            $this->attributes['nfc_uid'] = NULL;
        } else {
            $this->attributes['nfc_uid'] = $value;
        }
    }
}
