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
                    echo "<br>Creating Student's Task";
                } else {
                    echo "User not found.";
                }
            }
            ?>
            !
        </p>
        
        
        
        
    </div>


    <!-- Task Management Section -->
    <div class="container" id="tasks">
        <h1 class="form-title">Task Management</h1>
        
        <!-- Form to Add a New Task -->
        <form method="post" action="register.php">
            <div class="input-group">
                <label for="description">Task Description:<br></label>
                <textarea name="description" id="description" rows="4" placeholder="Enter task description" required></textarea>
            </div>
            <input type="submit" class="btn" value="Add Task" name="addTask">
        </form>
        
        <!-- Display Existing Tasks with Options to Mark Complete/Delete -->
        <h2>Existing Tasks</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Complete</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($conn) {
                    $tasksQuery = mysqli_query($conn, "SELECT * FROM tasks");

                    if ($tasksQuery) {
                        if (mysqli_num_rows($tasksQuery) > 0) {
                            while ($task = mysqli_fetch_array($tasksQuery)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($task['description']) . "</td>";
                               
                                echo "<td>
                                        <form method='post' action='register.php' style='display:inline;'>
                                            <input type='hidden' name='task_id' value='" . htmlspecialchars($task['id']) . "'>
                                            <input type='submit' name='deleteTask' value='Delete'>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                            
                        } else {
                            echo "<tr><td colspan='3'>No tasks available.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Error fetching tasks: " . mysqli_error($conn) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Database connection error.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
