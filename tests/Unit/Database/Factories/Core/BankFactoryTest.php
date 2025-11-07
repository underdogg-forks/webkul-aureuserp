<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Support\Database\Factories\BankFactory;
use Webkul\Support\Models\Bank;

class BankFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_bank_instance(): void
    {
        $bank = Bank::factory()->make();

        $this->assertInstanceOf(Bank::class, $bank);
        $this->assertNotEmpty($bank->name);
    }

    #[Test]
    public function it_generates_valid_bank_attributes(): void
    {
        $bank = Bank::factory()->make();

        $this->assertIsString($bank->name);
        $this->assertIsString($bank->code);
        $this->assertIsString($bank->email);
        $this->assertIsString($bank->phone);
        $this->assertIsString($bank->street1);
        $this->assertIsString($bank->city);
        $this->assertIsString($bank->zip);
    }

    #[Test]
    public function it_generates_valid_email_format(): void
    {
        $bank = Bank::factory()->make();

        $this->assertMatchesRegularExpression('/^[^@]+@[^@]+\.[^@]+$/', $bank->email);
    }

    #[Test]
    public function it_generates_unique_emails(): void
    {
        $banks = Bank::factory()->count(5)->make();
        $emails = $banks->pluck('email')->toArray();

        $this->assertEquals(count($emails), count(array_unique($emails)));
    }

    #[Test]
    public function it_generates_valid_swift_bic_code(): void
    {
        $bank = Bank::factory()->make();

        $this->assertIsString($bank->code);
        $this->assertNotEmpty($bank->code);
    }

    #[Test]
    public function it_can_create_multiple_banks(): void
    {
        $banks = Bank::factory()->count(3)->make();

        $this->assertCount(3, $banks);
        foreach ($banks as $bank) {
            $this->assertInstanceOf(Bank::class, $bank);
        }
    }

    #[Test]
    public function it_can_override_attributes(): void
    {
        $customName = 'Custom Bank Name';
        $bank = Bank::factory()->make(['name' => $customName]);

        $this->assertEquals($customName, $bank->name);
    }

    #[Test]
    public function it_generates_valid_address_components(): void
    {
        $bank = Bank::factory()->make();

        $this->assertNotEmpty($bank->street1);
        $this->assertNotEmpty($bank->city);
        $this->assertNotEmpty($bank->zip);
    }

    #[Test]
    public function it_handles_optional_street2_field(): void
    {
        $bank = Bank::factory()->make();

        $this->assertTrue(is_string($bank->street2) || is_null($bank->street2));
    }

    #[Test]
    public function it_creates_bank_with_valid_phone_number(): void
    {
        $bank = Bank::factory()->make();

        $this->assertIsString($bank->phone);
        $this->assertNotEmpty($bank->phone);
    }
}