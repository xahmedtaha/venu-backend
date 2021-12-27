<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Place;
use App\Models\Resturant;
use App\Models\Product;
use App\Models\ResturantProductCategory;
use App\Models\SubProduct;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(EmployeesSeeder::class);
    //     factory(Category::class, 10)->create()->each(function ($category)
    //     {

    //         $place = Place::first();
    //         $place_id = $place->id;
    //         $city_id = $place->cities()->first()->id;
    //         $category->update([
    //             "name_ar"=>$category->name_ar.$category->id,
    //             "name_en"=>$category->name_en.$category->id,
    //         ]);

    //         $cairoResturants = factory(Resturant::class,20)->states('cairo')->make([
    //             "place_id"=>$place_id,
    //             "city_id"=>$city_id,
    //         ]);
    //         foreach($cairoResturants as $cairoResturant)
    //         {
    //             $category->resturants()->save($cairoResturant);

    //             $productCategories = factory(ResturantProductCategory::class,2)->create([
    //                 'resturant_id'=>$cairoResturant->id
    //             ]);

    //             $cairoResturant->images()->create(["image"=>"resturant_images/test.jpeg"]);
    //             $cairoResturant->update([
    //                 "name_ar"=>$cairoResturant->name_ar.$cairoResturant->id,
    //                 "name_en"=>$cairoResturant->name_en.$cairoResturant->id,
    //                 'lat'=>$cairoResturant->lat + (rand(1,10)/1000),
    //                 'long'=>$cairoResturant->long + (rand(1,10)/1000),
    //             ]);
    //             $cairoProducts = factory(Product::class,10)->make();
    //             foreach($cairoProducts as $index=>$cairoProduct)
    //             {
    //             if($index<5)
    //                     $cairoProduct->category_id = $cairoResturant->productCategories->first()->id;
    //                 else
    //                     $cairoProduct->category_id = $cairoResturant->productCategories()->orderBy('id','desc')->first()->id;

    //                 $cairoResturant->products()->save($cairoProduct);
    //                 $cairoProduct->update([
    //                     "name_ar"=>$cairoProduct->name_ar.$cairoProduct->id,
    //                     "name_en"=>$cairoProduct->name_en.$cairoProduct->id,
    //                 ]);
    //                 $cairoProduct->images()->create(["image"=>"product_images/test.jpeg"]);
    //                 $subProducts = factory(SubProduct::class,3)->create([
    //                     "name_ar" => $cairoProduct->name_ar,
    //                     "name_en" => $cairoProduct->name_en,
    //                     "resturant_id" => $cairoProduct->resturant_id,
    //                     "product_id" => $cairoProduct->id,
    //                 ]);
    //             }

    //         }

    //         $suhagResturants = factory(Resturant::class,20)->make([
    //             'lat'=>26.55904998407556+(rand(1,10)/1000),
    //             "long"=>31.7010498046875+(rand(1,10)/1000),
    //             "place_id"=>$place_id,
    //             "city_id"=>$city_id,
    //         ]);
    //         foreach($suhagResturants as $suhagResturant)
    //         {
    //             $category->resturants()->save($suhagResturant);
    //             $productCategories = factory(ResturantProductCategory::class,2)->create([
    //                 'resturant_id'=>$suhagResturant->id
    //             ]);
    //             $suhagResturant->images()->create(["image"=>"resturant_images/test.jpeg"]);
    //             $suhagResturant->update([
    //                 "name_ar"=>$suhagResturant->name_ar.$suhagResturant->id,
    //                 "name_en"=>$suhagResturant->name_en.$suhagResturant->id,
    //             ]);
    //             $suhagProducts = factory(Product::class,10)->make();
    //             foreach($suhagProducts as $suhagProduct)
    //             {
    //                 if($index<5)
    //                     $suhagProduct->category_id = $suhagResturant->productCategories()->first()->id;
    //                 else
    //                     $suhagProduct->category_id = $suhagResturant->productCategories()->orderBy('id','desc')->first()->id;
    //                 $suhagResturant->products()->save($suhagProduct);

    //                 $suhagProduct->update([
    //                     "name_ar"=>$suhagProduct->name_ar.$suhagProduct->id,
    //                     "name_en"=>$suhagProduct->name_en.$suhagProduct->id,
    //                 ]);
    //                 $suhagProduct->images()->create(["image"=>"product_images/test.jpeg"]);
    //                 $subProducts = factory(SubProduct::class,3)->create([
    //                     "name_ar" => $suhagProduct->name_ar,
    //                     "name_en" => $suhagProduct->name_en,
    //                     "resturant_id" => $suhagProduct->resturant_id,
    //                     "product_id" => $suhagProduct->id,
    //                 ]);
    //             }
    //         }
    //     });
    // }
    }
}
