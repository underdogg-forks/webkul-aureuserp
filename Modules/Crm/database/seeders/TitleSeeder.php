<?php

namespace Modules\Crm\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Note: This seeder is now deprecated as Title has been converted to an enum.
     * The table partners_titles is no longer used.
     */
    public function run(): void
    {
        // This seeder is intentionally left empty as Title is now an enum
        // and no longer requires database seeding.
    }
}
