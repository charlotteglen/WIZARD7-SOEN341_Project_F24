<?php
// Include database connection file
include_once 'connect.php'; // Adjust the file path to your actual database connection file

// Set the headers to indicate file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=students_data.csv');

// Open a file pointer for output
$output = fopen('php://output', 'w');

// Write the column headers
fputcsv($output, array('Student ID', 'First Name', 'Last Name', 'Role', 'Group', 'Cooperation Dimension', 'Conceptual Contribution', 'Practical Contribution', 'Work Ethic', 'Average', 'Peers who responded', 'Number of views'));

// Connect to the database and fetch the data
$conn = mysqli_connect("localhost", "root", "", "login"); // Replace with your database credentials

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Query to fetch data
$query = "SELECT studentid, firstName, lastName, role, team, avgEvalu, avgEvalu1, avgEvalu2, avgEvalu3, totalEvalu, numComment, numView FROM users WHERE role='student'";
$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch rows and write to the CSV
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
} else {
    echo "Error fetching data: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);

// Close the file pointer
fclose($output);
exit;
?>
