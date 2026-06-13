<?php
namespace Database\Seeders;

use App\Models\Volunteer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VolunteerSeeder extends Seeder
{

    public function run()
    {
        $volunteers = [
            [
                'user_id'      => null,
                'image'        => 'volunteers/tvK4LtjJK4ftKIl8AhTDtvHX4PS3hgy98WvWAtS8.webp',
                'name'         => 'Sarah Jenkins',
                'email'        => 's.jenkins@example.com',
                'phone'        => '+1 (555) 123-4567',
                'skills'       => ['Medical', 'First Aid', 'Nursing'],
                'availability' => 'Weekends',
                'status'       => 'active',
                'created_at'   => Carbon::now()->subDays(10),
                'updated_at'   => Carbon::now()->subDays(10),
            ],
            [
                'user_id'      => null,
                'image'        => 'volunteers/udb2f2WRPfnAUFpzQdcqjSwd7BgBLOt5sjx70oLh.webp',
                'name'         => 'Marcus Chen',
                'email'        => 'm.chen99@example.com',
                'phone'        => '+1 (555) 987-6543',
                'skills'       => ['IT Support', 'Web Development'],
                'availability' => 'Evenings',
                'status'       => 'active',
                'created_at'   => Carbon::now()->subDays(5),
                'updated_at'   => Carbon::now()->subDays(5),
            ],
            [
                'user_id'      => null,
                'image'        => 'volunteers/YOZQCP3ZOWWUDBYce2FLttGLNsCzXynpuOHfJPgQ.jpg',
                'name'         => 'Elena Rodriguez',
                'email'        => 'elena.r@example.com',
                'phone'        => '+1 (555) 456-7890',
                'skills'       => ['Logistics', 'Heavy Machinery', 'Spanish Translation'],
                'availability' => 'Anytime',
                'status'       => 'pending',
                'created_at'   => Carbon::now()->subDays(2),
                'updated_at'   => Carbon::now()->subDays(2),
            ],
            [
                'user_id'      => null,
                'image'        => 'volunteers/fOsqcum779wveLtczdjOfAjFoeS6zYZIIlaqZ7mT.webp',
                'name'         => 'David Thompson',
                'email'        => 'd.thompson@example.com',
                'phone'        => '+1 (555) 222-3333',
                'skills'       => ['Event Organization', 'Public Speaking'],
                'availability' => 'Weekdays',
                'status'       => 'inactive',
                'created_at'   => Carbon::now()->subMonths(3),
                'updated_at'   => Carbon::now()->subMonths(1),
            ],
            [
                'user_id'      => null,
                'image'        => 'volunteers/QVQdC3j6OeFBqgYXrOrE0rUvbbvguhJIx2Et3oEr.jpg',
                'name'         => 'Aisha Patel',
                'email'        => 'apatel.volunteer@example.com',
                'phone'        => '+1 (555) 777-8888',
                'skills'       => ['Teaching', 'Childcare', 'Art Therapy'],
                'availability' => 'Weekends',
                'status'       => 'active',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ];

        foreach ($volunteers as $volunteer) {
            Volunteer::create($volunteer);
        }
    }

    // public function run()
    // {
    //     // 1. Ensure we have at least a few users to attach volunteers to.
    //     // If your database is empty, this will create 3 dummy users safely.
    //     $users = User::take(3)->get();
    //     if ($users->count() < 3) {
    //         $users = collect([
    //             User::firstOrCreate(['email' => 'volunteer1@example.com'], ['name' => 'Sarah Jenkins', 'password' => bcrypt('password')]),
    //             User::firstOrCreate(['email' => 'volunteer2@example.com'], ['name' => 'Marcus Chen', 'password' => bcrypt('password')]),
    //             User::firstOrCreate(['email' => 'volunteer3@example.com'], ['name' => 'Elena Rodriguez', 'password' => bcrypt('password')]),
    //         ]);
    //     }

    //     $volunteers = [
    //         [
    //             'user_id' => null, // Linked to a user
    //             // Because skills is a JSON column, we must json_encode the array when using insert()
    //             'skills' => json_encode(['Medical', 'First Aid', 'Nursing']),
    //             'phone' => '+1 (555) 123-4567',
    //             'availability' => 'Weekends',
    //             'status' => 'active',
    //             'image' => null,
    //             'created_at' => Carbon::now()->subDays(10),
    //             'updated_at' => Carbon::now()->subDays(10),
    //         ],
    //         [
    //             'user_id' => null, // Linked to a user
    //             'skills' => json_encode(['IT Support', 'Web Development']),
    //             'phone' => '+1 (555) 987-6543',
    //             'availability' => 'Evenings',
    //             'status' => 'active',
    //             'image' => null,
    //             'created_at' => Carbon::now()->subDays(5),
    //             'updated_at' => Carbon::now()->subDays(5),
    //         ],
    //         [
    //             'user_id' => null, // Not linked to any user (nullable)
    //             'skills' => json_encode(['Logistics', 'Heavy Machinery']),
    //             'phone' => '+1 (555) 456-7890',
    //             'availability' => 'Anytime',
    //             'status' => 'pending',
    //             'image' => null,
    //             'created_at' => Carbon::now()->subDays(2),
    //             'updated_at' => Carbon::now()->subDays(2),
    //         ],
    //         [
    //             'user_id' => $users[2]->id, // Linked to a user
    //             'skills' => json_encode(['Teaching', 'Childcare', 'Art Therapy']),
    //             'phone' => '+1 (555) 777-8888',
    //             'availability' => 'Weekdays',
    //             'status' => 'inactive',
    //             'image' => null,
    //             'created_at' => Carbon::now(),
    //             'updated_at' => Carbon::now(),
    //         ],
    //     ];

    //     Volunteer::insert($volunteers);
    // }
}
