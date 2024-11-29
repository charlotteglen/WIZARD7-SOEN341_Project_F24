<?php

use PHPUnit\Framework\TestCase;

class ConnectTest extends TestCase {
    public function testDatabaseConnection() {
        try {
            // Include the file to test
            include '../connect.php';
            
            // If no exception is thrown, the connection is successful
            $this->assertTrue(true);
        } catch (Exception $e) {
            // If an exception is thrown, the connection failed
            $this->fail($e->getMessage());
        }
    }
}
?>