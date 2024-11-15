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
            <a href = "homepage.php"> <i class = "fas fa-home"></i> Home </a>
            <a href = "studentpage.php"> <i class = "fas fa-users"></i> Team </a>
            <a href = "studentevalu.php"> <i class = "fas fa-pencil-square"></i> Peer Assessment </a>
            <a href = "studenttask.php"> <i class = "fas fa-tasks"></i> Task </a>
            <a href = "logout.php" class = "right"> Logout </a>
        </div>
    <div style="text-align:center; padding:15%;">
      <p style="font-size:50px; font-weight:bold;">
       Welcome student 
       <?php 
       if(isset($_SESSION['userName'])){
            $userName = $_SESSION['userName'];
            $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.userName='$userName'");
            $row = mysqli_fetch_array($query);
            echo $row['firstName'] . ' ' . $row['lastName']."! <br>";
            echo "ID: " . $row['studentid']; 
            $studentGroup = $row['team'];
       }
       ?>
      </p>
   
        <!--task -->
        <form method="POST" action="register.php">
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Completion Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $taskQuery = mysqli_query($conn, "SELECT * FROM tasks");
            while ($task = mysqli_fetch_assoc($taskQuery)) {
                $task_id = $task['id'];
                $task_description = $task['description'];
                
                // Check if a task is marked as 'done' using localStorage before displaying the checkbox
                $checked = "";
                if (isset($_COOKIE['task_status_' . $task_id]) && $_COOKIE['task_status_' . $task_id] == "done") {
                    $checked = "checked";
                }

                // Display task with checkbox
                echo "<tr>
                        <td>" . $task_description . "</td>
                        <td>
                            <input type='hidden' name='task_status[$task_id]' value='undone'>
                            <input type='checkbox' name='task_status[$task_id]' value='done' $checked class='task_checkbox' data-task-id='$task_id'>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <button type="submit" name="submit_task">Submit Task</button>
</form>


<script>
// Function to save checkbox state to localStorage
function saveCheckboxState(taskId, isChecked) {
    if (isChecked) {
        localStorage.setItem('task_status_' + taskId, 'done'); // Save as 'done'
    } else {
        localStorage.removeItem('task_status_' + taskId); // Remove if unchecked
    }
}

// Add event listener to each checkbox
document.querySelectorAll('.task_checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        var taskId = this.getAttribute('data-task-id');
        saveCheckboxState(taskId, this.checked);
    });
});

// On page load, check the localStorage for saved checkbox states
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.task_checkbox').forEach(function(checkbox) {
        var taskId = checkbox.getAttribute('data-task-id');
        var status = localStorage.getItem('task_status_' + taskId);
        if (status === 'done') {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
    });
});
</script>



</body>
</html>
