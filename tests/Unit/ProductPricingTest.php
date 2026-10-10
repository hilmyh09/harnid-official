<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductPricingTest extends TestCase
{
    public function test_discount_percent_is_rounded_from_compare_at_price(): void
    {
        $product = new Product(['price' => 589000, 'compare_at_price' => 689000]);

        $this->assertTrue($product->isOnSale());
        $this->assertSame(15, $product->discountPercent());
    }

    public function test_no_sale_when_compare_at_price_is_missing_or_not_higher(): void
    {
        $this->assertFalse((new Product(['price' => 100000]))->isOnSale());
        $this->assertFalse((new Product(['price' => 100000, 'compare_at_price' => 100000]))->isOnSale());
        $this->assertSame(0, (new Product(['price' => 100000, 'compare_at_price' => 90000]))->discountPercent());
    }

    public function test_size_rules(): void
    {
        $sized = new Product(['sizes' => ['S', 'M']]);
        $unsized = new Product(['sizes' => null]);

        $this->assertTrue($sized->hasSize('M'));
        $this->assertFalse($sized->hasSize('XL'));
        $this->assertFalse($sized->hasSize(null));
        $this->assertTrue($unsized->hasSize(null));
        $this->assertFalse($unsized->hasSize('M'));
    }
}
