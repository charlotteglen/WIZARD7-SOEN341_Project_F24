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
      <form action="teacherpage.php" method="get">
        <button class="button-3" role="button">View Teams</button>
      </form>
      </div>
      </div>

      <!--content wrapper to display team assignment and table side by side-->
      <div class ="content-wrapper">

      <div class="infotable" id="infoTable">
      <h2 style = padding:12px;text-align:center>Student Information</h2>

        <table id ="students">
            <thead>
                <tr>
                    <th>Team</th>
                    <th>Name</th>
                    <th>Student ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $allUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `role` = 'student'");
                
                while($user = mysqli_fetch_array($allUsersQuery)){
                    echo "<tr>";
                    echo "<td>" . $user['team'] . "</td>";
                    echo "<td>" . $user['firstName'] . " " . $user['lastName'] . '</td>';
                    echo "<td>" . $user['studentid'] . '</td>';
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

        <form method= "post" action = "register.php">
          <button>Assign Student</button>
        </form>

        </form>

      </div>

      <div class="assign-method">
        <p style= font-weight:bold>Upload class CSV file</p>
        <form action="#">
          <input type="file" id="myFile" name="filename">
          <input type="submit">
        </form>
      </div>

      </div>

    </div>

    <div class="logout">
      <form action="logout.php" method="get">
        <button class="button-3" role="button">Logout</button>
      </form>
    </div>

      <div class ="settings">
        <form action = # method ="get">
          <button class="button-3" role= "button" value = "Settings">Settings</button>
        </form>
      </div>

</body>