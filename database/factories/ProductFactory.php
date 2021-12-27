<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name_ar"=>"منتج",
        "name_en"=>"product",
        "price_before"=>rand(20,30),
        "price_after"=>rand(50,70),
        "discount"=>0,
        "offer"=>0,
        "description_ar"=>"تجريبى",
        "description_en"=>"test",
    ];
});

$factory->afterCreating(Product::class,function($product,$faker)
{
    $product->update([
        "name_ar"=>$product->name_ar.$product->id,
        "name_en"=>$product->name_en.$product->id,
    ]);
    $product->images()->create(["image"=>"product_images/test.jpeg"]);

});
