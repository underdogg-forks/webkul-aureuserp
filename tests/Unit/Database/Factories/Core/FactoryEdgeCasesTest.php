<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Account\Models\PaymentTerm;
use Webkul\Employee\Models\Calendar;
use Webkul\Employee\Models\Employee;
use Webkul\Product\Enums\ProductType;
use Webkul\Product\Models\Product;
use Webkul\TimeOff\Models\LeaveType;

/**
 * Test edge cases and boundary conditions in factory data generation.
 */
class FactoryEdgeCasesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_handles_zero_price_products(): void
    {
        $product = Product::factory()->make(['price' => 0.00]);

        $this->assertEquals(0.00, $product->price);
    }

    #[Test]
    public function it_handles_zero_cost_products(): void
    {
        $product = Product::factory()->make(['cost' => 0.00]);

        $this->assertEquals(0.00, $product->cost);
    }

    #[Test]
    public function it_handles_zero_children_for_employee(): void
    {
        $employee = Employee::factory()->make(['children' => 0]);

        $this->assertEquals(0, $employee->children);
    }

    #[Test]
    public function it_handles_optional_note_in_payment_term(): void
    {
        $paymentTerm1 = PaymentTerm::factory()->make(['note' => null]);
        $paymentTerm2 = PaymentTerm::factory()->make(['note' => 'Some note']);

        $this->assertNull($paymentTerm1->note);
        $this->assertNotNull($paymentTerm2->note);
    }

    #[Test]
    public function it_handles_maximum_hours_per_day_in_calendar(): void
    {
        $calendar = Calendar::factory()->make(['hours_per_day' => 24.0]);

        $this->assertEquals(24.0, $calendar->hours_per_day);
    }

    #[Test]
    public function it_handles_minimum_hours_per_day_in_calendar(): void
    {
        $calendar = Calendar::factory()->make(['hours_per_day' => 0.0]);

        $this->assertEquals(0.0, $calendar->hours_per_day);
    }

    #[Test]
    public function it_handles_service_product_type(): void
    {
        $product = Product::factory()->make(['type' => ProductType::SERVICE]);

        $this->assertEquals(ProductType::SERVICE, $product->type);
    }

    #[Test]
    public function it_handles_goods_product_type(): void
    {
        $product = Product::factory()->make(['type' => ProductType::GOODS]);

        $this->assertEquals(ProductType::GOODS, $product->type);
    }

    #[Test]
    public function it_handles_disabled_sales_for_product(): void
    {
        $product = Product::factory()->make(['enable_sales' => false]);

        $this->assertFalse($product->enable_sales);
    }

    #[Test]
    public function it_handles_inactive_leave_type(): void
    {
        $leaveType = LeaveType::factory()->make(['is_active' => false]);

        $this->assertFalse($leaveType->is_active);
    }

    #[Test]
    public function it_handles_zero_discount_payment_term(): void
    {
        $paymentTerm = PaymentTerm::factory()->make([
            'discount_days' => 0,
            'discount_percentage' => 0.0,
        ]);

        $this->assertEquals(0, $paymentTerm->discount_days);
        $this->assertEquals(0.0, $paymentTerm->discount_percentage);
    }

    #[Test]
    public function it_handles_maximum_discount_percentage(): void
    {
        $paymentTerm = PaymentTerm::factory()->make(['discount_percentage' => 20.0]);

        $this->assertEquals(20.0, $paymentTerm->discount_percentage);
    }

    #[Test]
    public function it_handles_null_optional_fields_in_employee(): void
    {
        $employee = Employee::factory()->make([
            'departure_date' => null,
            'departure_description' => null,
            'additional_note' => null,
        ]);

        $this->assertNull($employee->departure_date);
        $this->assertNull($employee->departure_description);
        $this->assertNull($employee->additional_note);
    }

    #[Test]
    public function it_handles_inactive_employee(): void
    {
        $employee = Employee::factory()->make(['is_active' => false]);

        $this->assertFalse($employee->is_active);
    }

    #[Test]
    public function it_handles_flexible_employee_settings(): void
    {
        $employee = Employee::factory()->make([
            'is_flexible' => true,
            'is_fully_flexible' => true,
        ]);

        $this->assertTrue($employee->is_flexible);
        $this->assertTrue($employee->is_fully_flexible);
    }
}