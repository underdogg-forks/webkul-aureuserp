<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Account\Models\PaymentTerm;

class PaymentTermFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_payment_term_instance(): void
    {
        $paymentTerm = PaymentTerm::factory()->make();

        $this->assertInstanceOf(PaymentTerm::class, $paymentTerm);
        $this->assertNotEmpty($paymentTerm->name);
    }

    #[Test]
    public function it_generates_valid_payment_term_attributes(): void
    {
        $paymentTerm = PaymentTerm::factory()->make();

        $this->assertIsString($paymentTerm->name);
        $this->assertIsInt($paymentTerm->sort);
        $this->assertIsInt($paymentTerm->discount_days);
        $this->assertIsBool($paymentTerm->early_pay_discount);
        $this->assertIsBool($paymentTerm->display_on_invoice);
        $this->assertIsBool($paymentTerm->early_discount);
    }

    #[Test]
    public function it_generates_valid_discount_days(): void
    {
        $paymentTerm = PaymentTerm::factory()->make();

        $this->assertContains($paymentTerm->discount_days, [0, 10, 15, 30]);
    }

    #[Test]
    public function it_generates_valid_discount_percentage(): void
    {
        $paymentTerm = PaymentTerm::factory()->make();

        $this->assertIsFloat($paymentTerm->discount_percentage);
        $this->assertGreaterThanOrEqual(0, $paymentTerm->discount_percentage);
        $this->assertLessThanOrEqual(20, $paymentTerm->discount_percentage);
    }

    #[Test]
    public function it_handles_optional_note_field(): void
    {
        $paymentTerm = PaymentTerm::factory()->make();

        $this->assertTrue(is_string($paymentTerm->note) || is_null($paymentTerm->note));
    }

    #[Test]
    public function it_sets_timestamps(): void
    {
        $paymentTerm = PaymentTerm::factory()->make();

        $this->assertNotNull($paymentTerm->created_at);
        $this->assertNotNull($paymentTerm->updated_at);
    }

    #[Test]
    public function it_can_create_multiple_payment_terms(): void
    {
        $paymentTerms = PaymentTerm::factory()->count(3)->make();

        $this->assertCount(3, $paymentTerms);
        foreach ($paymentTerms as $paymentTerm) {
            $this->assertInstanceOf(PaymentTerm::class, $paymentTerm);
        }
    }

    #[Test]
    public function it_can_override_attributes(): void
    {
        $paymentTerm = PaymentTerm::factory()->make([
            'discount_days' => 45,
            'discount_percentage' => 5.5,
        ]);

        $this->assertEquals(45, $paymentTerm->discount_days);
        $this->assertEquals(5.5, $paymentTerm->discount_percentage);
    }
}