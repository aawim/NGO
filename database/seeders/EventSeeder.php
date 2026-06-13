<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
  public function run()
    {
        $events = [
            [
                'title' => 'Annual Charity Gala 2026',
                'description' => 'Join us for our biggest fundraising night of the year. Featuring keynote speakers, a silent auction, and live entertainment. All proceeds go toward our education initiatives.',
                'location' => 'Grand Horizon Hotel, Downtown',
                'event_date' => Carbon::now()->addMonths(2)->setTime(18, 30, 0), // 6:30 PM
                'goal_amount' => 100000.00,
                'raised_amount' => 45000.00, // Ticket sales / pre-donations
                'image'=>'events/r3ckNXjABbpEu69KmFdTZ92Zl3wkk4J8cLrWAU3a.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Run for Water 5K',
                'description' => 'A community 5K run/walk to raise awareness and funds for global clean water access. Participants will receive a custom t-shirt and medal.',
                'location' => 'Centennial Park',
                'event_date' => Carbon::now()->addDays(15)->setTime(8, 0, 0), // 8:00 AM
                'goal_amount' => 25000.00,
                'raised_amount' => 12500.00,
                'image'=>'events/K5E6GrYYYrzyN8x8MwdXFNAaooxQcP3NJbMYJuti.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Virtual Town Hall: Q3 Impact Report',
                'description' => 'An online webinar where our directors will discuss the impact of your donations over the last quarter and outline our goals for the rest of the year.',
                'location' => 'Zoom (Link provided upon registration)',
                'event_date' => Carbon::now()->subDays(5)->setTime(14, 0, 0), // Past event
                'goal_amount' => 0.00, // Non-fundraising event
                'raised_amount' => 0.00,
                'image'=>'events/WAiXsGfVSJCfIlXzwhEpDEq5u0MjNVKMa8xjmvmN.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Event::insert($events);
    }
}
