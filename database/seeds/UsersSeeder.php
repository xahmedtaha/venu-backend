<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement("INSERT INTO `users` (`id`, `name_en`, `email`, `password`, `phone_number`, `facebook_token`, `google_token`, `firebase_token`, `deleted_at`, `created_at`, `updated_at`, `name_ar`) VALUES
        ('1', 'hossam', 'hossammohsen37@gmail.com', '$2y$10$wlofdoezDU.3J9IdRQvaOuIXEUPwPm/Mq0Plefxn5tHWOEwFF4iYO', '01001063536', NULL, NULL, NULL, NULL, NULL, NULL, 'حسام'),
        ('2', 'Ninja', 'ninja@gmail.com', '$2y$10$wlofdoezDU.3J9IdRQvaOuIXEUPwPm/Mq0Plefxn5tHWOEwFF4iYO', '012045556262', NULL, NULL, 'c6W90zFwVAQ:APA91bFh8UN_x3UQgVHBMTvMs4fx5-uSBCp73EdMAex-tA8E5F-z65QTwlv_JzA6bckZ1XRlPtwCA6c7mx4Etg4epcVevAGxaJlib5GAOM9sM3yG8_2FW0ld1EAJy3yXoXuA5r9uzURa', NULL, NULL, NULL, 'نينجا');
        
        INSERT INTO `addresses` (`id`, `user_id`, `lat`, `long`, `address`, `flat`, `floor`, `building`, `created_at`, `updated_at`) VALUES
        ('1', '1', '26.574093380827254', '31.737801551818848', 'سوهاج', '1', '11', NULL, NULL, NULL),
        ('2', '2', '26.574093380827254', '31.737801551818848', 'سوهاج', '1', '1', '11', NULL, NULL);    
        
        INSERT INTO `products` (`id`, `name_ar`, `price_before`, `price_after`, `discount`, `resturant_id`, `offer`, `deleted_at`, `created_at`, `updated_at`, `name_en`, `description_ar`, `description_en`) VALUES
        ('1', 'ساندوتش', '20.00', '20.00', NULL, 1, NULL, NULL, '2019-08-25 01:34:12', '2019-08-25 01:34:12', 'sandwich', 'تست', 'test'),
        ('2', 'ساندوتش', '20.00', '20.00', NULL, 1, NULL, NULL, '2019-08-25 01:34:36', '2019-08-25 01:34:36', 'sandwich', 'تست', 'test'),
        ('3', 'ساندوتش', '20.00', '20.00', NULL, 1, NULL, NULL, '2019-08-25 01:35:25', '2019-08-25 01:35:25', 'sandwich', 'تست', 'test'),
        ('4', 'ساندوتش', '20.00', '20.00', NULL, 1, NULL, NULL, '2019-08-26 19:32:37', '2019-08-26 19:32:37', 'sandwich', 'تجريبى', 'Test'),
        ('5', 'ساندوتش', '20.00', '20.00', NULL, 1, NULL, NULL, '2019-08-26 19:33:50', '2019-08-26 19:33:50', 'sandwich', 'تجريبى', 'Test');");
    }
}
