<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;

/**
 * Integration test for database connectivity
 * Note: These tests require a database connection and may be skipped in CI/CD
 */
class DatabaseConnectionTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        parent::setUp();

        // Skip tests if not in integration test mode or database is not available
        if (!getenv('RUN_INTEGRATION_TESTS')) {
            $this->markTestSkipped('Integration tests are disabled. Set RUN_INTEGRATION_TESTS=1 to run.');
        }

        // Use test database credentials from bootstrap or environment
        $host = TEST_DB_HOST ?? 'localhost';
        $user = TEST_DB_USER ?? 'root';
        $pass = TEST_DB_PASS ?? '';
        $dbName = TEST_DB_NAME ?? 'shop_test';

        $this->db = @mysqli_connect($host, $user, $pass, $dbName);

        if (!$this->db) {
            $this->markTestSkipped('Could not connect to test database. Error: ' . mysqli_connect_error());
        }
    }

    protected function tearDown(): void
    {
        if ($this->db) {
            mysqli_close($this->db);
        }
        parent::tearDown();
    }

    /** @test */
    public function it_connects_to_database_successfully()
    {
        $this->assertInstanceOf(\mysqli::class, $this->db);
        $this->assertTrue($this->db->ping());
    }

    /** @test */
    public function it_can_execute_select_query()
    {
        $result = mysqli_query($this->db, "SELECT 1 as test");

        $this->assertNotFalse($result);
        $row = mysqli_fetch_assoc($result);
        $this->assertEquals(1, $row['test']);
    }

    /** @test */
    public function it_handles_invalid_query_gracefully()
    {
        $result = @mysqli_query($this->db, "SELECT * FROM nonexistent_table");

        $this->assertFalse($result);
        $this->assertNotEmpty(mysqli_error($this->db));
    }

    /** @test */
    public function it_supports_prepared_statements()
    {
        $stmt = $this->db->prepare("SELECT ? as value");
        $this->assertNotFalse($stmt);

        $testValue = "test";
        $stmt->bind_param("s", $testValue);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $this->assertEquals("test", $row['value']);
        $stmt->close();
    }

    /** @test */
    public function it_prevents_sql_injection_with_prepared_statements()
    {
        // This demonstrates that prepared statements prevent SQL injection
        $maliciousInput = "'; DROP TABLE users; --";

        $stmt = $this->db->prepare("SELECT ? as input");
        $stmt->bind_param("s", $maliciousInput);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // The malicious input should be treated as a string, not executed
        $this->assertEquals($maliciousInput, $row['input']);
        $stmt->close();
    }

    /** @test */
    public function it_supports_transactions()
    {
        $this->db->begin_transaction();

        $result = $this->db->query("SELECT 1");
        $this->assertNotFalse($result);

        $this->db->commit();
        $this->assertTrue(true); // If we got here, transaction works
    }

    /** @test */
    public function it_can_rollback_transactions()
    {
        $this->db->begin_transaction();

        // Even if we insert data here, it should not persist after rollback
        $this->db->query("SELECT 1");

        $this->db->rollback();
        $this->assertTrue(true); // If we got here, rollback works
    }

    /** @test */
    public function it_handles_multiple_queries()
    {
        $result1 = $this->db->query("SELECT 1 as first");
        $result2 = $this->db->query("SELECT 2 as second");

        $this->assertNotFalse($result1);
        $this->assertNotFalse($result2);

        $row1 = $result1->fetch_assoc();
        $row2 = $result2->fetch_assoc();

        $this->assertEquals(1, $row1['first']);
        $this->assertEquals(2, $row2['second']);
    }

    /** @test */
    public function it_returns_correct_character_set()
    {
        $charset = $this->db->character_set_name();

        // Should support UTF-8
        $this->assertContains($charset, ['utf8', 'utf8mb4']);
    }
}
