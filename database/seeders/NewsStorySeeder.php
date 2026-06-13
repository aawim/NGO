<?php

namespace Database\Seeders;

use App\Models\NewsStory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewsStorySeeder extends Seeder
{
    public function run(): void
    {
        $stories = [

            [
                'user_id' => null,
                'type' => 'story',
                'title' => 'From Struggle to Success: A Scholarship Changed Fatima’s Future',
                'slug' => 'scholarship-changed-fatimas-future',
                'subtitle' => 'A story of hope through education.',
                'excerpt' => 'Fatima was at risk of dropping out of school until she received an NGO scholarship.',
                'content' => 'Fatima, a 14-year-old student from a rural village, faced significant challenges in continuing her education. Through our scholarship program, she was able to remain in school and is now one of the top-performing students in her district.',
                'featured_image' => 'news/z1XvCqmHTq3qAmXPMvsH27afuWIgo1bn1hiND5Oo.jpg',
                'featured_image_alt' => 'Fatima receiving scholarship support',
                'banner_image' => 'news/z1XvCqmHTq3qAmXPMvsH27afuWIgo1bn1hiND5Oo.jpg',
                'location' => 'Malé, Maldives',
                'event_date' => Carbon::now()->subMonths(2),
                'categories' => ['Education', 'Youth Development'],
                'tags' => ['Scholarship', 'Student Success', 'Education'],
                'status' => 'published',
                'featured' => true,
                'published_at' => Carbon::now()->subMonths(2),
                'views' => 2450,
                'meta_title' => 'Scholarship Program Success Story',
                'meta_description' => 'Learn how educational support transformed Fatima’s future.',
                'meta_keywords' => 'education, scholarship, NGO, youth',
                'facebook_title' => 'Fatima’s Journey to Success',
                'twitter_title' => 'Scholarship Success Story',
                'beneficiary_name' => 'Fatima Hassan',
                'beneficiary_photo' => 'beneficiaries/fatima.jpg',
                'impact_summary' => 'One scholarship enabled a student to remain in school and excel academically.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => null,
                'type' => 'news',
                'title' => 'NGO Launches Emergency Food Relief Program',
                'slug' => 'ngo-launches-emergency-food-relief-program',
                'subtitle' => 'Supporting vulnerable families during difficult times.',
                'excerpt' => 'Over 500 families received emergency food packages during the first phase.',
                'content' => 'Our emergency food relief initiative successfully distributed food supplies to more than 500 vulnerable households. Volunteers worked tirelessly to ensure timely delivery across affected communities.',
                'featured_image' => 'news/fwbKoQzlI3THNIDZnKt2JE2KrDuIE3UFea30s0xB.webp',
                'featured_image_alt' => 'Food distribution activity',
                'banner_image' => 'news/fwbKoQzlI3THNIDZnKt2JE2KrDuIE3UFea30s0xB.webp',
                'location' => 'Addu City, Maldives',
                'event_date' => Carbon::now()->subWeeks(3),
                'categories' => ['Food Aid', 'Community Development'],
                'tags' => ['Food Relief', 'Emergency Response'],
                'status' => 'published',
                'featured' => true,
                'published_at' => Carbon::now()->subWeeks(3),
                'views' => 1780,
                'meta_title' => 'Emergency Food Relief Program',
                'meta_description' => 'Food assistance for vulnerable families.',
                'meta_keywords' => 'food aid, emergency relief, NGO',
                'facebook_title' => 'Emergency Food Relief',
                'twitter_title' => 'Food Aid Initiative',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => null,
                'type' => 'event_update',
                'title' => 'Community Clean-Up Campaign Removes 2 Tons of Waste',
                'slug' => 'community-cleanup-campaign-removes-2-tons-of-waste',
                'subtitle' => 'Volunteers unite for a cleaner environment.',
                'excerpt' => 'More than 200 volunteers participated in the island-wide cleanup effort.',
                'content' => 'The environmental awareness campaign brought together volunteers, schools, and local businesses. Together they collected and properly disposed of more than two tons of waste.',
                'featured_image' => 'news/lkI0DOIhvkFSCLxYIjWeWZWjFJKiFM6O1VpYSiTE.jpg',
                'featured_image_alt' => 'Volunteers cleaning the beach',
                'banner_image' => 'news/lkI0DOIhvkFSCLxYIjWeWZWjFJKiFM6O1VpYSiTE.jpgg',
                'location' => 'Hulhumalé, Maldives',
                'event_date' => Carbon::now()->subMonth(),
                'categories' => ['Environment', 'Community Development'],
                'tags' => ['Cleanup', 'Volunteers', 'Environment'],
                'status' => 'published',
                'featured' => false,
                'published_at' => Carbon::now()->subMonth(),
                'views' => 950,
                'meta_title' => 'Community Clean-Up Success',
                'meta_description' => 'Volunteers remove waste and improve local environment.',
                'meta_keywords' => 'environment, cleanup, volunteers',
                'facebook_title' => 'Community Cleanup Event',
                'twitter_title' => 'Environmental Action Day',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => null,
                'type' => 'impact_report',
                'title' => '2025 Annual Impact Report Released',
                'slug' => '2025-annual-impact-report-released',
                'subtitle' => 'A year of measurable impact and growth.',
                'excerpt' => 'Our annual report highlights achievements across education, health, and community programs.',
                'content' => 'The 2025 Annual Impact Report summarizes our achievements, including supporting over 5,000 beneficiaries, training 300 volunteers, and implementing 25 community projects.',
                'featured_image' => 'news/poMqSwFbQHqfg54MiMWJptDo0D1v2GQ7ypXTRdyS.jpg',
                'featured_image_alt' => 'Annual impact report cover',
                'banner_image' => 'news/poMqSwFbQHqfg54MiMWJptDo0D1v2GQ7ypXTRdyS.jpg',
                'location' => 'Maldives',
                'event_date' => Carbon::now()->subWeeks(1),
                'categories' => ['Impact Report', 'Community Development'],
                'tags' => ['Annual Report', 'Impact', 'Transparency'],
                'status' => 'published',
                'featured' => true,
                'published_at' => Carbon::now()->subWeek(),
                'views' => 3200,
                'meta_title' => '2025 NGO Annual Impact Report',
                'meta_description' => 'Read about our achievements and impact throughout the year.',
                'meta_keywords' => 'annual report, NGO impact, transparency',
                'facebook_title' => '2025 Impact Report',
                'twitter_title' => 'Annual Impact Report Released',
                'impact_summary' => '5,000+ beneficiaries reached and 25 community projects completed.',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        foreach ($stories as $story) {
            NewsStory::create($story);
        }
    }
}
