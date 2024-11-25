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
        <link rel = "stylesheet" href = "teamstyle.css">
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

        .border
        {
            border-radius: 10px;
            margin-left: 5%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            width: 90%;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        h2
        {
            padding-bottom: 20px;
            text-align: center;
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
    <div style="text-align:center; padding:5%;">
      <p style="font-size:50px; font-weight:bold; padding-bottom:5%; ">
       Welcome student
       <?php
       if(isset($_SESSION['userName'])){
            $userName = $_SESSION['userName'];
            $query = mysqli_query($conn, "SELECT users.* FROM users WHERE users.userName='$userName'");
            $row = mysqli_fetch_array($query);
            echo $row['firstName'] . ' ' . $row['lastName']."! <br>";
            echo "ID: " . $row['studentid'];
            $studentGroup = $row['team'];
       }
       ?>
      </p>


<?php
    // fetch all users from the same group except the current user
    $allUsersQuery = mysqli_query($conn, "SELECT * FROM `users` WHERE `team` = '$studentGroup' AND `userName` != '$userName'");
?>

<!--------------------- team cards ---------------------------> 
<!-- diplay team number --> 
<div class = "group"> 
     <h2> Group <?php echo $studentGroup; ?> </h2>
<div class = "team-card">
<?php
// card for each team member
while ($user = mysqli_fetch_array($allUsersQuery)) 
{
    $class_name = "card";
    echo '<div class = "'. $class_name .'">';
    echo '<img src = "https://icones.pro/wp-content/uploads/2022/07/icones-d-administration-vert.png" alt = "user" width = "100%" >';

    $class_name = "container";
    echo '<div class = "'. $class_name .'">';

    echo "<h4> <b>" . $user['firstName'] . " " . $user['lastName'] . "</b> </h4>";
    echo "<p>" . $user['studentid'] . "</p>";
    echo "<p>" . $user['role'] . "</p>";

    echo '</div>'; //closes div container
    echo '</div>'; //closes div card
}
?>

</div> <!-- closes div team card -->
</div> <!-- closes div group -->

<!------------------- user info --------------------------->
<?php
// div class border
$class_name = "border";
echo '<div class = "'. $class_name .'">';

// Check if the student is assigned to a group
if (empty($studentGroup)) {
    echo "<h2>You are not yet assigned to a group.</h2>";
} else {
    // Increment the numView counter for the current student
    if (isset($_SESSION['userName'])) {
        $userName = $_SESSION['userName'];
        // Fetch the current numView value
        $viewQuery = mysqli_query($conn, "SELECT numView FROM `users` WHERE `userName` = '$userName'");
        $viewRow = mysqli_fetch_array($viewQuery);
        $currentNumView = $viewRow['numView'];

        // Increment the value by 1
        $newNumView = $currentNumView + 1;

        // Update the numView column in the database
        mysqli_query($conn, "UPDATE `users` SET `numView` = $newNumView WHERE `userName` = '$userName'");
    }

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
    echo "<th>Cooperation Dimension</th>";
    echo "<th>Conceptual Contribution</th>";
    echo "<th>Practical Contribution</th>";
    echo "<th>Work Ethic</th>";
    echo "<th>Student Responded</th>";
    echo "<th>Peers who responded</th>";
    echo "<th>Average Across All</th>";
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
        echo "<td>" . $user['evalu'] . "</td>";
        echo "<td>" . $user['evalu1'] . "</td>";
        echo "<td>" . $user['evalu2'] . "</td>";
        echo "<td>" . $user['evalu3'] . "</td>";
        echo "<td>" . $user['evaluStu'] . "</td>";
        echo "<td>" . $user['numComment'] . "</td>";
        echo "<td>" . $user['avgAll'] . "</td>";
        echo "</tr>";

        // Display comments for this specific user
        $comments = explode('<br><br>', $user['stuComment']);
        echo "<tr><td colspan='12' class='comments'>"; // Span all columns to display the comments for the corresponding student
        echo "<strong>Comments:</strong><br>";
        foreach ($comments as $comment) {
            if (!empty($comment)) {
                echo "<p>$comment</p>";
            } else {
                echo "<p>No comment </p>";
            }
        }
        echo "</td></tr>"; // Close the comments row
    }

    echo "</tbody>";
    echo "</table>"; // Close the table
}
echo '</div>'; //closes div border

?>

   
   <?php
       if(isset($_SESSION['userName'])){
            $userName = $_SESSION['userName'];
            $query = mysqli_query($conn, "SELECT users.* FROM users WHERE users.userName='$userName'");// getting the information from the database
            $row = mysqli_fetch_array($query);
            echo "<br> Number of student evaluated for ";
            echo $row['firstName'] . ' ' . $row['lastName']. ": ";
            echo  $row['numComment']. "<br>";
            echo "<br> Number of student viewed this page: ";
            
            echo  $row['numView']. "<br>";
        
       }
       ?>
      </p>

    </>

    
   

</body>
</html>
