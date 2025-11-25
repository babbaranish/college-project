<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ShoppingCartService;

class ShoppingCartServiceTest extends TestCase
{
    private $cartService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartService = new ShoppingCartService();
    }

    /** @test */
    public function it_adds_new_item_to_empty_cart()
    {
        $cart = [];
        $result = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);

        $this->assertCount(1, $result);
        $this->assertEquals('1', $result[0]['item_id']);
        $this->assertEquals('Product A', $result[0]['item_name']);
        $this->assertEquals(10.00, $result[0]['item_price']);
        $this->assertEquals(1, $result[0]['item_quantity']);
    }

    /** @test */
    public function it_adds_multiple_different_items()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image1.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image2.jpg', 20.00, 2);

        $this->assertCount(2, $cart);
        $this->assertEquals('1', $cart[0]['item_id']);
        $this->assertEquals('2', $cart[1]['item_id']);
    }

    /** @test */
    public function it_increments_quantity_when_adding_existing_item()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);

        $this->assertCount(1, $cart);
        $this->assertEquals(2, $cart[0]['item_quantity']);
        // CRITICAL: Unit price should remain unchanged!
        $this->assertEquals(10.00, $cart[0]['item_price']);
    }

    /** @test */
    public function it_correctly_handles_multiple_additions_of_same_item()
    {
        // This tests the fix for the exponential price bug
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);

        $this->assertCount(1, $cart);
        $this->assertEquals(3, $cart[0]['item_quantity']);
        // Price should ALWAYS be the unit price, NOT multiplied!
        $this->assertEquals(10.00, $cart[0]['item_price']);

        // Total should be calculated separately
        $total = $this->cartService->calculateTotal($cart);
        $this->assertEquals(30.00, $total);
    }

    /** @test */
    public function it_throws_exception_for_invalid_item_data()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cartService->addItem([], '', 'Product', 'image.jpg', 10.00, 1);
    }

    /** @test */
    public function it_throws_exception_for_negative_price()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cartService->addItem([], '1', 'Product', 'image.jpg', -10.00, 1);
    }

    /** @test */
    public function it_throws_exception_for_zero_quantity()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cartService->addItem([], '1', 'Product', 'image.jpg', 10.00, 0);
    }

    /** @test */
    public function it_removes_item_from_cart()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image1.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image2.jpg', 20.00, 1);

        $cart = $this->cartService->removeItem($cart, '1');

        $this->assertCount(1, $cart);
        $this->assertEquals('2', $cart[0]['item_id']);
    }

    /** @test */
    public function it_handles_removing_nonexistent_item()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);

        $cart = $this->cartService->removeItem($cart, '999');

        $this->assertCount(1, $cart); // Cart unchanged
    }

    /** @test */
    public function it_removes_all_items_individually()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image1.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image2.jpg', 20.00, 1);

        $cart = $this->cartService->removeItem($cart, '1');
        $cart = $this->cartService->removeItem($cart, '2');

        $this->assertCount(0, $cart);
    }

    /** @test */
    public function it_updates_item_quantity()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->updateQuantity($cart, '1', 5);

        $this->assertEquals(5, $cart[0]['item_quantity']);
        // Price should remain unchanged
        $this->assertEquals(10.00, $cart[0]['item_price']);
    }

    /** @test */
    public function it_removes_item_when_quantity_updated_to_zero()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->updateQuantity($cart, '1', 0);

        $this->assertCount(0, $cart);
    }

    /** @test */
    public function it_removes_item_when_quantity_updated_to_negative()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->updateQuantity($cart, '1', -5);

        $this->assertCount(0, $cart);
    }

    /** @test */
    public function it_calculates_correct_total_for_empty_cart()
    {
        $total = $this->cartService->calculateTotal([]);
        $this->assertEquals(0.0, $total);
    }

    /** @test */
    public function it_calculates_correct_total_for_single_item()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 2);

        $total = $this->cartService->calculateTotal($cart);
        $this->assertEquals(20.00, $total);
    }

    /** @test */
    public function it_calculates_correct_total_for_multiple_items()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image1.jpg', 10.00, 2);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image2.jpg', 15.50, 3);

        $total = $this->cartService->calculateTotal($cart);
        // (10 * 2) + (15.50 * 3) = 20 + 46.50 = 66.50
        $this->assertEquals(66.50, $total);
    }

    /** @test */
    public function it_calculates_total_with_decimal_prices()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 9.99, 1);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image.jpg', 5.49, 2);

        $total = $this->cartService->calculateTotal($cart);
        // 9.99 + (5.49 * 2) = 9.99 + 10.98 = 20.97
        $this->assertEquals(20.97, $total);
    }

    /** @test */
    public function it_rounds_total_to_two_decimal_places()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.333, 1);

        $total = $this->cartService->calculateTotal($cart);
        $this->assertEquals(10.33, $total);
    }

    /** @test */
    public function it_counts_items_in_cart()
    {
        $cart = [];
        $this->assertEquals(0, $this->cartService->getItemCount($cart));

        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $this->assertEquals(1, $this->cartService->getItemCount($cart));

        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image.jpg', 20.00, 1);
        $this->assertEquals(2, $this->cartService->getItemCount($cart));
    }

    /** @test */
    public function it_calculates_total_quantity_of_all_items()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 2);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image.jpg', 20.00, 3);

        $totalQuantity = $this->cartService->getTotalQuantity($cart);
        $this->assertEquals(5, $totalQuantity);
    }

    /** @test */
    public function it_clears_cart()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);
        $cart = $this->cartService->addItem($cart, '2', 'Product B', 'image.jpg', 20.00, 1);

        $cart = $this->cartService->clearCart();

        $this->assertCount(0, $cart);
        $this->assertEquals(0.0, $this->cartService->calculateTotal($cart));
    }

    /** @test */
    public function it_validates_valid_cart()
    {
        $cart = [];
        $cart = $this->cartService->addItem($cart, '1', 'Product A', 'image.jpg', 10.00, 1);

        $this->assertTrue($this->cartService->isValidCart($cart));
    }

    /** @test */
    public function it_rejects_invalid_cart_with_missing_fields()
    {
        $invalidCart = [
            ['item_id' => '1', 'item_name' => 'Product A']
            // Missing price and quantity
        ];

        $this->assertFalse($this->cartService->isValidCart($invalidCart));
    }

    /** @test */
    public function it_rejects_cart_with_negative_price()
    {
        $invalidCart = [
            [
                'item_id' => '1',
                'item_name' => 'Product A',
                'item_price' => -10.00,
                'item_quantity' => 1
            ]
        ];

        $this->assertFalse($this->cartService->isValidCart($invalidCart));
    }

    /** @test */
    public function it_rejects_cart_with_zero_quantity()
    {
        $invalidCart = [
            [
                'item_id' => '1',
                'item_name' => 'Product A',
                'item_price' => 10.00,
                'item_quantity' => 0
            ]
        ];

        $this->assertFalse($this->cartService->isValidCart($invalidCart));
    }

    /** @test */
    public function it_handles_non_array_cart_input()
    {
        $this->assertEquals([], $this->cartService->removeItem(null, '1'));
        $this->assertEquals(0, $this->cartService->getItemCount(null));
        $this->assertEquals(0.0, $this->cartService->calculateTotal(null));
        $this->assertFalse($this->cartService->isValidCart(null));
    }
}
