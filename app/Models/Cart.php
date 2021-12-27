<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'total' => 'float',
        'cart_total' => 'float'
    ];

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class,'cart_id')->with('item');
    }
    public function cartOrderedItems()
    {
        return $this->orderedItems()->where('state',OrderedItem::STATE_IN_CART);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function table()
    {
        return $this->belongsTo(BranchTable::class,'table_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function updateTotal()
    {
        $total = $this->orderedItems()->sum('total');
        $this->update(['total' => $total]);
    }

    public function getCartTotalAttribute()
    {
        return $this->cartOrderedItems()->sum('total');
    }
}
