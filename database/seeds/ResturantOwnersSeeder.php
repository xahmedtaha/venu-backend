<?php

use Illuminate\Database\Seeder;
use App\Models\Resturant;

class ResturantOwnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('resturant_owners')->insert([
            'name'=>'owner1',
            'email'=>'owner@foodbook-me.com',
            'password'=> bcrypt('123456'),
            'resturant_id' => Resturant::first()->id,
        ]);
    }
}
