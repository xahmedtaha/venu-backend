<?php

namespace App\Models;

use App\Traits\HasCommonTexts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\FirestoreOperations;

class Branch extends Model
{
    use HasCommonTexts;

    public $appends = ['name'];

    protected $guarded = ['id'];

    public function resturant()
    {
        return $this->belongsTo(Resturant::class);
    }

    public function tables()
    {
        return $this->hasMany(BranchTable::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'branch_items', 'branch_id', 'item_id');
    }

    public function changeItemAvailability(Item $item,$isAvailable)
    {
//        $this->items()->where('id',$item->id)->piv
        $this->items()->updateExistingPivot($item->id,['is_available'=>$isAvailable]);
        FirestoreOperations::getInstance()->addBranchItemAvailability($this, $item->id, $isAvailable);
    }

    function getItems()
    {

    }

    public function getNewOrderNumber()
    {
        return $this->orders()->whereDate('created_at',Carbon::today())->max('order_number') + 1;
    }

    public function attachToResturantItems()
    {
        $items = $this->resturant->items()->pluck('id')->toArray();
        $this->items()->attach($items);
    }
}
