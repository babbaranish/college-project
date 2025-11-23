<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class SimpleTest extends TestCase
{
    public function testBasicAssertion(): void
    {
        $this->assertTrue(true);
        $this->assertEquals(2, 1 + 1);
    }

    public function testStringOperations(): void
    {
        $this->assertEquals('hello', strtolower('HELLO'));
    }

    public function testArrayOperations(): void
    {
        $array = [1, 2, 3];
        $this->assertCount(3, $array);
        $this->assertContains(2, $array);
    }
}
