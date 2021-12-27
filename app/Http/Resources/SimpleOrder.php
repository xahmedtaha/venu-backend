<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" =>$this->id ,
            "date" =>$this->created_at->format('Y-m-d h:i:s a') ,
            "resturant" =>$this->resturant->name ,
            "resturantLogo" =>$this->resturant->getLogoUrl() ,
            "tax" =>$this->tax_value ,
            "service" =>$this->service_value ,
            "sub_total" =>$this->sub_total ,
            "total" =>$this->total ,
            "order_number" =>$this->order_number ,
            "rates" => $this->rates
        ];
    }
}
