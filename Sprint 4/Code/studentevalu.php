<?php
session_start();
include("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student evaluation</title>
    <!-- icons -->
    <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- font -->
    <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'></title>
    <!-- link reference for css -->
    <link rel="stylesheet" href = "homepage.css">
    <link rel="stylesheet" href = "studentevalu.css">
</head>
<body>
     <!-- header -->
    <div class = "bg-img"></div>
    <div class = "bg"></div>
    <div class = "header">
        <a href = "homepage.php">
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
    <div style="text-align:center; padding:15%; padding-bottom: 5%">
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
    </div>

    <?php if(!empty($studentGroup)) { ?>

<!------------------------------ Evaluation section ----------------------------------->
<div class="peer-evaluation" id="evaluation">
    <h1 class="form-title">Student Evaluation Section:</h1>
    <form method="post" action="register.php">

    <!-- Hidden fields for evaluator's first and last name -->
    <input type="hidden" name="evaluFname" value="<?php echo $row['firstName']; ?>">
    <input type="hidden" name="evaluLname" value="<?php echo $row['lastName']; ?>">

    <!--Function Filtering by the student ID-->
    <div class="input-group">
        <label for="studentid">Enter your teammate's ID:</label>
        <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
    </div>

    <!-- Cooperation dimension evaluation input-->
    <div class="evaluation-section" id="cooperation-section">
        <p>Choose a rating for Cooperation dimension:</p>
        <br>
        <p>This assessment dimension comprises actively participating in meetings; Communicating within the group;
            <br> Cooperating within the group; Assisting team-mates when needed; Volunteering for tasks.
        </p>
        <br>
        <div class="card">
            <input
                class="rating rating--nojs"
                max="5"
                step="1"
                type="range"
                value="0"
                name="cooperation">
        </div>
        <br>
        <label for="comment">Enter the Cooperation Dimension evaluation:</label>
        <br>
        <textarea name="comment" id="comment" rows="4" placeholder="Write your comment here..."></textarea>
    </div>

    <!-- Conceptual Contribution evaluation input-->
    <div class="evaluation-section" id="contribution-section">
        <p>Choose a rating for Conceptual Contribution:</p>
        <br>
        <p> This assessment dimension comprises Researching and gathering information; Quality of individual contribution; 
            <br>Suggesting ideas; Tying ideas together; Identifying difficulties; Identifying effective approaches.
        </p>
        <br>
        <div class="card">
            <input
                class="rating rating--nojs"
                max="5"
                step="1"
                type="range"
                value="0"
                name="contribution">
        </div>
        <br>
        <label for="comment1">Enter the Conceptual Contribution evaluation:</label>
        <br>
        <textarea name="comment1" id="comment1" rows="4" placeholder="Write your comment here..."></textarea>
    </div>

    <!-- Practical Contribution evaluation input-->
    <div class="evaluation-section" id="practical-section">
        <p>Choose a rating for Practical Contribution:</p>
        <br>
        <p>
            This assessment dimension comprises Writing of the report(s); Reviewing others’ report(s) or section(s);
            <br> Providing constructive feedback on the report(s) or the presentation; Contributing to the organization of the work; 
            <br>Contributing to the preparation of presentation(s) (if appropriate).
        </p>
        <br>
        <div class="card">
            <input
                class="rating rating--nojs"
                max="5"
                step="1"
                type="range"
                value="0"
                name="practical">
        </div>
        <br>
        <label for="comment2">Enter the Practical Contribution evaluation:</label>
        <br>
        <textarea name="comment2" id="comment2" rows="4" placeholder="Write your comment here..."></textarea>
    </div>

    <!-- Work Ethic evaluation input-->
    <div class="evaluation-section" id="workethic-section">
        <p>Choose a rating for Work Ethic:</p>
        <br>
        <p>
            This assessment dimension comprises Displaying a positive attitude; Respecting team-mates; 
            <br>Respecting commitments; Respecting deadlines; Respecting team-mates’ ideas.
        </p>
        <br>
        <div class="card">
            <input
                class="rating rating--nojs"
                max="5"
                step="1"
                type="range"
                value="0"
                name="workethic">
        </div>
        <br>
        <label for="comment3">Enter the Work Ethic evaluation:</label>
        <br>
        <textarea name="comment3" id="comment3" rows="4" placeholder="Write your comment here..."></textarea>
    </div>
    <input type="submit" class="btn" value="Submit Evaluation" name="evalu" onclick="alert('Form is being submitted!');">
    </form>
</div>
<?php } // End if for evaluation section ?>
    
</body>
</html>
