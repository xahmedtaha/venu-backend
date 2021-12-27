<?php

use App\Models\Place;
use Illuminate\Database\Seeder;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $place = Place::create(
            [
                'name_ar'=>'سوهاج',
                'name_en'=>'Suhag',
            ]);
        
        $cities = 
        [
            [
                'name_en'=>'',
                'name_ar'=>'شارع 15'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع الحميات'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع الجمهورية'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'المخبز الالى'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع اسيوط سوهاج'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'العارف'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع المحطة'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع البحر'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'الشهيد'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'ميدان العروبة'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'ميدان الثقافة'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'المحافظة'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'منطقة كاذالوفى'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع سيتى'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'شارع الجوازات'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'الزهراء'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'ال3 كبارى'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'طريق سوهاج اخميم'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'الحويتى'
            ],
            [
                'name_en'=>'',
                'name_ar'=>'الارقم',
            ]

        ];
        $place->cities()->createMany($cities);
    }
}
