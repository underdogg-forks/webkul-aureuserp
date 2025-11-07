<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\Department;
use Webkul\Employee\Models\Employee;
use Webkul\Product\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Support\Models\Bank;
use Webkul\Support\Models\Company;

/**
 * Test that factories correctly handle relationships and foreign keys.
 */
class FactoryRelationshipTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function product_factory_handles_category_relationship(): void
    {
        $product = Product::factory()->make();

        $this->assertNotNull($product->category_id);
    }

    #[Test]
    public function product_factory_handles_company_relationship(): void
    {
        $product = Product::factory()->make();

        $this->assertNotNull($product->company_id);
    }

    #[Test]
    public function product_factory_handles_creator_relationship(): void
    {
        $product = Product::factory()->make();

        $this->assertNotNull($product->creator_id);
    }

    #[Test]
    public function bank_factory_handles_state_relationship(): void
    {
        $bank = Bank::factory()->make();

        $this->assertNotNull($bank->state_id);
    }

    #[Test]
    public function bank_factory_handles_country_relationship(): void
    {
        $bank = Bank::factory()->make();

        $this->assertNotNull($bank->country_id);
    }

    #[Test]
    public function bank_factory_handles_creator_relationship(): void
    {
        $bank = Bank::factory()->make();

        $this->assertNotNull($bank->creator_id);
    }

    #[Test]
    public function employee_factory_handles_company_relationship(): void
    {
        $employee = Employee::factory()->make();

        $this->assertNotNull($employee->company_id);
    }

    #[Test]
    public function employee_factory_handles_user_relationship(): void
    {
        $employee = Employee::factory()->make();

        $this->assertNotNull($employee->user_id);
    }

    #[Test]
    public function employee_factory_handles_department_relationship(): void
    {
        $employee = Employee::factory()->make();

        $this->assertNotNull($employee->department_id);
    }

    #[Test]
    public function department_factory_handles_company_relationship(): void
    {
        $department = Department::factory()->make();

        $this->assertNotNull($department->company_id);
    }

    #[Test]
    public function category_factory_handles_creator_relationship(): void
    {
        $category = Category::factory()->make();

        $this->assertNotNull($category->creator_id);
    }

    #[Test]
    public function product_can_be_created_with_explicit_category(): void
    {
        $category = Category::factory()->make();
        $product = Product::factory()->make(['category_id' => $category]);

        $this->assertEquals($category, $product->category_id);
    }

    #[Test]
    public function product_can_be_created_with_explicit_company(): void
    {
        $company = Company::factory()->make();
        $product = Product::factory()->make(['company_id' => $company]);

        $this->assertEquals($company, $product->company_id);
    }
}