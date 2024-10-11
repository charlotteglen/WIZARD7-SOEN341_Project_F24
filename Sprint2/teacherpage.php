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
<body><!-- creating the teacher login page-->
    <div style="text-align:center; padding:15%;">
      <p  style="font-size:50px; font-weight:bold;">
       Welcome Teacher <?php 
       if(isset($_SESSION['userName'])){
        $userName=$_SESSION['userName'];
        $query=mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.userName='$userName'");
        while($row=mysqli_fetch_array($query)){
            echo $row['firstName'].' '.$row['lastName'];
        }
       }
       ?>
      !
      </p>
      <h2>User Information Table</h2>
        
        <table>
            <thead>
                <tr><!-- This code set up the header of the table -->
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Group</th>
                    <th>Cooperation Dimension</th>
                    <th>Practical Contribution</th>
                    <th>Work Ethic</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all users from the database and put them into the table
                $allUsersQuery = mysqli_query($conn, "SELECT * FROM `users`");
                
                while($user = mysqli_fetch_array($allUsersQuery)){
                    echo "<tr>";
                    echo "<td>" . $user['studentid'] . "</td>";
                    echo "<td>" . $user['firstName'] . "</td>";
                    echo "<td>" . $user['lastName'] . "</td>";
                    echo "<td>" . $user['role'] . "</td>";
                    echo "<td>" . $user['group'] . "</td>";
                    echo "<td>" . $user['evalu'] . "</td>";
                    echo "<td>" . $user['evalu1'] . "</td>";
                    echo "<td>" . $user['evalu2'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
      <a href="logout.php">Logout</a>
    </div>

    <div class="container" id="change">
        <h1 class="form-title">Assigning a student to a Group:</h1>
        <form method="post" action="register.php">
        <div class="input-group">
        <label for="studentid">Enter the Student ID:</label>
            <i class="fas fa-user"></i>
            <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
            
        </div>
          <div class="input-group">
            <label for="userName">Enter the Student's group:</label>
              <i class="fas fa-user"></i>
              <input type="text" name="group" id="group" placeholder="User Group" required>
          </div>
          <input type="submit" class="btn" value="Change" name="change">
        </form>
       
      </div>



</body>
</html>