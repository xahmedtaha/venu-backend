<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ResturantProductCategory;
use Faker\Generator as Faker;

$factory->define(ResturantProductCategory::class, function (Faker $faker) {
    return [
        "name_ar"=>"نوع ".rand(1,2),
        "name_en"=>"category".rand(1,2)
    ];
});
