<?php
session_start();
include("connect.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="teacher_style.css">
</head>
<body>

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
       ?>
      </h2>
      <h3 style=font-size:30px>Instructor Dashboard</h3>
      </div>

      <div class ="content-wrapper">
      <div class="infotable">
      <h2 style = padding:12px;text-align:center>Student Information</h2>
    
        <table id ="students">
            <thead>
                <tr><!-- This code set up the header of the table -->
                    <th>Team</th>
                    <th>Name</th>
                    <th>Student ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all users from the database and put them into the table
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
        <p>
          choose specific team to view</br>
          instructor could select button so that there are a number of tables, each table solely dedicated to a specific team</br>
          select that individual table in order to see the current information on the teams peer assessments</br>
          must be done after the team # info has been updated in database </br>
        </p>
    </div> <!--closing div for infotable-->

    <div class="team-creation">
        <h2 class="form-title">Create Teams</h2>

        <div class="assign-method">
        <form method="post" action="register.php">
        <p>Assign Manually:</p>

        <div class="input-group">
            <label for="fname">Enter Student's ID:</label> bn
           <i class="fas fa-user"></i>
           <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
        </div> <!--closing div for input group-->

          <div class="input-group">
            <label for="userName">Enter the Student's Team Number:</label>
              <i class="fas fa-user"></i>
              <input type="number" step="1" name="team" id="team" placeholder="User Team" required min="1">
          </div><!--closing div for input group-->

        <div class = "links">
		    <input type="submit" value="Assign Student">
        </div><!--closing div for submit-->
        <!-- this should send the info the register page. 
        also, there is a way to make this automatically update which is what i want-->

        </form>

      </div> <!--closing div for assign-method-->

      <div class="assign-method">
        <p>Upload class CSV file:</p>
        <p>Under Construction</p>
        <div class = "links">
            <input type="submit" value ="Upload course roster">
        </div><!--closing div for links-->
      </div><!--closing div for assign-method-->

      </div><!--closing div for team creation-->

    </div> <!--closing div for content wrapper-->

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

      <!-- HTML !-->
       <div id="button test">
<button class="button-3" role="button">Button 3</button>
</div>


</body>
</html>
