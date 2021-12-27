<?php

use App\Models\Waiter;
use Illuminate\Database\Seeder;

class WaiterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Waiter::create([
            'resturant_id' => 1,
            'branch_id' => 1,
            'name' => 'Waiter',
            'email' => 'waiter@venu.com',
            'password' => bcrypt('123456')
        ]);
    }
}
