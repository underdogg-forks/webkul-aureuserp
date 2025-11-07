<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\Employee;
use Webkul\Product\Models\Product;
use Webkul\Support\Models\Company;
use Webkul\TimeOff\Models\LeaveType;

/**
 * Test data integrity and business logic constraints in factories.
 */
class FactoryDataIntegrityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function product_price_is_not_negative(): void
    {
        $products = Product::factory()->count(20)->make();

        foreach ($products as $product) {
            $this->assertGreaterThanOrEqual(0, $product->price, 'Product price should not be negative');
        }
    }

    #[Test]
    public function product_cost_is_not_negative(): void
    {
        $products = Product::factory()->count(20)->make();

        foreach ($products as $product) {
            $this->assertGreaterThanOrEqual(0, $product->cost, 'Product cost should not be negative');
        }
    }

    #[Test]
    public function employee_children_count_is_realistic(): void
    {
        $employees = Employee::factory()->count(20)->make();

        foreach ($employees as $employee) {
            $this->assertGreaterThanOrEqual(0, $employee->children);
            $this->assertLessThanOrEqual(10, $employee->children, 'Children count should be realistic');
        }
    }

    #[Test]
    public function company_emails_are_valid(): void
    {
        $companies = Company::factory()->count(10)->make();

        foreach ($companies as $company) {
            $this->assertMatchesRegularExpression(
                '/^[^@]+@[^@]+\.[^@]+$/',
                $company->email,
                'Company email should be valid'
            );
        }
    }

    #[Test]
    public function employee_emails_are_valid(): void
    {
        $employees = Employee::factory()->count(10)->make();

        foreach ($employees as $employee) {
            $this->assertMatchesRegularExpression(
                '/^[^@]+@[^@]+\.[^@]+$/',
                $employee->work_email,
                'Employee work email should be valid'
            );
            $this->assertMatchesRegularExpression(
                '/^[^@]+@[^@]+\.[^@]+$/',
                $employee->private_email,
                'Employee private email should be valid'
            );
        }
    }

    #[Test]
    public function leave_type_names_are_meaningful(): void
    {
        $leaveTypes = LeaveType::factory()->count(20)->make();

        foreach ($leaveTypes as $leaveType) {
            $this->assertNotEmpty($leaveType->name, 'Leave type name should not be empty');
            $this->assertGreaterThan(3, strlen($leaveType->name), 'Leave type name should be meaningful');
        }
    }

    #[Test]
    public function product_barcodes_are_numeric_and_proper_length(): void
    {
        $products = Product::factory()->count(10)->make();

        foreach ($products as $product) {
            $this->assertMatchesRegularExpression('/^\d+$/', $product->barcode, 'Barcode should be numeric');
            $this->assertEquals(13, strlen($product->barcode), 'Barcode should be EAN-13 format');
        }
    }

    #[Test]
    public function company_tax_ids_follow_pattern(): void
    {
        $companies = Company::factory()->count(10)->make();

        foreach ($companies as $company) {
            $this->assertMatchesRegularExpression(
                '/^[A-Za-z]{2}-\d{8}$/',
                $company->tax_id,
                'Tax ID should follow the pattern XX-12345678'
            );
        }
    }

    #[Test]
    public function employee_marital_status_is_valid(): void
    {
        $employees = Employee::factory()->count(20)->make();
        $validStatuses = ['single', 'married', 'divorced', 'widowed'];

        foreach ($employees as $employee) {
            $this->assertContains(
                $employee->marital,
                $validStatuses,
                'Marital status should be one of the predefined values'
            );
        }
    }

    #[Test]
    public function employee_type_is_valid(): void
    {
        $employees = Employee::factory()->count(20)->make();
        $validTypes = ['full-time', 'part-time', 'contractor'];

        foreach ($employees as $employee) {
            $this->assertContains(
                $employee->employee_type,
                $validTypes,
                'Employee type should be one of the predefined values'
            );
        }
    }
}