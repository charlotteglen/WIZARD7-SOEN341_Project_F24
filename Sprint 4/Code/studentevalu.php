<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
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

      <?php
      // Check if the student is assigned to a group
      if(empty($studentGroup)) {
          echo "<h2>You are not yet assigned to a group.</h2>";
      } else {
          echo "<h2>User Information Table (Group $studentGroup)</h2>";
          
          // Fetch all users from the same group except the current user
          $allUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `team` = '$studentGroup' AND `userName` != '$userName'");
          
          echo "<table>"; // Open the table
          echo "<thead>";
          echo "<tr>";
          echo "<th>Student ID</th>";
          echo "<th>First Name</th>";
          echo "<th>Last Name</th>";
          echo "<th>Role</th>";
          echo "<th>Group</th>";
          echo "</tr>";
          echo "</thead>";
          echo "<tbody>";

          while ($user = mysqli_fetch_array($allUsersQuery)) {
              echo "<tr>";
              echo "<td>" . $user['studentid'] . "</td>";
              echo "<td>" . $user['firstName'] . "</td>";
              echo "<td>" . $user['lastName'] . "</td>";
              echo "<td>" . $user['role'] . "</td>";
              echo "<td>" . $user['team'] . "</td>";
              echo "</tr>";

              // Display comments for this specific user
              
          }

          echo "</tbody>";
          echo "</table>"; // Close the table
      } // End of else
      ?>
    </div>

    <?php if(!empty($studentGroup)) { ?>
    <div class="container" id="evaluation">
        <h1 class="form-title">Student Evaluation Section:</h1>
        <form method="post" action="register.php">

        <!-- Hidden fields for evaluator's first and last name -->
        <input type="hidden" name="evaluFname" value="<?php echo $row['firstName']; ?>">
        <input type="hidden" name="evaluLname" value="<?php echo $row['lastName']; ?>">

        <!--Function Filtering by the student ID-->
        <div class="input-group">
            <label for="studentid">Enter the Student ID:</label>
            <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
        </div>

        <!-- Cooperation dimension evaluation input-->
        <div class="input-group">
            <p>Choose a rating for Cooperation dimension:</p>
            <select name="rating" id="rating">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <label for="comment">Enter the Cooperation Dimension evaluation:</label>
            <br>
            <textarea name="comment" id="comment" rows="4" placeholder="Write your comment here..."></textarea>
        </div>

        <!-- Conceptual Contribution evaluation input-->
        <div class="input-group">
            <p>Choose a rating for Conceptual Contribution:</p>
            <select name="rating1" id="rating1">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <label for="comment1">Enter the Conceptual Contribution evaluation:</label>
            <br>
            <textarea name="comment1" id="comment1" rows="4" placeholder="Write your comment here..."></textarea>
        </div>

        <!-- Practical Contribution evaluation input-->
        <div class="input-group">
            <p>Choose a rating for Practical Contribution:</p>
            <select name="rating2" id="rating2">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <label for="comment2">Enter the Practical Contribution evaluation:</label>
            <br>
            <textarea name="comment2" id="comment2" rows="4" placeholder="Write your comment here..."></textarea>
        </div>

        <!-- Work Ethic evaluation input-->
        <div class="input-group">
            <p>Choose a rating for Work Ethic:</p>
            <select name="rating3" id="rating3">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <label for="comment3">Enter the Work Ethic evaluation:</label>
            <br>
            <textarea name="comment3" id="comment3" rows="4" placeholder="Write your comment here..."></textarea>
        </div>
        <input type="submit" class="btn" value="Submit Evaluation" name="evalu">
        </form>
    </div>
    <?php } // End if for evaluation section ?>
   
</body>
</html>
