<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderedItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'float',
        'total' => 'float',
        'item_id' => 'integer',
        'size_id' => 'integer',
        'is_in_kitchen' => 'integer'
    ];

    public const STATE_IN_CART = 0;
    public const STATE_IN_ORDER = 1;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function sides()
    {
        return $this->hasMany(OrderedItemSide::class);
    }

    /**
     * Calulates OrderedItem Total Price
     */
    public function calculate()
    {
        $sidesTotal = $this->sides()->sum('price');
        $total = $this->sub_total + $sidesTotal;
        $this->update(['total'=>$total]);
    }

}
