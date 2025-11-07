<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\EmployeeJobPosition;

class EmployeeJobPositionFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_job_position_instance(): void
    {
        $jobPosition = EmployeeJobPosition::factory()->make();

        $this->assertInstanceOf(EmployeeJobPosition::class, $jobPosition);
        $this->assertNotEmpty($jobPosition->name);
    }

    #[Test]
    public function it_generates_valid_job_position_attributes(): void
    {
        $jobPosition = EmployeeJobPosition::factory()->make();

        $this->assertIsInt($jobPosition->sort);
        $this->assertIsString($jobPosition->name);
        $this->assertIsString($jobPosition->description);
        $this->assertIsString($jobPosition->requirements);
        $this->assertIsInt($jobPosition->expected_employees);
        $this->assertIsInt($jobPosition->no_of_employee);
        $this->assertIsBool($jobPosition->status);
        $this->assertIsInt($jobPosition->no_of_recruitment);
    }

    #[Test]
    public function it_generates_valid_date_format(): void
    {
        $jobPosition = EmployeeJobPosition::factory()->make();

        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $jobPosition->open_date);
    }

    #[Test]
    public function it_sets_status_to_true_by_default(): void
    {
        $jobPosition = EmployeeJobPosition::factory()->make();

        $this->assertTrue($jobPosition->status);
    }

    #[Test]
    public function it_can_create_multiple_job_positions(): void
    {
        $jobPositions = EmployeeJobPosition::factory()->count(5)->make();

        $this->assertCount(5, $jobPositions);
        foreach ($jobPositions as $jobPosition) {
            $this->assertInstanceOf(EmployeeJobPosition::class, $jobPosition);
        }
    }

    #[Test]
    public function it_can_override_job_position_attributes(): void
    {
        $jobPosition = EmployeeJobPosition::factory()->make([
            'name' => 'Senior Software Engineer',
            'expected_employees' => 5,
            'status' => false,
        ]);

        $this->assertEquals('Senior Software Engineer', $jobPosition->name);
        $this->assertEquals(5, $jobPosition->expected_employees);
        $this->assertFalse($jobPosition->status);
    }

    #[Test]
    public function it_generates_text_fields_with_content(): void
    {
        $jobPosition = EmployeeJobPosition::factory()->make();

        $this->assertNotEmpty($jobPosition->description);
        $this->assertNotEmpty($jobPosition->requirements);
    }
}