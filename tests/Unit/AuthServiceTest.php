<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\AuthService;
use Mockery;

class AuthServiceTest extends TestCase
{
    private $mockDb;
    private $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDb = Mockery::mock(\mysqli::class);
        $this->authService = new AuthService($this->mockDb);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_authenticates_admin_with_correct_credentials()
    {
        $result = $this->authService->authenticate('admin@gmail.com', 'admin');

        $this->assertTrue($result['success']);
        $this->assertEquals('admin', $result['type']);
        $this->assertEquals('admin@gmail.com', $result['email']);
    }

    /** @test */
    public function it_authenticates_admin_case_insensitive()
    {
        $result = $this->authService->authenticate('ADMIN@GMAIL.COM', 'admin');

        $this->assertTrue($result['success']);
        $this->assertEquals('admin', $result['type']);
    }

    /** @test */
    public function it_rejects_admin_with_wrong_password()
    {
        $result = $this->authService->authenticate('admin@gmail.com', 'wrongpassword');

        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('error', $result);
    }

    /** @test */
    public function it_authenticates_regular_user_with_correct_credentials()
    {
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);

        // Mock prepared statement
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')
            ->with("SELECT email, password FROM users WHERE email = ?")
            ->andReturn($mockStmt);

        $mockStmt->shouldReceive('bind_param')->with('s', 'user@example.com')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('fetch_assoc')->andReturn([
            'email' => 'user@example.com',
            'password' => $hashedPassword
        ]);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->authService->authenticate('user@example.com', 'password123');

        $this->assertTrue($result['success']);
        $this->assertEquals('user', $result['type']);
        $this->assertEquals('user@example.com', $result['email']);
    }

    /** @test */
    public function it_rejects_user_with_wrong_password()
    {
        $hashedPassword = password_hash('correctpassword', PASSWORD_DEFAULT);

        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('fetch_assoc')->andReturn([
            'email' => 'user@example.com',
            'password' => $hashedPassword
        ]);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->authService->authenticate('user@example.com', 'wrongpassword');

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid credentials', $result['error']);
    }

    /** @test */
    public function it_rejects_nonexistent_user()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('fetch_assoc')->andReturn(null);
        $mockStmt->shouldReceive('close')->once();

        $result = $this->authService->authenticate('nonexistent@example.com', 'password');

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid credentials', $result['error']);
    }

    /** @test */
    public function it_rejects_empty_email()
    {
        $result = $this->authService->authenticate('', 'password');

        $this->assertFalse($result['success']);
        $this->assertEquals('Email and password are required', $result['error']);
    }

    /** @test */
    public function it_rejects_empty_password()
    {
        $result = $this->authService->authenticate('user@example.com', '');

        $this->assertFalse($result['success']);
        $this->assertEquals('Email and password are required', $result['error']);
    }

    /** @test */
    public function it_rejects_invalid_email_format()
    {
        $result = $this->authService->authenticate('not-an-email', 'password');

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid email format', $result['error']);
    }

    /** @test */
    public function it_handles_database_error_gracefully()
    {
        $this->mockDb->shouldReceive('prepare')->andReturn(false);

        $result = $this->authService->authenticate('user@example.com', 'password');

        $this->assertFalse($result['success']);
        $this->assertEquals('Database error', $result['error']);
    }

    /** @test */
    public function it_registers_new_user_successfully()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        // Mock check if user exists (returns no rows)
        $this->mockDb->shouldReceive('prepare')
            ->with("SELECT email FROM users WHERE email = ?")
            ->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->with('s', 'newuser@example.com')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('num_rows')->andReturn(0);
        $mockStmt->shouldReceive('close')->once();

        // Mock insert new user
        $this->mockDb->shouldReceive('prepare')
            ->with("INSERT INTO users (email, password) VALUES (?, ?)")
            ->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->with('ss', 'newuser@example.com', Mockery::any())->once();
        $mockStmt->shouldReceive('execute')->andReturn(true)->once();
        $mockStmt->shouldReceive('close')->once();

        $result = $this->authService->register('newuser@example.com', 'password123', 'password123');

        $this->assertTrue($result['success']);
        $this->assertEquals('newuser@example.com', $result['email']);
    }

    /** @test */
    public function it_rejects_registration_with_mismatched_passwords()
    {
        $result = $this->authService->register('user@example.com', 'password1', 'password2');

        $this->assertFalse($result['success']);
        $this->assertEquals('Passwords do not match', $result['error']);
    }

    /** @test */
    public function it_rejects_registration_with_short_password()
    {
        $result = $this->authService->register('user@example.com', 'pass', 'pass');

        $this->assertFalse($result['success']);
        $this->assertEquals('Password must be at least 6 characters', $result['error']);
    }

    /** @test */
    public function it_rejects_registration_with_duplicate_email()
    {
        $mockStmt = Mockery::mock(\mysqli_stmt::class);
        $mockResult = Mockery::mock(\mysqli_result::class);

        $this->mockDb->shouldReceive('prepare')->andReturn($mockStmt);
        $mockStmt->shouldReceive('bind_param')->once();
        $mockStmt->shouldReceive('execute')->once();
        $mockStmt->shouldReceive('get_result')->andReturn($mockResult);
        $mockResult->shouldReceive('num_rows')->andReturn(1); // User exists
        $mockStmt->shouldReceive('close')->once();

        $result = $this->authService->register('existing@example.com', 'password123', 'password123');

        $this->assertFalse($result['success']);
        $this->assertEquals('Email already registered', $result['error']);
    }

    /** @test */
    public function it_rejects_registration_with_invalid_email()
    {
        $result = $this->authService->register('invalid-email', 'password123', 'password123');

        $this->assertFalse($result['success']);
        $this->assertEquals('Invalid email format', $result['error']);
    }

    /** @test */
    public function it_correctly_identifies_admin_email()
    {
        $this->assertTrue($this->authService->isAdmin('admin@gmail.com'));
        $this->assertTrue($this->authService->isAdmin('ADMIN@GMAIL.COM')); // Case insensitive
        $this->assertFalse($this->authService->isAdmin('user@example.com'));
    }

    /** @test */
    public function it_trims_and_lowercases_email_during_authentication()
    {
        $result = $this->authService->authenticate('  ADMIN@GMAIL.COM  ', 'admin');

        $this->assertTrue($result['success']);
        $this->assertEquals('admin@gmail.com', $result['email']);
    }
}
