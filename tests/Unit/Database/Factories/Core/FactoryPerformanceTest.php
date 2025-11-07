<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Employee\Models\Employee;
use Webkul\Product\Models\Product;
use Webkul\Support\Models\Company;

/**
 * Test that factories can generate large datasets efficiently.
 */
class FactoryPerformanceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_can_generate_100_products_efficiently(): void
    {
        $startTime = microtime(true);
        $products = Product::factory()->count(100)->make();
        $endTime = microtime(true);

        $this->assertCount(100, $products);
        $this->assertLessThan(5, $endTime - $startTime, 'Should generate 100 products in less than 5 seconds');
    }

    #[Test]
    public function it_can_generate_100_companies_efficiently(): void
    {
        $startTime = microtime(true);
        $companies = Company::factory()->count(100)->make();
        $endTime = microtime(true);

        $this->assertCount(100, $companies);
        $this->assertLessThan(5, $endTime - $startTime, 'Should generate 100 companies in less than 5 seconds');
    }

    #[Test]
    public function it_can_generate_50_employees_efficiently(): void
    {
        $startTime = microtime(true);
        $employees = Employee::factory()->count(50)->make();
        $endTime = microtime(true);

        $this->assertCount(50, $employees);
        $this->assertLessThan(10, $endTime - $startTime, 'Should generate 50 employees in less than 10 seconds');
    }

    #[Test]
    public function it_maintains_data_quality_with_bulk_generation(): void
    {
        $products = Product::factory()->count(50)->make();

        foreach ($products as $product) {
            $this->assertNotEmpty($product->name);
            $this->assertNotEmpty($product->barcode);
            $this->assertGreaterThanOrEqual(0, $product->price);
        }
    }

    #[Test]
    public function it_generates_unique_identifiers_in_bulk(): void
    {
        $companies = Company::factory()->count(50)->make();
        $emails = $companies->pluck('email')->toArray();

        $this->assertEquals(count($emails), count(array_unique($emails)), 'All emails should be unique');
    }
}