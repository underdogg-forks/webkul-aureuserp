<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\Calendar;

class CalendarFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_calendar_instance(): void
    {
        $calendar = Calendar::factory()->make();

        $this->assertInstanceOf(Calendar::class, $calendar);
        $this->assertNotEmpty($calendar->name);
    }

    #[Test]
    public function it_generates_valid_calendar_attributes(): void
    {
        $calendar = Calendar::factory()->make();

        $this->assertIsString($calendar->name);
        $this->assertIsString($calendar->tz);
        $this->assertIsFloat($calendar->hours_per_day);
        $this->assertIsInt($calendar->status);
        $this->assertIsInt($calendar->two_weeks_calendar);
        $this->assertIsInt($calendar->flexible_hours);
        $this->assertIsInt($calendar->full_time_required_hours);
    }

    #[Test]
    public function it_generates_valid_timezone(): void
    {
        $calendar = Calendar::factory()->make();

        $this->assertNotEmpty($calendar->tz);
        // Timezone should be a valid string
        $this->assertIsString($calendar->tz);
    }

    #[Test]
    public function it_generates_valid_hours_per_day(): void
    {
        $calendar = Calendar::factory()->make();

        $this->assertGreaterThanOrEqual(0, $calendar->hours_per_day);
        $this->assertLessThanOrEqual(24, $calendar->hours_per_day);
    }

    #[Test]
    public function it_sets_default_boolean_flags(): void
    {
        $calendar = Calendar::factory()->make();

        $this->assertEquals(1, $calendar->status);
        $this->assertEquals(0, $calendar->two_weeks_calendar);
        $this->assertEquals(0, $calendar->flexible_hours);
        $this->assertEquals(0, $calendar->full_time_required_hours);
    }

    #[Test]
    public function it_can_create_multiple_calendars(): void
    {
        $calendars = Calendar::factory()->count(3)->make();

        $this->assertCount(3, $calendars);
        foreach ($calendars as $calendar) {
            $this->assertInstanceOf(Calendar::class, $calendar);
        }
    }

    #[Test]
    public function it_can_override_calendar_attributes(): void
    {
        $calendar = Calendar::factory()->make([
            'name' => 'Custom Calendar',
            'hours_per_day' => 8.5,
            'status' => 0,
        ]);

        $this->assertEquals('Custom Calendar', $calendar->name);
        $this->assertEquals(8.5, $calendar->hours_per_day);
        $this->assertEquals(0, $calendar->status);
    }
}