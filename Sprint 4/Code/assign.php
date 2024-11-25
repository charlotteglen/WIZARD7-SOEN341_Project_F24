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
        <link rel="stylesheet" href="teacher_style.css"
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
            <a href = "logout.php" class = "right"> Logout </a>
        </div>
        
    <!-- Welcome message for the teacher -->
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
        
<div class ="content-wrapper">
    
<div class="infotable" id="infoTable">
<h2 style = padding:12px;text-align:center>Student Information</h2>
    <table class="teamTable">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Group</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $allUsersQuery = mysqli_query($conn, "SELECT * FROM users WHERE role='student'");
            
            while ($user = mysqli_fetch_array($allUsersQuery)) {
                echo "<tr>";
                // Output the value of ' ' from the $user array inside a table cell, with HTML special characters converted to HTML entities
                echo "<td>" . htmlspecialchars($user['studentid']) . "</td>";
                echo "<td>" . htmlspecialchars($user['firstName']) . "</td>";
                echo "<td>" . htmlspecialchars($user['lastName']) . "</td>";
                echo "<td>" . htmlspecialchars($user['team']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
    </div>

    <div class="team-creation" id="teamCreation">
    <h2 style=text-align:center;padding:10px>Create or Change Teams</h2>

    <div class="assign-method">
    <form method="post" action="register.php">
    <p style=font-weight:bold>Assign Manually</p>

    <div class="input-group">
        <label for="fname">Enter Student's ID:</label>
        <i class="fas fa-user"></i>
       <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
    </div>

      <div class="input-group">
        <label for="userName">Enter the Student's Team Number:</label>
          <i class="fas fa-user"></i>
          <input type="number" step="1" name="team" id="team" placeholder="User Team" required min="1">
      </div>

      <button value="Change" name="change" class="button-3">Assign Student</button>

    </form>
  </div>

  <div class="assign-method">
  <p style=font-weight:bold>Upload from class CSV file</p>
    <form action="upload_csv.php" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" accept=".csv" required>
        <button type="submit" class="button-3">Upload</button>
    </form>
</div>

  <div class="assign-method">
    <p style=font-weight:bold>Download Class Information</p>
    <a href="export_csv.php" class="button-3">Download</a>
</div>

  </div>

</div>

</body>
</html>
