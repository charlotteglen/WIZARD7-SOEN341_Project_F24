<?php
session_start();
include("connect.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor's Homepage</title>
    <link rel="stylesheet" href="teacher_style.css">
    <script src="script.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
</head>

<body>
  <!--welcome banner -->
    <div id = "welcome">
      <h2 id="welcome">
       Welcome <?php 
       if(isset($_SESSION['userName'])){
        $userName=$_SESSION['userName'];
        $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.userName='$userName'");
        while($row=mysqli_fetch_array($query)){
            echo $row['firstName'] . '!';
        }
       }
       ?> </h2>

      <h3 style=font-size:30px>Instructor Dashboard</h3>

      <div class = "change-page">
      <form action="manageteams.php" method="get">
        <button class="button-3" role="button">Manage Teams</button>
      </form>
      </div>

      <div class = "change-page">
      <form action="teacherdetail.php" method="get">
        <button class="button-3" role="button">Detailed View</button>
      </form>
      </div>
      
      </div>

        <div id="table-container">
        <?php

        $teamQuery = mysqli_query($conn, "SELECT DISTINCT team FROM `users` WHERE `role` = 'student'");
        while ($teamRow = mysqli_fetch_array($teamQuery)) {
          $teamNumber = $teamRow['team'];

             echo "<table class='teamTable' id='team-$teamNumber'>
                    
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Cooperation Dimension</th>
                            <th>Conceptual Contribution</th>
                            <th>Practical Contribution</th>
                            <th>Work Ethic</th>
                            <th>Team</th>
                            <th>Average</th>
                            <th>Peers who responded</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            $teamUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `role` = 'student' AND `team` = '$teamNumber'");
            while($user = mysqli_fetch_array($teamUsersQuery)){
                echo "<tr>";
                echo "<td>" . $user['firstName'] . " " . $user['lastName'] . "</td>";
                echo "<td>" . $user['studentid'] . "</td>";
                echo "<td>" . $user['evalu'] . "</td>"; // Display Cooperation Dimension
                echo "<td>" . $user['evalu1'] . "</td>"; // Display Conceptual Contribution
                echo "<td>" . $user['evalu2'] . "</td>"; // Display Practical Contribution
                echo "<td>" . $user['evalu3'] . "</td>"; // Display Work Ethic
                echo "<td>" . $user["team"] . "</td>";
                echo "<td>" . $user['totalEvalu'] . "</td>";
                echo "<td>" . $user['numComment'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
        ?>
    
    </div>
    
    </div>

    <div class="logout">
      <form action="logout.php" method="get">
        <button class="button-3" role="button">Logout</button>
      </form>
    </div>

    <div class ="settings"> <!--this is added due to possibly being needed later and makes page look nicer? can remove easily-->
      <form action = # method ="get">
        <button class="button-3" role= "button" value = "Settings">Settings</button>
      </form>
    </div>


         <!-- CSV download button -->
         <div class="csv-download" style="text-align:center; margin-top: 20px;">
        <a href="export_csv.php" class="btn" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Download CSV</a>
    </div>
    

    <!-- CSV upload form -->
    <div class="csv-upload" style="text-align:center; margin-top: 20px;">
        <form action="upload_csv.php" method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <button type="submit" class="btn" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Upload CSV</button>
        </form>
    </div>
    

</body>
</html>