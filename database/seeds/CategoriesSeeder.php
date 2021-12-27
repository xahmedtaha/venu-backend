<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name_ar'=>'سوبر ماركت',
                'name_en'=>'Super Market',
            ],
            [
                'id' => 2,
                'name_ar'=>'الخضروات',
                'name_en'=>'Vegetables',
            ],
        ]);
    }
}
