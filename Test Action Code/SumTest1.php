<?php
use PHPUnit\Framework\TestCase;

class SumTest extends TestCase {
  public function testAdd() {
    $this->assertEquals(3, Sum::add(1, 2));
  }
}
?>