<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Peer Assessment </title> 
        <!-- icons -->
        <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- font -->
        <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'></title>
        <!-- link reference for css -->
        <link rel="stylesheet" href = "homepage.css">
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
     <!-- header -->
     <div class = "bg-img"></div>
        <div class = "bg"></div>
        <div class = "header">
            <a href = "homepage.html">
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
            <a href = "noti.php"> <i class = "fas fa-bell"></i> Notification </a>
            <a href = "logout.php" class = "right"> Logout </a>
        </div>
    <!-- Welcome message for the teacher -->
    <div style="text-align:center; padding:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Welcome Teacher 
            <?php 
            if (isset($_SESSION['userName'])) {
                $userName = $_SESSION['userName'];
                $query = mysqli_query($conn, "SELECT firstName, lastName FROM users WHERE userName='$userName'");
                if ($query && $row = mysqli_fetch_array($query)) {
                    echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']);
                    echo "<br>Please assign a student to a group";
                } else {
                    echo "User not found.";
                }
            }
            ?>
            !
        </p>
        
        <!-- User Information Table -->
        <h2>User Information Table</h2>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Group</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $allUsersQuery = mysqli_query($conn, "SELECT * FROM users WHERE role='student'");
                
                while ($user = mysqli_fetch_array($allUsersQuery)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['studentid']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['firstName']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['lastName']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['team']) . "</td>";
                    
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
        <br>
    </div>

    <!-- Form to Assign Student to a Group -->
    <div class="container" id="change">
        <h1 class="form-title">Assigning a student to a Group:</h1>
        <form method="post" action="register.php">
            <div class="input-group">
                <label for="studentid">Enter the Student ID:</label>
                <input type="text" name="studentid" id="studentid" placeholder="Student ID" required>
            </div>
            <div class="input-group">
                <label for="team">Enter the Student's group:</label>
                <input type="text" name="team" id="team" placeholder="User Group" required>
            </div>
            <input type="submit" class="btn" value="Change" name="change">
        </form>
    </div>

</body>
</html>
