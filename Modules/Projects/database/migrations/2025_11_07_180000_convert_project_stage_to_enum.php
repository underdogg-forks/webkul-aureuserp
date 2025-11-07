<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Map old stage names to enum values
        $stageMapping = [
            'To Do'       => 'to_do',
            'In Progress' => 'in_progress',
            'Done'        => 'done',
            'Cancelled'   => 'cancelled',
        ];

        // Create a temporary column for the enum value
        Schema::table('projects_projects', function (Blueprint $table) {
            $table->string('stage_enum')->nullable()->after('stage_id');
        });

        // Convert existing stage_id foreign keys to enum values
        $stages = DB::table('projects_project_stages')->get();
        foreach ($stages as $stage) {
            $enumValue = $stageMapping[$stage->name] ?? null;
            if ($enumValue) {
                DB::table('projects_projects')
                    ->where('stage_id', $stage->id)
                    ->update(['stage_enum' => $enumValue]);
            }
        }

        // Drop the foreign key constraint and old column
        Schema::table('projects_projects', function (Blueprint $table) {
            $table->dropForeign(['stage_id']);
            $table->dropColumn('stage_id');
        });

        // Rename the temporary column to stage
        Schema::table('projects_projects', function (Blueprint $table) {
            $table->renameColumn('stage_enum', 'stage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse mapping
        $stageMapping = [
            'to_do'       => 'To Do',
            'in_progress' => 'In Progress',
            'done'        => 'Done',
            'cancelled'   => 'Cancelled',
        ];

        // Create stage_id column
        Schema::table('projects_projects', function (Blueprint $table) {
            $table->foreignId('stage_id')
                ->nullable()
                ->after('is_active')
                ->constrained('projects_project_stages')
                ->restrictOnDelete();
        });

        // Convert enum values back to foreign keys
        foreach ($stageMapping as $enumValue => $stageName) {
            $stage = DB::table('projects_project_stages')->where('name', $stageName)->first();
            if ($stage) {
                DB::table('projects_projects')
                    ->where('stage', $enumValue)
                    ->update(['stage_id' => $stage->id]);
            }
        }

        // Drop the enum column
        Schema::table('projects_projects', function (Blueprint $table) {
            $table->dropColumn('stage');
        });
    }
};
