<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\Department;

class DepartmentFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_department_instance(): void
    {
        $department = Department::factory()->make();

        $this->assertInstanceOf(Department::class, $department);
        $this->assertNotEmpty($department->name);
    }

    #[Test]
    public function it_generates_valid_department_attributes(): void
    {
        $department = Department::factory()->make();

        $this->assertIsString($department->name);
        $this->assertIsString($department->color);
        $this->assertNotEmpty($department->name);
    }

    #[Test]
    public function it_generates_valid_hex_color(): void
    {
        $department = Department::factory()->make();

        $this->assertMatchesRegularExpression('/^#[0-9A-Fa-f]{6}$/', $department->color);
    }

    #[Test]
    public function it_can_create_multiple_departments(): void
    {
        $departments = Department::factory()->count(5)->make();

        $this->assertCount(5, $departments);
        foreach ($departments as $department) {
            $this->assertInstanceOf(Department::class, $department);
        }
    }

    #[Test]
    public function it_can_override_department_attributes(): void
    {
        $customName = 'Engineering Department';
        $customColor = '#FF5733';

        $department = Department::factory()->make([
            'name' => $customName,
            'color' => $customColor,
        ]);

        $this->assertEquals($customName, $department->name);
        $this->assertEquals($customColor, $department->color);
    }
}