<?php
// Start the session
session_start();

// Include the database connection file
include("connect.php");

// Set the headers to indicate a file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=details.csv');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Output the column headings
fputcsv($output, array('Student ID', 'First Name', 'Last Name', 'Role', 'Group', 'Cooperation Dimension', 'Conceptual Contribution', 'Practical Contribution', 'Work Ethic', 'Average', 'Peers who responded', 'Number of views'));

// Fetch the details from the database
$query = "SELECT studentid, firstName, lastName, role, team, avgEvalu, avgEvalu1, avgEvalu2, avgEvalu3, totalEvalu, numComment, numView FROM users WHERE role='student'";
$result = mysqli_query($conn, $query);

// Loop over the rows and output them
while ($row = mysqli_fetch_assoc($result)) {
    // Ensure studentid retains leading zeros by treating it as a string
    $row['studentid'] = "\t" . str_pad($row['studentid'], 4, '0', STR_PAD_LEFT);
    
    // Output the row
    fputcsv($output, array(
        $row['studentid'],
        $row['firstName'],
        $row['lastName'],
        $row['role'],
        $row['team'],
        $row['avgEvalu'],
        $row['avgEvalu1'],
        $row['avgEvalu2'],
        $row['avgEvalu3'],
        $row['totalEvalu'],
        $row['numComment'],
        $row['numView']
    ));
}

// Close the file pointer
fclose($output);
exit();
?>