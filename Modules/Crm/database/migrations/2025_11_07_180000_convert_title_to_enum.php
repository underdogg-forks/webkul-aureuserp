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
        // Map old title IDs to enum values
        $titleMapping = [
            'Doctor'    => 'dr',
            'Madam'     => 'mrs',
            'Miss'      => 'miss',
            'Mister'    => 'mr',
            'Professor' => 'prof',
        ];

        // Create a temporary column for the enum value
        Schema::table('partners_partners', function (Blueprint $table) {
            $table->string('title_enum')->nullable()->after('title_id');
        });

        // Convert existing title_id foreign keys to enum values
        $titles = DB::table('partners_titles')->get();
        foreach ($titles as $title) {
            $enumValue = $titleMapping[$title->name] ?? null;
            if ($enumValue) {
                DB::table('partners_partners')
                    ->where('title_id', $title->id)
                    ->update(['title_enum' => $enumValue]);
            }
        }

        // Drop the foreign key constraint and old column
        Schema::table('partners_partners', function (Blueprint $table) {
            $table->dropForeign(['title_id']);
            $table->dropColumn('title_id');
        });

        // Rename the temporary column to title
        Schema::table('partners_partners', function (Blueprint $table) {
            $table->renameColumn('title_enum', 'title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse mapping
        $titleMapping = [
            'dr'   => 'Doctor',
            'mrs'  => 'Madam',
            'miss' => 'Miss',
            'mr'   => 'Mister',
            'prof' => 'Professor',
        ];

        // Create title_id column
        Schema::table('partners_partners', function (Blueprint $table) {
            $table->foreignId('title_id')
                ->nullable()
                ->after('user_id')
                ->constrained('partners_titles')
                ->nullOnDelete();
        });

        // Convert enum values back to foreign keys
        foreach ($titleMapping as $enumValue => $titleName) {
            $title = DB::table('partners_titles')->where('name', $titleName)->first();
            if ($title) {
                DB::table('partners_partners')
                    ->where('title', $enumValue)
                    ->update(['title_id' => $title->id]);
            }
        }

        // Drop the enum column
        Schema::table('partners_partners', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
