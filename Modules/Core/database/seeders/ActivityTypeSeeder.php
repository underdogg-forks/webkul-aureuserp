<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\User;
use Modules\Core\Enums\ActivityChainingType;
use Modules\Core\Enums\ActivityDecorationType;
use Modules\Core\Enums\ActivityDelayFrom;
use Modules\Core\Enums\ActivityDelayUnit;
use Modules\Core\Enums\ActivityTypeAction;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creator = User::find(1);

        $activityTypes = [
            [
                'sort'                   => 1,
                'delay_count'            => 1,
                'triggered_next_type_id' => 1,
                'default_user_id'        => null,
                'creator_id'             => $creator?->id,
                'delay_unit'             => ActivityDelayUnit::DAYS->value,
                'delay_from'             => ActivityDelayFrom::CURRENT_DATE->value,
                'icon'                   => 'heroicon-c-arrow-up',
                'decoration_type'        => ActivityDecorationType::ALERT->value,
                'chaining_type'          => ActivityChainingType::SUGGEST->value,
                'category'               => ActivityTypeAction::MEETING->value,
                'name'                   => 'Meeting',
                'plugin'                 => 'support',
                'summary'                => 'Meeting',
                'is_active'              => true,
            ],
            [
                'sort'                   => 1,
                'delay_count'            => 1,
                'triggered_next_type_id' => null,
                'default_user_id'        => null,
                'creator_id'             => $creator?->id,
                'delay_unit'             => ActivityDelayUnit::DAYS->value,
                'delay_from'             => ActivityDelayFrom::CURRENT_DATE->value,
                'icon'                   => 'heroicon-c-arrow-up',
                'decoration_type'        => ActivityDecorationType::ALERT->value,
                'chaining_type'          => ActivityChainingType::SUGGEST->value,
                'category'               => ActivityTypeAction::DEFAULT->value,
                'name'                   => 'Exception',
                'summary'                => 'Exception',
                'plugin'                 => 'support',
                'is_active'              => true,
            ],
            [
                'sort'                   => 1,
                'delay_count'            => 1,
                'triggered_next_type_id' => null,
                'default_user_id'        => null,
                'creator_id'             => $creator?->id,
                'delay_unit'             => ActivityDelayUnit::DAYS->value,
                'delay_from'             => ActivityDelayFrom::CURRENT_DATE->value,
                'icon'                   => 'heroicon-c-arrow-up',
                'decoration_type'        => ActivityDecorationType::ALERT->value,
                'chaining_type'          => ActivityChainingType::SUGGEST->value,
                'category'               => ActivityTypeAction::DEFAULT->value,
                'name'                   => 'To-Do',
                'summary'                => 'To-Do',
                'plugin'                 => 'support',
                'is_active'              => true,
            ],
            [
                'sort'                   => 1,
                'delay_count'            => 1,
                'triggered_next_type_id' => null,
                'default_user_id'        => null,
                'creator_id'             => $creator?->id,
                'delay_unit'             => ActivityDelayUnit::DAYS->value,
                'delay_from'             => ActivityDelayFrom::CURRENT_DATE->value,
                'icon'                   => 'heroicon-c-arrow-up',
                'decoration_type'        => ActivityDecorationType::ALERT->value,
                'chaining_type'          => ActivityChainingType::SUGGEST->value,
                'category'               => ActivityTypeAction::UPLOAD_FILE->value,
                'name'                   => 'Call',
                'summary'                => 'Call',
                'plugin'                 => 'support',
                'is_active'              => true,
            ],
        ];

        DB::table('activity_types')->insert($activityTypes);
    }
}
