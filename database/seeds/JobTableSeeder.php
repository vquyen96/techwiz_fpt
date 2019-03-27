<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'title' => 'Graphic Designer',
            'benefit' => 'Attractive training courses: Build Trust, Master Your Communication, Leadership ...',
            'description' => '•	Design all branding & media for assigned brands: POSM, Below-the-line materials, 
                                Digital advertisements….
                                •	Continually improve the design of each assigned brand so that it effectively 
                                engages its target audience
                                •	Establish visual communication across all products and platforms
                                •	Actively contribute creative ideas for campaigns’ concept in year.',
            'requirement' => '- 1 - 2 years of design experience, including BTL & Digital design
                            - Strong communication and organizational skills
                            - Ability to excel both independently and in a collaborative team environment
                            - In-depth knowledge of graphic design principles, standards, and techniques
                            - Ability to think creatively and conceptually
                            - Excellent time-management skills, including an ability to multitask',
            'keyword' => 'Nghệ thuật, Mỹ thuật, Thiết kế đồ họa',
            'language' => 'Bất kỳ',
            'rank' => '',
            'start_date' => '',
            'expired_date' => '',
            'category_id' => '',
            'locations' => '',
            'salary' => '',
            'year_experience' => ''
        ]);


    }
}
