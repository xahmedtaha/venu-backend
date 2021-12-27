<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderedItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $array = [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total' => $this->total,
            'name' => $this->item->name,
            'item_id' => $this->item->id,
            'size_id' => $this->size_id,
            'size_name' => $this->size->name,
            'images_url' => $this->item->images_url,
            'is_in_kitchen' => $this->is_in_kitchen,
            'sides' => OrderedItemSide::collection($this->sides),
            'comment' => $this->comment
        ];
        return $array;
    }
}
