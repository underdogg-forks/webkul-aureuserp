<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;

class UTMMediumSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('utm_mediums')->delete();

        $mediums = [
            'Phone',
            'Direct',
            'Email',
            'Banner',
            'X',
            'Facebook',
            'LinkedIn',
            'Television',
            'Google',
        ];

        $user = User::first();

        DB::table('utm_mediums')->insert(collect($mediums)->map(function ($medium) use ($user) {
            return [
                'name'       => $medium,
                'creator_id' => $user?->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray());
    }
}
