<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Addresses extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang = $request->header('accept-language','ar');
        $name_attr = "name_".$lang; 
        return [
            "addressName" => $this->address
                            .' - '.$this->city->$name_attr
                            .' - '.$this->place->$name_attr,
            "addressLat" => $this->lat,
            "addressLng" => $this->long,
            "addressBuilding" => $this->building,
            "addressFloor" => $this->floor,
            "addressFlat" => $this->flat,
            "addressPlace" => $this->place->$name_attr,
            "addressCity" => $this->city->$name_attr,

        ];
    }
}
