<?php
// Start the session
session_start();

// Include the database connection file
include("connect.php");

if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
    $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');

    // Skip the first line (column headings)
    fgetcsv($csvFile);

    // Loop through the file and insert data into the database
    while (($row = fgetcsv($csvFile)) !== FALSE) {
        // Prepare the data
        $studentid = mysqli_real_escape_string($conn, str_pad($row[0], 4, '0', STR_PAD_LEFT));
        $firstName = mysqli_real_escape_string($conn, $row[1]);
        $lastName = mysqli_real_escape_string($conn, $row[2]);
        $role = mysqli_real_escape_string($conn, $row[3]);
        $team = mysqli_real_escape_string($conn, $row[4]);
        $avgEvalu = mysqli_real_escape_string($conn, $row[5]);
        $avgEvalu1 = mysqli_real_escape_string($conn, $row[6]);
        $avgEvalu2 = mysqli_real_escape_string($conn, $row[7]);
        $avgEvalu3 = mysqli_real_escape_string($conn, $row[8]);
        $totalEvalu = mysqli_real_escape_string($conn, $row[9]);
        $numComment = mysqli_real_escape_string($conn, $row[10]);
        $numView = mysqli_real_escape_string($conn, $row[11]);

        // Insert the data into the database
        $query = "
            INSERT INTO users (studentid, firstName, lastName, role, team, avgEvalu, avgEvalu1, avgEvalu2, avgEvalu3, totalEvalu, numComment, numView)
            VALUES ('$studentid', '$firstName', '$lastName', '$role', '$team', '$avgEvalu', '$avgEvalu1', '$avgEvalu2', '$avgEvalu3', '$totalEvalu', '$numComment', '$numView')
            ON DUPLICATE KEY UPDATE
                firstName = VALUES(firstName),
                lastName = VALUES(lastName),
                role = VALUES(role),
                team = VALUES(team),
                avgEvalu = VALUES(avgEvalu),
                avgEvalu1 = VALUES(avgEvalu1),
                avgEvalu2 = VALUES(avgEvalu2),
                avgEvalu3 = VALUES(avgEvalu3),
                totalEvalu = VALUES(totalEvalu),
                numComment = VALUES(numComment),
                numView = VALUES(numView)
        ";
        mysqli_query($conn, $query);
    }

    fclose($csvFile);

    // Redirect back to the teacher page
    header('Location: teacherpage.php');
    exit();
} else {
    echo "Error uploading file.";
}
?>