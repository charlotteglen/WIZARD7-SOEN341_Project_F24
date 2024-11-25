<?php

use PHPUnit\Framework\TestCase;

class homepageTest extends TestCase {
    private $htmlContent;

    protected function setUp(): void {
        // Load the HTML content (adjust the path to your HTML file)
        $this->htmlContent = file_get_contents(__DIR__ . '/../homepage.php');
    }

    public function testHtmlStructureExists() {
        // Ensure the HTML content is not empty
        $this->assertNotEmpty($this->htmlContent, "HTML content is empty");

        // Check that the document has a title
        $this->assertStringContainsString("<title>Peer Assessment </title>", $this->htmlContent, "Title tag is missing or incorrect");

        // Check for the navigation bar
        $this->assertStringContainsString('<div class = "navbar">', $this->htmlContent, "Navbar is missing");

        // Check for all expected links in the navigation bar
        $this->assertStringContainsString('href = "homepage.php"', $this->htmlContent, "Home link is missing");
        $this->assertStringContainsString('href = "studentpage.php"', $this->htmlContent, "Team link is missing");
        $this->assertStringContainsString('href = "studentevalu.php"', $this->htmlContent, "Peer Assessment link is missing");
        $this->assertStringContainsString('href = "studenttask.php"', $this->htmlContent, "Task link is missing");
        $this->assertStringContainsString('href = "logout.php"', $this->htmlContent, "Logout link is missing");

        // Check for the instructions section
        $this->assertStringContainsString('<div class = "instructions">', $this->htmlContent, "Instructions section is missing");

        // Check for expected headings
        $this->assertStringContainsString("<h2> Peer Assessment </h2>", $this->htmlContent, "Peer Assessment heading is missing");
        $this->assertStringContainsString("<h2> Dashboard </h2>", $this->htmlContent, "Dashboard heading is missing");
    }
}
