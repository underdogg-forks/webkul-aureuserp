<?php

namespace Tests\Unit\Database\Factories\Core;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webkul\Product\Models\Category;

class CategoryFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Model::unguard();
    }

    #[Test]
    public function it_creates_a_valid_category_instance(): void
    {
        $category = Category::factory()->make();

        $this->assertInstanceOf(Category::class, $category);
        $this->assertNotEmpty($category->name);
    }

    #[Test]
    public function it_generates_valid_category_attributes(): void
    {
        $category = Category::factory()->make();

        $this->assertIsString($category->name);
        $this->assertIsString($category->full_name);
        $this->assertNotEmpty($category->name);
        $this->assertNotEmpty($category->full_name);
    }

    #[Test]
    public function it_can_create_multiple_categories(): void
    {
        $categories = Category::factory()->count(5)->make();

        $this->assertCount(5, $categories);
        foreach ($categories as $category) {
            $this->assertInstanceOf(Category::class, $category);
        }
    }

    #[Test]
    public function it_can_override_category_name(): void
    {
        $customName = 'Electronics';
        $category = Category::factory()->make(['name' => $customName]);

        $this->assertEquals($customName, $category->name);
    }

    #[Test]
    public function it_generates_different_names_for_multiple_categories(): void
    {
        $categories = Category::factory()->count(10)->make();
        $names = $categories->pluck('name')->toArray();

        // Most names should be different (allowing some collision due to faker randomness)
        $uniqueNames = array_unique($names);
        $this->assertGreaterThan(5, count($uniqueNames));
    }
}