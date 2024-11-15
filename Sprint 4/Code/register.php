<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $userName=$_POST['userName'];
    $password=$_POST['password'];
    $studentid=$_POST['studentid'];
    $role=$_POST['roles'];
    $password=md5($password);

     $checkUser="SELECT * From users where userName='$userName'";
     $result=$conn->query($checkUser);
     if($result->num_rows>0){
        echo "Username Already Exists ! <br> <a href='index.php'>Return to the login page </a></br>";
     }
     else{
        $insertQuery="INSERT INTO users(firstName,lastName,userName,password, role, studentid)
                       VALUES ('$firstName','$lastName','$userName','$password','$role','$studentid')";
            if($conn->query($insertQuery)==TRUE){
                header("location: index.php");
            }
            else{
                echo "Error:".$conn->error;
            }
     }
   

}

if(isset($_POST['signIn'])){
   $userName=$_POST['userName'];
   $password=$_POST['password'];
   $password=md5($password) ;
 
   
   $sql="SELECT * FROM users WHERE userName='$userName' and password='$password'";
   $result=$conn->query($sql);
   if($result->num_rows>0){
    session_start();
    $row=$result->fetch_assoc();
    $_SESSION['userName']=$row['userName'];

    if($row['role'] == 'student'){
        header("Location: homepage.php");
    } elseif($row['role'] == 'teacher'){
        header("Location: homepage1.php");
    } 
    exit();
   }
   else{
    echo "Not Found, Incorrect Username or Password! <br> <a href='index.php'>Return to the login page </a></br>";
   }

}

if(isset($_POST['changeGroup'])){
    $studentid=$_POST['studentid'];
    $team=$_POST['team'];
  
    
  
 
 }

 if(isset($_POST['change'])){
    $studentid = $_POST['studentid'];
    $team = $_POST['team'];

    // Check if the student exists in the database
    $checkStudent = "SELECT * FROM users WHERE studentid = '$studentid'";
    $result = $conn->query($checkStudent);

    if($result->num_rows > 0){
        // Student exists, update their group
        $updateGroup = "UPDATE users SET `team` = '$team' WHERE studentid = '$studentid'";

        if($conn->query($updateGroup) === TRUE){
            echo "Group assigned successfully! <br> <a href='teacherpage.php'>Return to the teacher page! </a></br>";
        } else {
            echo "Error Unable to change student group! <br> <a href='teacherpage.php'>Return to the teacher page! </a></br>";
        }
    } else {
        echo "Student ID not found!<br> <a href='teacherpage.php'>Return to the teacher page! </a></br>";
    }
}

if (isset($_POST['evalu'])) {
    $studentid = $_POST['studentid'];
    $evalu = (int)$_POST['rating'];
    $comment = $_POST['comment'];
    $evalu1 = (int)$_POST['rating1'];
    $comment1 = $_POST['comment1'];
    $evalu2 = (int)$_POST['rating2'];
    $comment2 = $_POST['comment2'];
    $evalu3 = (int)$_POST['rating3'];
    $comment3 = $_POST['comment3'];

    // Calculate average of the current evaluation
    $avgAll = ($evalu + $evalu1 + $evalu2 + $evalu3) / 4;

    // Evaluator's name
    $evaluFname = $_POST['evaluFname'];
    $evaluLname = $_POST['evaluLname'];
    $evaluStu = "$evaluFname $evaluLname";

    // Comments structure
    $stuComment = "Student $evaluFname $evaluLname comment:<br>
    Cooperation: $comment<br>
    Conceptual: $comment1<br>
    Practical: $comment2<br>
    Work Ethic: $comment3";

    // Check if the student exists in the database
    $checkStudent = "SELECT * FROM users WHERE studentid = '$studentid'";
    $result = $conn->query($checkStudent);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Append new evaluations to existing ones
        $existingEvalu  = $user['evalu']  ? $user['evalu'] . "<br><br>" : "";
        $existingEvalu1 = $user['evalu1'] ? $user['evalu1'] . "<br><br>" : "";
        $existingEvalu2 = $user['evalu2'] ? $user['evalu2'] . "<br><br>" : "";
        $existingEvalu3 = $user['evalu3'] ? $user['evalu3'] . "<br><br>" : "";
        $existingstuComment = $user['stuComment'] ? $user['stuComment'] . "<br><br>" : "";
        $existingEvaluStu = $user['evaluStu'] ? $user['evaluStu'] . "<br><br>" : "";
        $existingAvgAll = $user['avgAll'] ? $user['avgAll'] . "<br><br>" : "";
        $currentNumComment = (int)$user['numComment'];

        // Function to calculate average
        function calculateAverage($evaluations) {
            $values = array_map('trim', explode('<br><br>', $evaluations));
            $sum = array_sum($values);
            return count($values) > 0 ? $sum / count($values) : 0;
        }

        // Calculate averages
        $avgEvalu  = calculateAverage($existingEvalu . $evalu);
        $avgEvalu1 = calculateAverage($existingEvalu1 . $evalu1);
        $avgEvalu2 = calculateAverage($existingEvalu2 . $evalu2);
        $avgEvalu3 = calculateAverage($existingEvalu3 . $evalu3);

        // Calculate total average
        $totalEvalu = ($avgEvalu + $avgEvalu1 + $avgEvalu2 + $avgEvalu3) / 4;

        // Update query to add evaluations and increment numComment
        $updateQuery = "UPDATE users SET 
            `evalu` = CONCAT('$existingEvalu', '$evalu'), 
            `evalu1` = CONCAT('$existingEvalu1', '$evalu1'), 
            `evalu2` = CONCAT('$existingEvalu2', '$evalu2'), 
            `evalu3` = CONCAT('$existingEvalu3', '$evalu3'),
            `stuComment` = CONCAT('$existingstuComment', '$stuComment'),
            `evaluStu` = CONCAT('$existingEvaluStu', '$evaluStu'),
            `avgAll` = CONCAT('$existingAvgAll', '$avgAll'),
            `avgEvalu` = '$avgEvalu',
            `avgEvalu1` = '$avgEvalu1',
            `avgEvalu2` = '$avgEvalu2',
            `avgEvalu3` = '$avgEvalu3',
            `totalEvalu` = '$totalEvalu',
            `numComment` = $currentNumComment + 1 
            WHERE studentid = '$studentid'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "Evaluation submitted successfully! <br> <a href='studentpage.php'>Return to the student page!</a>";
        } else {
            echo "Error: Unable to assign the evaluation! <br> <a href='studentpage.php'>Return to the student page!</a>";
        }
    } else {
        echo "Student ID not found!<br> <a href='studentevalu.php'>Return to the student's evaluation page!</a>";
    }
}

// Add a New Task
if (isset($_POST['addTask'])) {
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $addTaskQuery = "INSERT INTO tasks (description) VALUES ('$description')";
    mysqli_query($conn, $addTaskQuery);
    header("Location: teachertask.php");
    exit();
}

// Delete a Task
if (isset($_POST['deleteTask'])) {
    $taskId = $_POST['task_id'];
    $deleteTaskQuery = "DELETE FROM tasks WHERE id='$taskId'";
    mysqli_query($conn, $deleteTaskQuery);
    header("Location: teachertask.php");
    exit();
}

    // Handle task completion updates when form is submitted
    
    if (isset($_POST['submit_task'])) {
        
        
            echo "<p>Sucessfully updating tasks. Please try again.<a href='studenttask.php'>Return to the student task page!</a></p>";
    }
    

?>