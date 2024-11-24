
<?php
// start
session_start();

// Include the database connection file
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Set the viewport to ensure proper scaling on different devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- Set the title of the page -->
        <title>Peer Assessment </title> 

        <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'></title>

        <link rel="stylesheet" href = "homepage.css">
        <link rel="stylesheet" href="teacher_style.css">

</head>
<body>

<!-- header -->
<div class = "bg-img"></div>
        <div class = "bg"></div>
        <div class = "header">
            <a href = "homepage1.php">
                <i class = "fas fa-user-circle"></i>
            </a>
            <h1> Peer Assessment </h1>
        </div>

        <!-- navigation bar -->
        <div class = "navbar">
            <a href = "homepage1.php"> <i class = "fas fa-home"></i> Home </a>
            <a href = "teacherpage.php"> <i class = "fas fa-users"></i> Team </a>
            <a href = "teacherdetail.php"> <i class = "fas fa-users"></i> Detailed View </a>
            <a href = "assign.php"> <i class = "fas fa-pencil-square"></i> Group Setting </a>
            <a href = "teachertask.php"> <i class = "fas fa-tasks"></i> Task </a>
            <a href = "logout.php" class = "right"> Logout </a>
        </div>
        


<div style="text-align:center;margin-bottom:30px;">
    <p style="font-size:50px; font-weight:bold;">
        Welcome  
        <?php 
        if(isset($_SESSION['userName'])) {
            $userName = $_SESSION['userName'];
            $query = mysqli_query($conn, "SELECT * FROM `users` WHERE userName='$userName'");
            while($row = mysqli_fetch_array($query)) {
                echo $row['firstName'] . '!';
            }
        }
        ?>
    </p>
    <h2>Detailed View</h2>
    </div>

    <div id="studentTables">

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
            echo "<h3>Group " . $currentGroup . "</h3>";
        }

        
        echo "<p id='student'>Student Name: " . $user['firstName'] . " " . $user['lastName'] . "<br>";
        echo "Student ID: " . $user['studentid'] . "</p>";


        echo "<table class='teamTable'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Evaluated By:</th>";
        echo "<th>Cooperation</th>";
        echo "<th>Conceptual</th>";
        echo "<th>Practical</th>";
        echo "<th>Work Ethic</th>";
        echo "<th>Average Across All</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        echo "<tr>";


        // Output the value of 'evalu' from the $user array inside a table cell
        echo "<td>" . $user['evaluStu'] . "</td>";
        echo "<td>" . $user['evalu'] . "</td>";
        echo "<td>" . $user['evalu1'] . "</td>";
        echo "<td>" . $user['evalu2'] . "</td>";
        echo "<td>" . $user['evalu3'] . "</td>";
        echo "<td>" . $user['avgAll'] . "</td>";
        echo "</tr>";
        echo "</tbody>";
        echo "</table>";


        echo "<div class='comments'>";

        $comments = explode('<br><br>', $user['stuComment']);
        echo "<h4>Comments</h4>";
        foreach($comments as $comment) {
            if (!empty($comment)) {
                echo "<p>$comment</p>";
            } else {
                echo "<p>No comments</p>";
            }
            echo "</br>";
        }
        echo "</div>";
    }


    if ($currentGroup !== null) {
        echo "</div>";
    }
    ?>

</div>

</body>
</html>
