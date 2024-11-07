<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed View</title>
    <style>
        table {
            width: 50%;
            margin: auto;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .student-section {
            margin: 20px auto;
            padding: 10px;
            width: 80%;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div style="text-align:center; padding:15%;">
    <p style="font-size:50px; font-weight:bold;">
        Welcome Teacher 
        <?php 
        if(isset($_SESSION['userName'])) {
            $userName = $_SESSION['userName'];
            $query = mysqli_query($conn, "SELECT * FROM `users` WHERE userName='$userName'");
            while($row = mysqli_fetch_array($query)) {
                echo $row['firstName'].' '.$row['lastName'];
                echo "<br>The detailed view";
            }
        }
        ?>
    !
    </p>
    <a href="teacherpage.php">Home page</a><br>
    <a href="logout.php">Logout</a>
    <h2>Detailed View</h2>

    <?php
    // Fetch students sorted by group
    $allUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE role='student' ORDER BY `team`");
    
    $currentGroup = null;
    while($user = mysqli_fetch_array($allUsersQuery)) {
        if ($currentGroup !== $user['team']) {
            if ($currentGroup !== null) {
                echo "</div>"; // Close the previous group section
            }
            $currentGroup = $user['team'];
            echo "<div class='student-section'>";
            echo "<h3>Group: " . $currentGroup . "</h3>";
        }

        echo "<p>Student Name: " . $user['firstName'] . " " . $user['lastName'] . "<br>";
        echo "Student ID: " . $user['studentid'] . "</p>";

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Member</th>";
        echo "<th>Cooperation</th>";
        echo "<th>Conceptual</th>";
        echo "<th>Practical</th>";
        echo "<th>Work Ethic</th>";
        echo "<th>Average Across All</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";
        echo "<td>" . $user['evaluStu'] . "</td>";
        echo "<td>" . $user['evalu'] . "</td>";
        echo "<td>" . $user['evalu1'] . "</td>";
        echo "<td>" . $user['evalu2'] . "</td>";
        echo "<td>" . $user['evalu3'] . "</td>";
        echo "<td>" . $user['avgAll'] . "</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";

        // Display comments if available
        $comments = explode('<br><br>', $user['stuComment']);
        echo "<h4>Comments:</h4>";
        foreach($comments as $comment) {
            if (!empty($comment)) {
                echo "<p>$comment</p>";
            } else {
                echo "<p>No comment </p>";
            }
        }
    }

    if ($currentGroup !== null) {
        echo "</div>"; // Close the last group section
    }
    ?>

    <a href="teacherpage.php">Home page</a><br>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>