<?php

use PHPUnit\Framework\TestCase;

class StudentPageTest extends TestCase
{
    private $sessionData;

    protected function setUp(): void
    {
        // Simulate session data
        $this->sessionData = [
            'userName' => 'student1'
        ];
    }

    public function testDisplayWelcomeMessage(): void
    {
        // Simulate a fetched user row
        $mockUserRow = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'studentid' => 12345
        ];

        $output = $this->getWelcomeMessage($mockUserRow);

        // Assertions
        $this->assertStringContainsString("Welcome student", $output);
        $this->assertStringContainsString("John Doe!", $output);
        $this->assertStringContainsString("ID: 12345", $output);
    }

    public function testHandleEmptyGroup(): void
    {
        $studentGroup = null;
        $output = $this->getGroupMessage($studentGroup);

        // Assertions
        $this->assertEquals("<h2>You are not yet assigned to a group.</h2>", $output);
    }

    public function testRenderUserTable(): void
    {
        $mockUsers = [
            [
                'studentid' => 12345,
                'firstName' => 'John',
                'lastName' => 'Doe',
                'role' => 'Member',
                'team' => 'TeamA',
                'evalu' => 5,
                'evalu1' => 4,
                'evalu2' => 3,
                'evalu3' => 5,
                'evaluStu' => 'Yes',
                'numComment' => 2,
                'avgAll' => 4.25,
                'stuComment' => 'Great team player!<br><br>Consistent effort.'
            ]
        ];

        $output = $this->renderUserTable($mockUsers, 'TeamA');

        // Assertions
        $this->assertStringContainsString("<table>", $output);
        $this->assertStringContainsString("<th>Student ID</th>", $output);
        $this->assertStringContainsString("<td>12345</td>", $output);
        $this->assertStringContainsString("Great team player!", $output);
    }

    // Helper functions to test specific pieces of logic

    private function getWelcomeMessage(array $userRow): string
    {
        return "Welcome student " . $userRow['firstName'] . " " . $userRow['lastName'] . "! <br>ID: " . $userRow['studentid'];
    }

    private function getGroupMessage(?string $studentGroup): string
    {
        if (empty($studentGroup)) {
            return "<h2>You are not yet assigned to a group.</h2>";
        }

        return "<h2>User Information Table (Group $studentGroup)</h2>";
    }

    private function renderUserTable(array $users, string $group): string
    {
        $output = "<h2>User Information Table (Group $group)</h2>";
        $output .= "<table>";
        $output .= "<thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Group</th>
                <th>Cooperation Dimension</th>
                <th>Conceptual Contribution</th>
                <th>Practical Contribution</th>
                <th>Work Ethic</th>
                <th>Student Responded</th>
                <th>Peers who responded</th>
                <th>Average Across All</th>
            </tr>
        </thead>";
        $output .= "<tbody>";

        foreach ($users as $user) {
            $output .= "<tr>";
            $output .= "<td>" . $user['studentid'] . "</td>";
            $output .= "<td>" . $user['firstName'] . "</td>";
            $output .= "<td>" . $user['lastName'] . "</td>";
            $output .= "<td>" . $user['role'] . "</td>";
            $output .= "<td>" . $user['team'] . "</td>";
            $output .= "<td>" . $user['evalu'] . "</td>";
            $output .= "<td>" . $user['evalu1'] . "</td>";
            $output .= "<td>" . $user['evalu2'] . "</td>";
            $output .= "<td>" . $user['evalu3'] . "</td>";
            $output .= "<td>" . $user['evaluStu'] . "</td>";
            $output .= "<td>" . $user['numComment'] . "</td>";
            $output .= "<td>" . $user['avgAll'] . "</td>";
            $output .= "</tr>";

            // Add comments row
            $comments = explode('<br><br>', $user['stuComment']);
            $output .= "<tr><td colspan='12'><strong>Comments:</strong><br>";
            foreach ($comments as $comment) {
                $output .= "<p>" . $comment . "</p>";
            }
            $output .= "</td></tr>";
        }

        $output .= "</tbody>";
        $output .= "</table>";

        return $output;
    }
}
