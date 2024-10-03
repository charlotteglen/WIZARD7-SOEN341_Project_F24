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
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $group=$_POST['group'];
  
    
    $sql="SELECT * FROM users WHERE fName='$firstName' and lName='$lastName'";
    
    $result=$conn->query($sql);
    if($result->num_rows>0){
        $insertQuery="INSERT INTO users(group)
                       VALUES ('$group')";
        echo "Success ! <br> <a href='teacherpage.php'>Return to the teacher</a></br>";
     }
     else{
        echo "Not Found, Ivalid information! <br> <a href='teacherpage.php'>Return to the teacher page </a></br>";
     }
 
 }

?>