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
        header("Location: studentpage.php");
    } elseif($row['role'] == 'teacher'){
        header("Location: teacherpage.php");
    } 
    exit();
   }
   else{
    echo "Not Found, Incorrect Username or Password! <br> <a href='index.php'>Return to the login page </a></br>";
   }

}

if(isset($_POST['changeGroup'])){
    $studentid=$_POST['studentid'];
    $group=$_POST['group'];
  
    
  
 
 }

 if(isset($_POST['change'])){
    $studentid = $_POST['studentid'];
    $group = $_POST['group'];

    // Check if the student exists in the database
    $checkStudent = "SELECT * FROM users WHERE studentid = '$studentid'";
    $result = $conn->query($checkStudent);

    if($result->num_rows > 0){
        // Student exists, update their group
        $updateGroup = "UPDATE users SET `group` = '$group' WHERE studentid = '$studentid'";

        if($conn->query($updateGroup) === TRUE){
            echo "Group assigned successfully! <br> <a href='teacherpage.php'>Return to the teacher page! </a></br>";
        } else {
            echo "Error Unable to change student group! <br> <a href='teacherpage.php'>Return to the teacher page! </a></br>";
        }
    } else {
        echo "Student ID not found!<br> <a href='teacherpage.php'>Return to the teacher page! </a></br>";
    }
}

if(isset($_POST['evalu'])){
    $studentid = $_POST['studentid'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $rating1 = $_POST['rating1'];
    $comment1 = $_POST['comment1'];
    $rating2 = $_POST['rating2'];
    $comment2 = $_POST['comment2'];

    // Combine rating and comment into one evaluation string
    $evalu = "Rating: " . $rating . "<br> Comment: " . $comment;
    $evalu1 = "Rating: " . $rating1 . "<br> Comment: " . $comment1;
    $evalu2 = "Rating: " . $rating2 . "<br> Comment: " . $comment2;

    // Check if the student exists in the database
    $checkStudent = "SELECT * FROM users WHERE studentid = '$studentid'";
    $result = $conn->query($checkStudent);

    if($result->num_rows > 0){
        // Student exists, update all evaluations at once
        $updateQuery = "UPDATE users SET 
            `evalu` = '$evalu', 
            `evalu1` = '$evalu1', 
            `evalu2` = '$evalu2' 
            WHERE studentid = '$studentid'";

        if($conn->query($updateQuery) === TRUE){
            echo "Evaluation submitted successfully! <br> <a href='studentpage.php'>Return to the student page!</a>";
        } else {
            echo "Error: Unable to assign the evaluation! <br> <a href='studentpage.php'>Return to the student page!</a>";
        }
    } else {
        echo "Student ID not found!<br> <a href='studentpage.php'>Return to the student page!</a>";
    }
}



?>