<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class Users extends JsonResource
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
        //Determining user registeration method
        if($this->facebook_token)
        {
            $registeration_method = 'facebook';
        }
        elseif($this->google_token)
        {
            $registeration_method = 'google';
        }
        else {
            $registeration_method = "mail";
        }

        //Getting the user last feedback
        $lastfeedback = $this->feedbacks()->orderBy('id','desc')->first();
        if($lastfeedback)
        {
            $reason = $lastfeedback->reason;
            if($reason)
                $lastfeedback = $reason->$name_attr;
        }
        else {
            $lastfeedback = "";
        }
        
        //getting the user last order and most ordered resturant
        if($this->orders->count()>0)
        {
            $lastOrderResturant = $this->orders()->orderBy('id','desc')->first()->resturant->$name_attr;
            $mostOrderedResturantRow = $this->orders()
                ->select(DB::raw('count(id) as orders_count,resturant_id'))
                ->groupBy('resturant_id')
                ->orderBy('orders_count','desc')
                ->first();

            $mostOrderedResturant = $mostOrderedResturantRow->resturant->$name_attr;
        }
        else {
            $lastOrderResturant = "";
            $mostOrderedResturant = "";
        }
        
        return [
            "id" => $this->id, 
            "name" => $this->name, 
            "email" => $this->email,
            "created_at" => $this->created_at->format('Y-m-d H:i:s a'), 
            "lang" => $this->lang, 
            "phone_number" => $this->phone_number,
            "registeration_method" =>$registeration_method,
            "orders_count" => $this->orders()->count(),
            "last_feedback" => $lastfeedback,
            "last_ordered_resturant" => $lastOrderResturant, 
            "most_ordered_resturant" => $mostOrderedResturant,
            "address" => new Addresses($this->addresses()->first())
        ];
    }
}
