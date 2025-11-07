<?php

namespace Tests\Unit\Database\Factories;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Test that all factories can be instantiated without errors.
 * This is a smoke test to ensure factory definitions are syntactically correct.
 */
class FactoryInstantiationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_can_instantiate_company_factory(): void
    {
        $this->assertNotNull(\Webkul\Support\Models\Company::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_bank_factory(): void
    {
        $this->assertNotNull(\Webkul\Support\Models\Bank::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_product_factory(): void
    {
        $this->assertNotNull(\Webkul\Product\Models\Product::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_category_factory(): void
    {
        $this->assertNotNull(\Webkul\Product\Models\Category::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_employee_factory(): void
    {
        $this->assertNotNull(\Webkul\Employee\Models\Employee::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_department_factory(): void
    {
        $this->assertNotNull(\Webkul\Employee\Models\Department::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_calendar_factory(): void
    {
        $this->assertNotNull(\Webkul\Employee\Models\Calendar::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_employee_job_position_factory(): void
    {
        $this->assertNotNull(\Webkul\Employee\Models\EmployeeJobPosition::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_payment_term_factory(): void
    {
        $this->assertNotNull(\Webkul\Account\Models\PaymentTerm::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_leave_type_factory(): void
    {
        $this->assertNotNull(\Webkul\TimeOff\Models\LeaveType::factory()->make());
    }

    #[Test]
    public function it_can_instantiate_user_factory(): void
    {
        $this->assertNotNull(\Webkul\Security\Models\User::factory()->make());
    }
}