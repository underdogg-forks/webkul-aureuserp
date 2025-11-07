<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;

class ActivityPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $activityPlans = [
            [
                'creator_id' => $user?->id,
                'name'       => 'Offboarding',
                'plugin'     => 'employees',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'creator_id' => $user?->id,
                'name'       => 'Onboarding',
                'plugin'     => 'employees',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('activity_plans')->insert($activityPlans);
    }
}
