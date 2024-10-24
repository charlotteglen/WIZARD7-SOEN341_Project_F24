<?php
// Start the session
session_start();
// Include the database connection file
include("connect.php");

// Check if the user is logged in
if (!isset($_SESSION['userName'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

// Fetch the data from the database
$allUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE role='student'");

// Create a file pointer connected to the output stream
$output = fopen("php://output", "w");

// Set the headers to download the file rather than display it
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="students.csv"');

// Output the column headings
fputcsv($output, ['Student ID', 'First Name', 'Last Name', 'Role', 'Group', 'Cooperation Dimension', 'Conceptual Contribution', 'Practical Contribution', 'Work Ethic']);

// Fetch and output the data
while ($user = mysqli_fetch_array($allUsersQuery)) {
    fputcsv($output, [
        $user['studentid'],
        $user['firstName'],
        $user['lastName'],
        $user['role'],
        $user['group'],
        $user['evalu'],
        $user['evalu1'],
        $user['evalu2'],
        $user['evalu3']
    ]);
}

// Close the output stream
fclose($output);
exit();
?>
