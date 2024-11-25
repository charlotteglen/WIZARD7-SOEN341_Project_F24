<?php

use PHPUnit\Framework\TestCase;

class teacherpageTest extends TestCase
{
    private $mockConn;

    protected function setUp(): void
    {
        // Create a mock for the mysqli connection
        $this->mockConn = $this->createMock(mysqli::class);
    }

    public function testWelcomeMessage(): void
    {
        // Simulate session data
        $_SESSION['userName'] = 'teacher123';

        // Simulate a mock query result
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_array')->willReturn([
            'firstName' => 'John',
            'lastName' => 'Doe'
        ]);

        // Mock the database query
        $this->mockConn->method('query')->willReturn($mockResult);

        // Capture the output of the welcome message generation
        ob_start();
        if (isset($_SESSION['userName'])) {
            $userName = $_SESSION['userName'];
            $query = $this->mockConn->query("SELECT firstName, lastName FROM users WHERE userName='$userName'");
            if ($query && $row = $query->fetch_array()) {
                echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']);
            } else {
                echo "User not found.";
            }
        }
        $output = ob_get_clean();

        // Assertions
        $this->assertStringContainsString("John Doe", $output);
    }

    public function testTableRowRendering(): void
    {
        // Simulate a mock query result
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_array')
            ->will($this->onConsecutiveCalls(
                [
                    'studentid' => 1,
                    'firstName' => 'Alice',
                    'lastName' => 'Smith',
                    'role' => 'student',
                    'team' => 'Team A',
                    'avgEvalu' => 4.5,
                    'avgEvalu1' => 4.0,
                    'avgEvalu2' => 4.3,
                    'avgEvalu3' => 4.7,
                    'totalEvalu' => 4.375,
                    'numComment' => 5,
                    'numView' => 10
                ],
                false // Simulate end of result set
            ));

        // Mock the database query
        $this->mockConn->method('query')->willReturn($mockResult);

        // Capture the output of the table rendering
        ob_start();
        while ($user = $mockResult->fetch_array()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['studentid']) . "</td>";
            echo "<td>" . htmlspecialchars($user['firstName']) . "</td>";
            echo "<td>" . htmlspecialchars($user['lastName']) . "</td>";
            echo "<td>" . htmlspecialchars($user['role']) . "</td>";
            echo "<td>" . htmlspecialchars($user['team']) . "</td>";
            echo "<td>" . htmlspecialchars($user['avgEvalu']) . "</td>";
            echo "<td>" . htmlspecialchars($user['avgEvalu1']) . "</td>";
            echo "<td>" . htmlspecialchars($user['avgEvalu2']) . "</td>";
            echo "<td>" . htmlspecialchars($user['avgEvalu3']) . "</td>";
            echo "<td>" . htmlspecialchars($user['totalEvalu']) . "</td>";
            echo "<td>" . htmlspecialchars($user['numComment']) . "</td>";
            echo "<td>" . htmlspecialchars($user['numView']) . "</td>";
            echo "</tr>";
        }
        $output = ob_get_clean();

        // Assertions
        $this->assertStringContainsString("<td>1</td>", $output);
        $this->assertStringContainsString("<td>Alice</td>", $output);
        $this->assertStringContainsString("<td>Smith</td>", $output);
    }
}
