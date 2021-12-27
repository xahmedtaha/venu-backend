<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SubProduct;
use Faker\Generator as Faker;

$factory->define(SubProduct::class, function (Faker $faker) {
    return [
        "price_before" => rand(30,50),
        "price_after" => rand(30,50),
        "description_ar" => "ساندوتش",
        "description_en" => "ساندوتش",
    ];
});

$factory->afterCreating(SubProduct::class,function($subProduct,$faker)
{
    $subProduct->images()->create(["image"=>"sub_product_images/test.jpeg"]);
});
