<?php

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Enums\DelayType;
use Modules\Core\Enums\DueTermValue;
use Modules\Core\Models\PaymentDueTerm;
use Modules\Core\Models\PaymentTerm;
use Modules\Core\Models\User;

class PaymentDueTermFactory extends Factory
{
    protected $model = PaymentDueTerm::class;

    public function definition(): array
    {
        return [
            'payment_id'      => PaymentTerm::factory(),
            'creator_id'      => User::factory(),
            'value'           => $this->faker->randomElement([DueTermValue::PERCENT->value, DueTermValue::FIXED->value]),
            'value_amount'    => $this->faker->randomFloat(2, 0, 100),
            'delay_type'      => DelayType::DAYS_AFTER->value,
            'days_next_month' => $this->faker->numberBetween(0, 31),
            'nb_days'         => $this->faker->numberBetween(0, 60),
            'created_at'      => now(),
            'updated_at'      => now(),
        ];
    }
}
