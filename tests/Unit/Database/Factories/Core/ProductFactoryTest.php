<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Product\Enums\ProductType;
use Webkul\Product\Models\Product;

class ProductFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_product_instance(): void
    {
        $product = Product::factory()->make();

        $this->assertInstanceOf(Product::class, $product);
        $this->assertNotEmpty($product->name);
    }

    #[Test]
    public function it_generates_valid_product_attributes(): void
    {
        $product = Product::factory()->make();

        $this->assertIsString($product->name);
        $this->assertInstanceOf(ProductType::class, $product->type);
        $this->assertEquals(ProductType::GOODS, $product->type);
        $this->assertIsString($product->barcode);
        $this->assertIsFloat($product->price);
        $this->assertIsFloat($product->cost);
    }

    #[Test]
    public function it_generates_valid_ean13_barcode(): void
    {
        $product = Product::factory()->make();

        $this->assertIsString($product->barcode);
        $this->assertEquals(13, strlen($product->barcode));
        $this->assertMatchesRegularExpression('/^\d{13}$/', $product->barcode);
    }

    #[Test]
    public function it_generates_valid_price_range(): void
    {
        $product = Product::factory()->make();

        $this->assertGreaterThanOrEqual(0, $product->price);
        $this->assertLessThanOrEqual(100, $product->price);
        $this->assertEquals(2, strlen(substr(strrchr($product->price, '.'), 1)));
    }

    #[Test]
    public function it_generates_valid_cost_range(): void
    {
        $product = Product::factory()->make();

        $this->assertGreaterThanOrEqual(0, $product->cost);
        $this->assertLessThanOrEqual(100, $product->cost);
    }

    #[Test]
    public function it_generates_valid_volume_and_weight(): void
    {
        $product = Product::factory()->make();

        $this->assertIsFloat($product->volume);
        $this->assertIsFloat($product->weight);
        $this->assertGreaterThanOrEqual(0, $product->volume);
        $this->assertGreaterThanOrEqual(0, $product->weight);
    }

    #[Test]
    public function it_generates_description_fields(): void
    {
        $product = Product::factory()->make();

        $this->assertIsString($product->description);
        $this->assertIsString($product->description_purchase);
        $this->assertIsString($product->description_sale);
        $this->assertNotEmpty($product->description);
    }

    #[Test]
    public function it_sets_enable_sales_to_true_by_default(): void
    {
        $product = Product::factory()->make();

        $this->assertTrue($product->enable_sales);
    }

    #[Test]
    public function it_generates_valid_sort_number(): void
    {
        $product = Product::factory()->make();

        $this->assertIsInt($product->sort);
    }

    #[Test]
    public function it_can_create_multiple_products(): void
    {
        $products = Product::factory()->count(5)->make();

        $this->assertCount(5, $products);
        foreach ($products as $product) {
            $this->assertInstanceOf(Product::class, $product);
        }
    }

    #[Test]
    public function it_can_override_product_type(): void
    {
        $product = Product::factory()->make(['type' => ProductType::SERVICE]);

        $this->assertEquals(ProductType::SERVICE, $product->type);
    }

    #[Test]
    public function it_can_override_price_and_cost(): void
    {
        $product = Product::factory()->make([
            'price' => 25.99,
            'cost' => 10.50,
        ]);

        $this->assertEquals(25.99, $product->price);
        $this->assertEquals(10.50, $product->cost);
    }

    #[Test]
    public function it_generates_unique_barcodes_for_multiple_products(): void
    {
        $products = Product::factory()->count(10)->make();
        $barcodes = $products->pluck('barcode')->toArray();

        $uniqueBarcodes = array_unique($barcodes);
        $this->assertEquals(count($barcodes), count($uniqueBarcodes));
    }
}