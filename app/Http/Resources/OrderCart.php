<?php

namespace App\Http\Resources;

use App\Models\OrderedItem as OrderedItemModel;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = [
            "id" =>  $this->id,
            "total" => $this->total,
            "owner_name" => $this->user->name??'',
            "cart_items" => OrderedItem::collection($this->orderedItems()->where('state',OrderedItemModel::STATE_IN_ORDER)->get())
        ];
        return $array;
    }
}
