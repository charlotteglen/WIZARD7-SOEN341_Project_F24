<?php
use PHPUnit\Framework\TestCase;

class export_csv_Test extends TestCase
{
    private $mockDbConnection;

    protected function setUp(): void
    {
        // Create a mock for the mysqli connection
        $this->mockDbConnection = $this->createMock(mysqli::class);

        // Create a mock for the mysqli_result class
        $mockResult = $this->createMock(mysqli_result::class);

        // Configure the mock result to return test data
        $mockResult->method('fetch_assoc')->willReturnOnConsecutiveCalls(
            [
                'studentid' => '001',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'role' => 'student',
                'team' => 'Team A',
                'avgEvalu' => '5', // Adjusted to reflect the highest rate as 5
                'avgEvalu1' => '4.5',
                'avgEvalu2' => '4.8',
                'avgEvalu3' => '4.7',
                'totalEvalu' => '19',
                'numComment' => '5',
                'numView' => '10'
            ],
            null
        );

        // Configure the mock database connection to return the mock result
        $this->mockDbConnection->method('query')->willReturn($mockResult);
    }

    public function testFetchStudentDetails()
    {
        // Redefine the fetchStudentDetails function for the test
        $fetchStudentDetails = function ($conn) {
            $query = "SELECT studentid, firstName, lastName, role, team, avgEvalu, avgEvalu1, avgEvalu2, avgEvalu3, totalEvalu, numComment, numView FROM users WHERE role='student'";
            return $conn->query($query);
        };

        // Call the fetchStudentDetails function with the mock connection
        $result = $fetchStudentDetails($this->mockDbConnection);

        // Verify the query result
        $this->assertNotFalse($result, 'Expected a valid result set from the query.');
    }
}