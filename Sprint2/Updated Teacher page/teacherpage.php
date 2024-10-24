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
    <!--font-->
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

      <div class = "changepage">
      <form action="manageteams.php" method="get">
        <button class="button-3" role="button">Manage Teams</button>
      </form>
      </div>
      
      </div>

        <div class = "teamtable" id="teamTable">
        <?php

        $teamQuery = mysqli_query($conn, "SELECT DISTINCT team FROM `users` WHERE `role` = 'student'");
        while ($teamRow = mysqli_fetch_array($teamQuery)) {
          $teamNumber = $teamRow['team'];

          echo "<h3>Team $teamNumber</h3>";

            echo "<table id='team-$teamNumber' ;'>
                    
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            $teamUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `role` = 'student' AND `team` = '$teamNumber'");
            while($user = mysqli_fetch_array($teamUsersQuery)){
                echo "<tr>";
                echo "<td>" . $user['firstName'] . " " . $user['lastName'] . "</td>";
                echo "<td>" . $user['studentid'] . "</td>";
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


</body>
</html>