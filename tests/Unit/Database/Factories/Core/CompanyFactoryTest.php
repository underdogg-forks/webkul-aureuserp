<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Support\Database\Factories\CompanyFactory;
use Webkul\Support\Models\Company;

class CompanyFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_company_instance(): void
    {
        $company = Company::factory()->make();

        $this->assertInstanceOf(Company::class, $company);
        $this->assertNotEmpty($company->name);
    }

    #[Test]
    public function it_generates_valid_company_attributes(): void
    {
        $company = Company::factory()->make();

        $this->assertIsString($company->name);
        $this->assertNotEmpty($company->name);
        $this->assertIsString($company->company_id);
        $this->assertIsString($company->tax_id);
        $this->assertIsInt($company->registration_number);
        $this->assertIsString($company->email);
        $this->assertIsString($company->phone);
        $this->assertIsString($company->mobile);
    }

    #[Test]
    public function it_generates_valid_email_format(): void
    {
        $company = Company::factory()->make();

        $this->assertMatchesRegularExpression('/^[^@]+@[^@]+\.[^@]+$/', $company->email);
    }

    #[Test]
    public function it_generates_valid_color_hex_code(): void
    {
        $company = Company::factory()->make();

        $this->assertMatchesRegularExpression('/^#[0-9A-Fa-f]{6}$/', $company->color);
    }

    #[Test]
    public function it_generates_valid_boolean_for_is_active(): void
    {
        $company = Company::factory()->make();

        $this->assertIsBool($company->is_active);
    }

    #[Test]
    public function it_generates_valid_date_format_for_founded_date(): void
    {
        $company = Company::factory()->make();

        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $company->founded_date);
    }

    #[Test]
    public function it_sets_user_id_to_default_value(): void
    {
        $company = Company::factory()->make();

        $this->assertEquals(1, $company->user_id);
    }

    #[Test]
    public function it_generates_valid_currency_id(): void
    {
        $company = Company::factory()->make();

        $this->assertContains($company->currency_id, [1, 2, 3]);
    }

    #[Test]
    public function it_can_create_multiple_companies(): void
    {
        $companies = Company::factory()->count(5)->make();

        $this->assertCount(5, $companies);
        foreach ($companies as $company) {
            $this->assertInstanceOf(Company::class, $company);
        }
    }

    #[Test]
    public function it_generates_unique_emails_for_multiple_companies(): void
    {
        $companies = Company::factory()->count(10)->make();
        $emails = $companies->pluck('email')->toArray();

        $this->assertEquals(count($emails), count(array_unique($emails)));
    }

    #[Test]
    public function it_can_override_attributes(): void
    {
        $customName = 'Custom Company Name';
        $company = Company::factory()->make(['name' => $customName]);

        $this->assertEquals($customName, $company->name);
    }

    #[Test]
    public function it_generates_valid_tax_id_format(): void
    {
        $company = Company::factory()->make();

        $this->assertMatchesRegularExpression('/^[A-Za-z]{2}-\d{8}$/', $company->tax_id);
    }

    #[Test]
    public function it_generates_8_digit_registration_number(): void
    {
        $company = Company::factory()->make();

        $this->assertGreaterThanOrEqual(10000000, $company->registration_number);
        $this->assertLessThan(100000000, $company->registration_number);
    }

    #[Test]
    public function it_generates_logo_url(): void
    {
        $company = Company::factory()->make();

        $this->assertIsString($company->logo);
        $this->assertStringContainsString('http', $company->logo);
    }
}