<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ProductService;
use Mockery;

class ProductServiceTest extends TestCase
{
    private $mockDb;
    private $productService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDb = Mockery::mock(\mysqli::class);
        $this->productService = new ProductService($this->mockDb);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_validates_categories_correctly()
    {
        $this->assertTrue($this->productService->isValidCategory('hats'));
        $this->assertTrue($this->productService->isValidCategory('jackets'));
        $this->assertTrue($this->productService->isValidCategory('mens'));
        $this->assertTrue($this->productService->isValidCategory('womens'));
        $this->assertTrue($this->productService->isValidCategory('sneakers'));
        $this->assertFalse($this->productService->isValidCategory('invalid'));
        $this->assertFalse($this->productService->isValidCategory(''));
    }

    /** @test */
    public function it_returns_valid_categories()
    {
        $categories = $this->productService->getValidCategories();

        $this->assertCount(5, $categories);
        $this->assertContains('hats', $categories);
        $this->assertContains('sneakers', $categories);
    }

    /** @test */
    public function it_adds_product_successfully()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("INSERT INTO hats (product, price, image) VALUES (?, ?, ?)")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->with('sds', 'Cool Hat', 29.99, 'hat.jpg')->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('insert_id')->andReturn(1);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->productService->addProduct('hats', 'Cool Hat', 29.99, 'hat.jpg');

        $this->assertTrue($result['success']);
        $this->assertEquals(1, $result['productId']);
    }

    /** @test */
    public function it_rejects_product_with_invalid_category()
    {
        $result = $this->productService->addProduct('invalid', 'Product', 10.00, 'image.jpg');

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid category', $result['error']);
    }

    /** @test */
    public function it_rejects_product_with_short_name()
    {
        $result = $this->productService->addProduct('hats', 'A', 10.00, 'image.jpg');

        $this->assertFalse($result['success']);
        $this->assertEquals('Product name must be at least 2 characters', $result['error']);
    }

    /** @test */
    public function it_rejects_product_with_zero_price()
    {
        $result = $this->productService->addProduct('hats', 'Hat', 0, 'image.jpg');

        $this->assertFalse($result['success']);
        $this->assertEquals('Price must be greater than 0', $result['error']);
    }

    /** @test */
    public function it_rejects_product_with_negative_price()
    {
        $result = $this->productService->addProduct('hats', 'Hat', -10.00, 'image.jpg');

        $this->assertFalse($result['success']);
        $this->assertEquals('Price must be greater than 0', $result['error']);
    }

    /** @test */
    public function it_rejects_product_without_image()
    {
        $result = $this->productService->addProduct('hats', 'Hat', 10.00, '');

        $this->assertFalse($result['success']);
        $this->assertEquals('Image path is required', $result['error']);
    }

    /** @test */
    public function it_removes_product_successfully()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("DELETE FROM hats WHERE id = ?")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->with('i', 1)->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('affected_rows')->andReturn(1);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->productService->removeProduct('hats', 1);

        $this->assertTrue($result['success']);
    }

    /** @test */
    public function it_rejects_removing_product_with_invalid_category()
    {
        $result = $this->productService->removeProduct('invalid', 1);

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid category', $result['error']);
    }

    /** @test */
    public function it_rejects_removing_product_with_invalid_id()
    {
        $result = $this->productService->removeProduct('hats', 0);

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid product ID', $result['error']);
    }

    /** @test */
    public function it_returns_error_when_product_not_found()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);

        $this->mockDb->shouldReceive('prepare')->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('affected_rows')->andReturn(0);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->productService->removeProduct('hats', 999);

        $this->assertFalse($result['success']);
        $this->assertEquals('Product not found', $result['error']);
    }

    /** @test */
    public function it_gets_product_by_id()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("SELECT * FROM hats WHERE id = ?")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->with('i', 1)->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('fetch_assoc')->andReturn([
            'id' => 1,
            'product' => 'Cool Hat',
            'price' => 29.99,
            'image' => 'hat.jpg'
        ]);
        $mockStmt->shouldReceive('close')->once();

        $product = $this->productService->getProduct('hats', 1);

        $this->assertNotNull($product);
        $this->assertEquals('Cool Hat', $product['product']);
        $this->assertEquals(29.99, $product['price']);
    }

    /** @test */
    public function it_returns_null_for_invalid_category()
    {
        $product = $this->productService->getProduct('invalid', 1);

        $this->assertNull($product);
    }

    /** @test */
    public function it_gets_all_products_by_category()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("SELECT * FROM hats")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('fetch_assoc')->andReturn(
            ['id' => 1, 'product' => 'Hat 1', 'price' => 10.00],
            ['id' => 2, 'product' => 'Hat 2', 'price' => 20.00],
            null
        );
        $mockStmt->shouldReceive('close')->once();

        $products = $this->productService->getProductsByCategory('hats');

        $this->assertCount(2, $products);
        $this->assertEquals('Hat 1', $products[0]['product']);
    }

    /** @test */
    public function it_returns_empty_array_for_invalid_category()
    {
        $products = $this->productService->getProductsByCategory('invalid');

        $this->assertEmpty($products);
    }

    /** @test */
    public function it_updates_product_successfully()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("UPDATE hats SET product = ?, price = ? WHERE id = ?")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('close')->once();

        $result = $this->productService->updateProduct('hats', 1, [
            'product' => 'Updated Hat',
            'price' => 39.99
        ]);

        $this->assertTrue($result['success']);
    }

    /** @test */
    public function it_rejects_update_with_invalid_category()
    {
        $result = $this->productService->updateProduct('invalid', 1, ['product' => 'Hat']);

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid category', $result['error']);
    }

    /** @test */
    public function it_rejects_update_with_negative_price()
    {
        $result = $this->productService->updateProduct('hats', 1, ['price' => -10]);

        $this->assertFalse($result['success']);
        $this->assertEquals('Price must be greater than 0', $result['error']);
    }

    /** @test */
    public function it_rejects_update_with_no_data()
    {
        $result = $this->productService->updateProduct('hats', 1, []);

        $this->assertFalse($result['success']);
        $this->assertEquals('No data to update', $result['error']);
    }

    /** @test */
    public function it_validates_image_file_size()
    {
        $file = [
            'tmp_name' => '/tmp/test',
            'error' => UPLOAD_ERR_OK,
            'size' => 6 * 1024 * 1024 // 6MB - too large
        ];

        $result = $this->productService->validateImageFile($file);

        $this->assertFalse($result['valid']);
        $this->assertEquals('File size must be less than 5MB', $result['error']);
    }

    /** @test */
    public function it_validates_upload_errors()
    {
        $file = [
            'tmp_name' => '/tmp/test',
            'error' => UPLOAD_ERR_PARTIAL,
            'size' => 1024
        ];

        $result = $this->productService->validateImageFile($file);

        $this->assertFalse($result['valid']);
        $this->assertEquals('File upload error', $result['error']);
    }

    /** @test */
    public function it_rejects_missing_file()
    {
        $file = [
            'tmp_name' => '',
            'error' => UPLOAD_ERR_NO_FILE
        ];

        $result = $this->productService->validateImageFile($file);

        $this->assertFalse($result['valid']);
        $this->assertEquals('No file uploaded', $result['error']);
    }
}
