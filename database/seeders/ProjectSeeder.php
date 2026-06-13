<?php

namespace Database\Seeders;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
  public function run()
    {
        $projects = [
            [
                'title' => 'Clean Water Well Installation',
                'slug' => Str::slug('Clean Water Well Installation'),
                'short_description' => 'Providing a sustainable source of clean drinking water to over 5,000 residents.',
                'description' => '<p>This project aims to drill three deep-water wells and install solar-powered pumps. Access to clean water will reduce waterborne diseases by 80% in the region.</p>',
                'location' => 'Nairobi, Kenya',
                'budget' => 45000.00,
                'raised_amount' => 32500.00,
                'image' => 'projects/qZ2IpzG6aCrdhOKbgG950P2mjMxCStIkFKgNuqKV.jpg',
                'status' => 'Active',
                'start_date' => Carbon::now()->subMonths(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonths(6)->format('Y-m-d'),
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rural School Rebuilding',
                'slug' => Str::slug('Rural School Rebuilding'),
                'short_description' => 'Reconstructing a primary school destroyed by the earthquake.',
                'description' => '<p>Education is the foundation of recovery. We are working with local contractors to build 6 earthquake-resistant classrooms and a library.</p>',
                'location' => 'Kathmandu, Nepal',
                'budget' => 120000.00,
                'raised_amount' => 120000.00,
                'image' => 'projects/ogdN2xBPrAsXgwZQci7fsr2cGcEuVPdSgpJe9mkv.jpg',
                'status' => 'Completed',
                'start_date' => Carbon::now()->subYear()->format('Y-m-d'),
                'end_date' => Carbon::now()->subMonths(1)->format('Y-m-d'),
                'featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Emergency Medical Supply Drop',
                'slug' => Str::slug('Emergency Medical Supply Drop'),
                'short_description' => 'Delivering critical trauma kits and antibiotics to frontline medical clinics.',
                'description' => '<p>Supply chains have broken down, leaving doctors without basic necessities. This project funds direct distribution of medical gear.</p>',
                'location' => 'Aleppo, Syria',
                'budget' => 75000.00,
                'raised_amount' => 15400.00,
                'image' => 'projects/Cgpa9eRLRkQoxPLHKGHdfmUtEanDPwwMQSoU1UYj.webp',
                'status' => 'Planned',
                'start_date' => Carbon::now()->addMonths(1)->format('Y-m-d'),
                'end_date' => Carbon::now()->addMonths(3)->format('Y-m-d'),
                'featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Project::insert($projects);
    }
}
