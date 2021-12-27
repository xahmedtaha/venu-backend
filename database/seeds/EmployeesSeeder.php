<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employees')->insert([
                'name'=>'Admin',
                'email'=>'admin@venu.com',
                'password'=> bcrypt('123456'),
                'level'=> 'SuperAdmin',
            ]);
        /**
         * @var \App\Models\Employee $admin
         */
        $admin = \App\Models\Employee::first();
        $admin->assignRole(Role::first());
    }
}
