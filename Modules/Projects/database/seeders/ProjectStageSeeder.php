<?php

namespace Modules\Projects\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;

class ProjectStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Note: This seeder is now deprecated as ProjectStage has been converted to an enum.
     * The table projects_project_stages is no longer used.
     */
    public function run(): void
    {
        // This seeder is intentionally left empty as ProjectStage is now an enum
        // and no longer requires database seeding.
    }
}
