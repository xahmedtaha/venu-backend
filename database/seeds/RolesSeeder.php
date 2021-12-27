<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            //Reports
            [
                "name"=>"view reports",
                "name_ar"=>"عرض التقارير",
                "guard_name"=>"web"
            ]
            //product categories
            ,[
                "name"=>"view product categories",
                "name_ar"=>"عرض انواع المنتجات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add product categories",
                "name_ar"=>"اضافة انواع المنتجات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update product categories",
                "name_ar"=>"تعديل انواع المنتجات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete product categories",
                "name_ar"=>"حذف انواع المنتجات",
                "guard_name"=>"web"
            ]
            //branches
            ,[
                "name"=>"view branches",
                "name_ar"=>"عرض الفروع",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add branches",
                "name_ar"=>"اضافة الفروع",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update branches",
                "name_ar"=>"تعديل الفروع",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete branches",
                "name_ar"=>"حذف الفروع",
                "guard_name"=>"web"
            ]
            //waiter
            ,[
                "name"=>"view waiter",
                "name_ar"=>"عرض waiter",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add waiter",
                "name_ar"=>"اضافة waiter",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update waiter",
                "name_ar"=>"تعديل waiter",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete waiter",
                "name_ar"=>"حذف waiter",
                "guard_name"=>"web"
            ]
            //resturants
            ,[
                "name"=>"view resturants",
                "name_ar"=>"عرض المطاعم",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add resturants",
                "name_ar"=>"اضافة المطاعم",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update resturants",
                "name_ar"=>"تعديل المطاعم",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete resturants",
                "name_ar"=>"حذف المطاعم",
                "guard_name"=>"web"
            ]
            //products
            ,[
                "name"=>"view products",
                "name_ar"=>"عرض المنتجات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add products",
                "name_ar"=>"اضافة المنتجات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update products",
                "name_ar"=>"تعديل المنتجات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete products",
                "name_ar"=>"حذف المنتجات",
                "guard_name"=>"web"
            ]
            //sizes
            ,[
                "name"=>"view sizes",
                "name_ar"=>"عرض الاحجام",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add sizes",
                "name_ar"=>"اضافة الاحجام",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update sizes",
                "name_ar"=>"تعديل الاحجام",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete sizes",
                "name_ar"=>"حذف الاحجام",
                "guard_name"=>"web"
            ]
            //sides
            ,[
                "name"=>"view sides",
                "name_ar"=>"عرض وحدات الاضافة",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add sides",
                "name_ar"=>"اضافة وحدات الاضافة",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update sides",
                "name_ar"=>"تعديل وحدات الاضافة",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete sides",
                "name_ar"=>"حذف وحدات الاضافة",
                "guard_name"=>"web"
            ]
            //lists
            ,[
                "name"=>"view lists",
                "name_ar"=>"عرض الليستات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add lists",
                "name_ar"=>"اضافة الليستات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update lists",
                "name_ar"=>"تعديل الليستات",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete lists",
                "name_ar"=>"حذف الليستات",
                "guard_name"=>"web"
            ]
            //resturant owners
            ,[
                "name"=>"view resturant owners",
                "name_ar"=>"عرض حسابات اصحاب المطاعم",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add resturant owners",
                "name_ar"=>"اضافة حسابات اصحاب المطاعم",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update resturant owners",
                "name_ar"=>"تعديل حسابات اصحاب المطاعم",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete resturant owners",
                "name_ar"=>"حذف حسابات اصحاب المطاعم",
                "guard_name"=>"web"
            ]
            //employees
            ,[
                "name"=>"view employees",
                "name_ar"=>"عرض الموظفين",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add employees",
                "name_ar"=>"اضافة الموظفين",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update employees",
                "name_ar"=>"تعديل الموظفين",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"delete employees",
                "name_ar"=>"حذف الموظفين",
                "guard_name"=>"web"
            ]
            //roles
            ,[
                "name"=>"view roles",
                "name_ar"=>"عرض مجموعات المستخدمين",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"add roles",
                "name_ar"=>"اضافة مجموعات المستخدمين",
                "guard_name"=>"web"
            ]
            ,[
                "name"=>"update roles",
                "name_ar"=>"تعديل مجموعات المستخدمين",
                "guard_name"=>"web"
            ],[
                "name"=>"delete roles",
                "name_ar"=>"حذف مجموعات المستخدمين",
                "guard_name"=>"web"
            ]

            ]);
        /**
         * @var Role $role
         */
        $role = Role::create([
           "name" => "super Admin",
           "name_ar" => "سوبر ادمن",
           "guard_name" => "web"
        ]);
        $permissions = Permission::query()->pluck('name')->toArray();
        $role->givePermissionTo($permissions);
    }
}
