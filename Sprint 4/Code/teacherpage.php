<?php
// Start the session
session_start();

// Include the database connection file
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <!-- Set the character encoding for the document -->
<meta charset="UTF-8">

    <!-- Set the viewport to ensure proper scaling on different devices -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Set the title of the page -->
        <title>Peer Assessment </title> 
        
        <!-- icons -->
        <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        
        <!-- font -->
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'></title>

        <!-- link reference for css -->
        <link rel="stylesheet" href = "homepage.css">
        <link rel="stylesheet" href = "teacher_style.css">
</head>
<body>
    
     <!-- header -->
     <div class = "bg-img"></div>
        <div class = "bg"></div>
        <div class = "header">
            <a href = "homepage1.php">
                <i class = "fas fa-user-circle"></i>
            </a>
            <h1>Peer Assessment</h1>
        </div>

        <!-- navigation bar -->
        <div class = "navbar">
            <a href = "homepage1.php"> <i class = "fas fa-home"></i> Home </a>
            <a href = "teacherpage.php"> <i class = "fas fa-users"></i> Team </a>
            <a href = "teacherdetail.php"> <i class = "fas fa-users"></i> Detailed View </a>
            <a href = "assign.php"> <i class = "fas fa-pencil-square"></i> Group Setting </a>
            <a href = "teachertask.php"> <i class = "fas fa-tasks"></i> Task </a>
            <a href = "noti.php"> <i class = "fas fa-bell"></i> Notification </a>
            <a href = "logout.php" class = "right"> Logout </a>
        </div>


    <div id="welcome">
        <h2 id="welcome">
            Welcome 
            <?php 
            if (isset($_SESSION['userName'])) {
                $userName = $_SESSION['userName'];
                $query = mysqli_query($conn, "SELECT firstName, lastName FROM users WHERE userName='$userName'");
                if ($query && $row = mysqli_fetch_array($query)) {
                    echo htmlspecialchars($row['firstName'] . '!');
                    echo "<br>Class Overview";
                } else {
                    echo "User not found.";
                }
            }
            ?>
        </h2>
    </div>

    
    <div>
        <table class="teamTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Group</th>
                    <th>Cooperation Dimension</th>
                    <th>Conceptual Contribution</th>
                    <th>Practical Contribution</th>
                    <th>Work Ethic</th>
                    <th>Average Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUsersQuery = mysqli_query($conn, "SELECT * FROM users WHERE role='student'");
                
                while ($user = mysqli_fetch_array($allUsersQuery)) {
                    echo "<tr>";
                    echo "<td>" . $user['firstName'] . " " . $user['lastName'] . "</td>";
                    echo "<td>" . $user['studentid'] . "</td>";
                    echo "<td>" . $user['team'] . "</td>";
                    echo "<td>" . $user['evalu'] . "</td>";
                    echo "<td>" . $user['evalu1'] . "</td>";
                    echo "<td>" . $user['evalu2'] . "</td>";
                    echo "<td>" . $user['evalu3'] . "</td>";
                    echo "<td>" . $user['avgAll'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
        </div>

</body>
</html>
