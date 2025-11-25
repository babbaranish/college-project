<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\OrderService;
use Mockery;

class OrderServiceTest extends TestCase
{
    private $mockDb;
    private $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDb = Mockery::mock(\mysqli::class);
        $this->orderService = new OrderService($this->mockDb);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_validates_order_data_successfully()
    {
        $validOrder = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street, City',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($validOrder);

        $this->assertTrue($result['valid']);
    }

    /** @test */
    public function it_rejects_order_with_missing_name()
    {
        $orderData = [
            'name' => '',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Name is required', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_invalid_email()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'phone' => '1234567890',
            'address' => '123 Main Street',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Invalid email format', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_invalid_phone()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123',
            'address' => '123 Main Street',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Phone number must be 10 digits', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_phone_containing_letters()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '12345abcde',
            'address' => '123 Main Street',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Phone number must be 10 digits', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_invalid_pincode()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street',
            'pincode' => '123'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Pincode must be 6 digits', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_short_address()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => 'Short',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Address must be at least 10 characters', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_invalid_name_format()
    {
        $orderData = [
            'name' => 'J',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Invalid name format', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_numbers_in_name()
    {
        $orderData = [
            'name' => 'John123',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street',
            'pincode' => '123456'
        ];

        $result = $this->orderService->validateOrderData($orderData);

        $this->assertFalse($result['valid']);
        $this->assertEquals('Invalid name format', $result['error']);
    }

    /** @test */
    public function it_creates_order_successfully()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street, City',
            'pincode' => '123456'
        ];

        $cart = [
            [
                'item_id' => '1',
                'item_name' => 'Product A',
                'item_price' => 10.00,
                'item_quantity' => 2
            ]
        ];

        $mockStmt = Mockery::mock(\mysqli_stmt::class);

        $this->mockDb->shouldReceive('prepare')
            ->with(Mockery::pattern('/INSERT INTO orders/'))
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')
            ->with('ssssssd', Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any(), 20.0)
            ->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('insert_id')->andReturn(123);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->orderService->createOrder($orderData, $cart);

        $this->assertTrue($result['success']);
        $this->assertEquals(123, $result['orderId']);
    }

    /** @test */
    public function it_rejects_order_with_empty_cart()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street, City',
            'pincode' => '123456'
        ];

        $result = $this->orderService->createOrder($orderData, []);

        $this->assertFalse($result['success']);
        $this->assertEquals('Cart is empty', $result['error']);
    }

    /** @test */
    public function it_rejects_order_with_invalid_data()
    {
        $orderData = [
            'name' => '',
            'email' => 'invalid',
            'phone' => '123',
            'address' => 'short',
            'pincode' => '12'
        ];

        $cart = [
            ['item_id' => '1', 'item_name' => 'Product', 'item_price' => 10.00, 'item_quantity' => 1]
        ];

        $result = $this->orderService->createOrder($orderData, $cart);

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
    }

    /** @test */
    public function it_handles_database_error_during_order_creation()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street, City',
            'pincode' => '123456'
        ];

        $cart = [
            ['item_id' => '1', 'item_name' => 'Product', 'item_price' => 10.00, 'item_quantity' => 1]
        ];

        $this->mockDb->shouldReceive('prepare')->andReturn(false);

        $result = $this->orderService->createOrder($orderData, $cart);

        $this->assertFalse($result['success']);
        $this->assertEquals('Database error', $result['error']);
    }

    /** @test */
    public function it_calculates_correct_order_total()
    {
        $orderData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street, City',
            'pincode' => '123456'
        ];

        $cart = [
            ['item_id' => '1', 'item_name' => 'Product A', 'item_price' => 10.00, 'item_quantity' => 2],
            ['item_id' => '2', 'item_name' => 'Product B', 'item_price' => 15.00, 'item_quantity' => 3]
        ];

        $mockStmt = Mockery::mock(\mysqli_stmt::class);

        $this->mockDb->shouldReceive('prepare')->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')
            ->with('ssssssd', Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any(), Mockery::any(), 65.0)
            ->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('insert_id')->andReturn(1);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->orderService->createOrder($orderData, $cart);

        $this->assertTrue($result['success']);
    }

    /** @test */
    public function it_retrieves_orders_by_email()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')
            ->with(Mockery::pattern('/SELECT \* FROM orders WHERE user_email/'))
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->with('s', 'john@example.com')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);

        $mockResult->shouldReceive('fetch_assoc')
            ->andReturn(
                [
                    'id' => 1,
                    'user_email' => 'john@example.com',
                    'order_items' => json_encode([['item' => 'Product']]),
                    'total_amount' => 20.00
                ],
                null
            );

        $mockStmt->shouldReceive('close')->once();

        $orders = $this->orderService->getOrdersByEmail('john@example.com');

        $this->assertCount(1, $orders);
        $this->assertEquals('john@example.com', $orders[0]['user_email']);
        $this->assertIsArray($orders[0]['order_items']);
    }

    /** @test */
    public function it_retrieves_order_by_id()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("SELECT * FROM orders WHERE id = ?")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->with('i', 123)->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);

        $mockResult->shouldReceive('fetch_assoc')->andReturn([
            'id' => 123,
            'user_email' => 'john@example.com',
            'order_items' => json_encode([['item' => 'Product']]),
            'total_amount' => 20.00
        ]);

        $mockStmt->shouldReceive('close')->once();

        $order = $this->orderService->getOrderById(123);

        $this->assertNotNull($order);
        $this->assertEquals(123, $order['id']);
        $this->assertIsArray($order['order_items']);
    }

    /** @test */
    public function it_returns_null_for_nonexistent_order()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('fetch_assoc')->andReturn(null);
        $mockStmt->shouldReceive('close')->once();

        $order = $this->orderService->getOrderById(999);

        $this->assertNull($order);
    }
}
