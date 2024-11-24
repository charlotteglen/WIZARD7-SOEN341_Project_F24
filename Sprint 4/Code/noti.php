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
                    echo "<br>Notification";
                } else {
                    echo "User not found.";
                }
            }
            ?>
            !
        </p>
        
        <!-- User Information Table -->
        <h2>Your New Notifications</h2>
        <?php
        // Fetch only notifications with content
        $notificationsQuery = mysqli_query($conn, "SELECT * FROM users WHERE role='student' AND noti <> ''");
        if ($notificationsQuery && mysqli_num_rows($notificationsQuery) > 0) {
            echo '<table>';
            echo '<thead>
                    <tr>
                        <th>Notification</th>
                        <th>Clear Notification</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            while ($user = mysqli_fetch_array($notificationsQuery)) {
                echo "<tr>";
                echo "<td>" .$user['noti'] . "</td>";
                echo "<td>
                                <form method='post' action='register.php' style='display:inline;'>
                                    <input type='hidden' name='studentid' value='" . htmlspecialchars($user['studentid']) . "'>
                                    <input type='submit' name='deleteNoti' value='Clear'>
                                </form>
                              </td>";
                echo "</tr>";
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            // No notifications
            echo '<p style="font-size:20px; font-weight:bold; color:gray;">No new notifications!</p>';
        }
        ?>
        
        <br>
    </div>

</body>
</html>
