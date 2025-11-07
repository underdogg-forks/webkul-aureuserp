<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\TimeOff\Models\LeaveType;

class LeaveTypeFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_leave_type_instance(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertInstanceOf(LeaveType::class, $leaveType);
        $this->assertNotEmpty($leaveType->name);
    }

    #[Test]
    public function it_generates_valid_leave_type_attributes(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertIsInt($leaveType->sort);
        $this->assertIsInt($leaveType->company_id);
        $this->assertIsInt($leaveType->max_allowed_negative);
        $this->assertIsString($leaveType->name);
        $this->assertIsBool($leaveType->requires_allocation);
        $this->assertIsBool($leaveType->employee_requests);
    }

    #[Test]
    public function it_generates_valid_leave_name_from_predefined_list(): void
    {
        $leaveType = LeaveType::factory()->make();

        $validNames = [
            'Annual Leave',
            'Sick Leave',
            'Maternity Leave',
            'Paternity Leave',
            'Study Leave',
            'Bereavement Leave',
            'Personal Leave',
            'Unpaid Leave',
            'Work From Home',
            'Compensatory Off',
        ];

        $this->assertContains($leaveType->name, $validNames);
    }

    #[Test]
    public function it_generates_valid_validation_types(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertContains($leaveType->leave_validation_type, ['both', 'manager', 'hr']);
        $this->assertEquals('hr', $leaveType->allocation_validation_type);
    }

    #[Test]
    public function it_generates_valid_time_type(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertEquals('leave', $leaveType->time_type);
    }

    #[Test]
    public function it_generates_valid_request_unit(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertContains($leaveType->request_unit, ['day', 'hour', 'half_day']);
    }

    #[Test]
    public function it_generates_valid_max_allowed_negative(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertContains($leaveType->max_allowed_negative, [1, 2, 3, 5, 10]);
    }

    #[Test]
    public function it_generates_valid_boolean_flags(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertIsBool($leaveType->create_calendar_meeting);
        $this->assertIsBool($leaveType->is_active);
        $this->assertIsBool($leaveType->show_on_dashboard);
        $this->assertIsBool($leaveType->unpaid);
        $this->assertIsBool($leaveType->include_public_holidays_in_duration);
        $this->assertIsBool($leaveType->support_document);
        $this->assertIsBool($leaveType->allows_negative);
    }

    #[Test]
    public function it_handles_optional_color_field(): void
    {
        $leaveType = LeaveType::factory()->make();

        if (!is_null($leaveType->color)) {
            $this->assertMatchesRegularExpression('/^#[0-9A-Fa-f]{6}$/', $leaveType->color);
        }
    }

    #[Test]
    public function it_handles_optional_creator_id(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertTrue(is_int($leaveType->creator_id) || is_null($leaveType->creator_id));
    }

    #[Test]
    public function it_sets_timestamps(): void
    {
        $leaveType = LeaveType::factory()->make();

        $this->assertNotNull($leaveType->created_at);
        $this->assertNotNull($leaveType->updated_at);
    }

    #[Test]
    public function it_can_create_multiple_leave_types(): void
    {
        $leaveTypes = LeaveType::factory()->count(5)->make();

        $this->assertCount(5, $leaveTypes);
        foreach ($leaveTypes as $leaveType) {
            $this->assertInstanceOf(LeaveType::class, $leaveType);
        }
    }
}