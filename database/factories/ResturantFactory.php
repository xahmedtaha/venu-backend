<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Resturant;

$factory->state(Resturant::class,'cairo',[
    'lat'=>30.047690,
    "long"=>31.347915,
]);
$factory->state(Resturant::class,'suhag',[
    'lat'=>26.55904998407556,
    "long"=>31.7010498046875,
]);

$factory->define(Resturant::class, function (Faker $faker) {
    return [
        "name_ar"=>"مطعم ".Resturant::count(),
        "name_en"=>"Restaurant ".Resturant::count(),
        "description_ar"=>"تجريى",
        "description_en"=>"test",
        "delivery_time"=>rand(15,60),
        "phone_number"=>rand(10000000,99999999),
        "discount"=>rand(1,5),
        "vat_value"=>0,
        "vat_on_total"=>0,
        "place"=>"address",
        "lat"=>30.047690,
        "long"=>31.347915,
        "logo"=>'resturant_images/test.jpeg',
        "open_time"=>"12:00 am",
        "close_time"=>"12:00 pm",
        "is_active"=>1,
    ];
});

$factory->afterCreating(Resturant::class,function($resturant,$faker)
{
    $resturant->products()->createMany(factory(Product::class,20)->make()->toArray());
});