<?php
session_start();
include("connect.php");

if (isset($_POST['evalu'])) {
    $studentid = $_POST['studentid'];
    $rating = (int)$_POST['rating'];
    $comment = $_POST['comment'];
    $rating1 = (int)$_POST['rating1'];
    $comment1 = $_POST['comment1'];
    $rating2 = (int)$_POST['rating2'];
    $comment2 = $_POST['comment2'];
    $rating3 = (int)$_POST['rating3'];
    $comment3 = $_POST['comment3'];

    // Prepare new evaluation entries
    $evalu = "Cooperation - Rating: $rating<br>Comment: $comment";
    $evalu1 = "Conceptual Contribution - Rating: $rating1<br>Comment: $comment1";
    $evalu2 = "Practical Contribution - Rating: $rating2<br>Comment: $comment2";
    $evalu3 = "Work Ethic - Rating: $rating3<br>Comment: $comment3";

    // Check if the student exists in the database
    $checkStudent = "SELECT * FROM users WHERE studentid = '$studentid'";
    $result = $conn->query($checkStudent);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Append new evaluations to existing ones with line breaks
        $existingEvalu = $user['evalu'] ? $user['evalu'] . "<br><br>" : ""; // Check if existing evaluations exist
        $existingEvalu1 = $user['evalu1'] ? $user['evalu1'] . "<br><br>" : "";
        $existingEvalu2 = $user['evalu2'] ? $user['evalu2'] . "<br><br>" : "";
        $existingEvalu3 = $user['evalu3'] ? $user['evalu3'] . "<br><br>" : "";

        // Update evaluations in the database
        $updateQuery = "UPDATE users SET 
            `evalu` = CONCAT('$existingEvalu', '$evalu'), 
            `evalu1` = CONCAT('$existingEvalu1', '$evalu1'), 
            `evalu2` = CONCAT('$existingEvalu2', '$evalu2'), 
            `evalu3` = CONCAT('$existingEvalu3', '$evalu3') 
            WHERE studentid = '$studentid'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "Evaluation submitted successfully! <br> <a href='studentpage.php'>Return to the student page!</a>";
        } else {
            echo "Error: Unable to assign the evaluation! <br> <a href='studentpage.php'>Return to the student page!</a>";
        }
    } else {
        echo "Student ID not found!<br> <a href='studentpage.php'>Return to the student page!</a>";
    }
}
