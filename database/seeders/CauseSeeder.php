<?php

namespace Database\Seeders;

use App\Models\Cause;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CauseSeeder extends Seeder
{
   public function run()
    {
        $causes = [
            [
                'title' => 'Global Disaster Relief Fund',
                'slug' => Str::slug('Global Disaster Relief Fund'),
                'description' => "Our rapid response fund allows us to deploy teams and resources within 24 hours of a natural disaster. Your donation ensures we are always ready to respond to earthquakes, hurricanes, and floods.",
                'goal_amount' => 500000.00,
                'raised_amount' => 125400.00,
                'image' => 'causes/opnd7BM0YuS2I90i3XgIRUoUxyOFFmunEcAZkv3X.jpg',
                'featured' => true,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Girls Education Initiative',
                'slug' => Str::slug('Girls Education Initiative'),
                'description' => "We believe every girl deserves an education. This ongoing cause funds scholarships, school supplies, and safe transportation for young women in developing nations.",
                'goal_amount' => 200000.00,
                'raised_amount' => 185000.00,
                'image' => 'causes/fprBDfDz5ERokYIDp2GoxVsJqOzLVNz1K9D32T9t.jpg',
                'featured' => true,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ocean Cleanup Operations',
                'slug' => Str::slug('Ocean Cleanup Operations'),
                'description' => "Supporting local coastal communities in removing plastic waste from marine habitats and establishing sustainable recycling programs.",
                'goal_amount' => 75000.00,
                'raised_amount' => 75000.00,
                'image' => 'causes/PLS5Ax1eCWhmfyvM5i2Y1DEqsDOx2lUJHz2qxrin.jpg',
                'featured' => false,
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Cause::insert($causes);
    }
}
