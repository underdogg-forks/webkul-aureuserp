<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\Employee;

class EmployeeFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_employee_instance(): void
    {
        $employee = Employee::factory()->make();

        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertNotEmpty($employee->name);
    }

    #[Test]
    public function it_generates_valid_employee_basic_attributes(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsString($employee->name);
        $this->assertIsString($employee->job_title);
        $this->assertIsString($employee->work_phone);
        $this->assertIsString($employee->mobile_phone);
        $this->assertIsString($employee->work_email);
    }

    #[Test]
    public function it_generates_unique_work_emails(): void
    {
        $employees = Employee::factory()->count(5)->make();
        $emails = $employees->pluck('work_email')->toArray();

        $this->assertEquals(count($emails), count(array_unique($emails)));
    }

    #[Test]
    public function it_generates_unique_private_emails(): void
    {
        $employees = Employee::factory()->count(5)->make();
        $emails = $employees->pluck('private_email')->toArray();

        $this->assertEquals(count($emails), count(array_unique($emails)));
    }

    #[Test]
    public function it_generates_valid_children_count(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsInt($employee->children);
        $this->assertGreaterThanOrEqual(0, $employee->children);
        $this->assertLessThanOrEqual(5, $employee->children);
    }

    #[Test]
    public function it_generates_valid_distance_values(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsInt($employee->distance_home_work);
        $this->assertIsInt($employee->km_home_work);
        $this->assertGreaterThanOrEqual(5, $employee->distance_home_work);
        $this->assertLessThanOrEqual(100, $employee->distance_home_work);
    }

    #[Test]
    public function it_generates_valid_distance_unit(): void
    {
        $employee = Employee::factory()->make();

        $this->assertContains($employee->distance_home_work_unit, ['km', 'miles']);
    }

    #[Test]
    public function it_generates_valid_address_components(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsString($employee->private_street1);
        $this->assertIsString($employee->private_city);
        $this->assertIsString($employee->private_zip);
        $this->assertIsString($employee->private_phone);
    }

    #[Test]
    public function it_generates_valid_marital_status(): void
    {
        $employee = Employee::factory()->make();

        $this->assertContains($employee->marital, ['single', 'married', 'divorced', 'widowed']);
    }

    #[Test]
    public function it_generates_valid_date_fields(): void
    {
        $employee = Employee::factory()->make();

        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $employee->birthday);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $employee->spouse_birthdate);
    }

    #[Test]
    public function it_generates_valid_identification_fields(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsString($employee->ssnid);
        $this->assertIsString($employee->sinid);
        $this->assertIsString($employee->identification_id);
        $this->assertIsString($employee->passport_id);
        $this->assertIsString($employee->permit_no);
        $this->assertIsString($employee->visa_no);
    }

    #[Test]
    public function it_generates_valid_education_fields(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsString($employee->certificate);
        $this->assertIsString($employee->study_field);
        $this->assertIsString($employee->study_school);
    }

    #[Test]
    public function it_generates_valid_emergency_contact(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsString($employee->emergency_contact);
        $this->assertIsString($employee->emergency_phone);
    }

    #[Test]
    public function it_generates_valid_employee_type(): void
    {
        $employee = Employee::factory()->make();

        $this->assertContains($employee->employee_type, ['full-time', 'part-time', 'contractor']);
    }

    #[Test]
    public function it_generates_valid_barcode_and_pin(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsString($employee->barcode);
        $this->assertEquals(13, strlen($employee->barcode));
        $this->assertIsInt($employee->pin);
        $this->assertGreaterThanOrEqual(100000, $employee->pin);
        $this->assertLessThan(1000000, $employee->pin);
    }

    #[Test]
    public function it_generates_valid_car_plate_format(): void
    {
        $employee = Employee::factory()->make();

        $this->assertMatchesRegularExpression('/^[A-Za-z]{2}-\d{3}-\d{2}$/', $employee->private_car_plate);
    }

    #[Test]
    public function it_generates_valid_boolean_flags(): void
    {
        $employee = Employee::factory()->make();

        $this->assertIsBool($employee->is_active);
        $this->assertIsBool($employee->is_flexible);
        $this->assertIsBool($employee->is_fully_flexible);
        $this->assertIsBool($employee->work_permit_scheduled_activity);
    }

    #[Test]
    public function it_handles_optional_departure_fields(): void
    {
        $employee = Employee::factory()->make();

        $this->assertTrue(is_string($employee->departure_description) || is_null($employee->departure_description));
    }

    #[Test]
    public function it_can_create_multiple_employees(): void
    {
        $employees = Employee::factory()->count(3)->make();

        $this->assertCount(3, $employees);
        foreach ($employees as $employee) {
            $this->assertInstanceOf(Employee::class, $employee);
        }
    }
}