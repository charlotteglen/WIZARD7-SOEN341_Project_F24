<?php
session_start();

    //include required files
    include("connection.php");
    include("functions.php");

    //Has user clicked on post? 
    if($_SERVER['REQUEST_METHOD']== "POST"){

        //something was posted
        //we want to collect the data from the post variable
        $username = $_POST['username'];
        $password= $_POST['password'];

        //check if both aren't empty
        if(!empty($username) && !empty($password) && !is_numeric($username)){
            
            //Save to database
            $user_id = random_num(20);//Is generated randomly
            $query = "insert into users (user_id,username,password) values ('$user_id','$username','$password')";

            //save
            mysqli_query($con, $query);

            //Redirect the user to login page when they are done signing up
            header("Location: login.php");
            die;

        }else{
            echo "Please enter some valid information!";
        }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <style type="text/css">
        #text{
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            width: 100%;

        }

        #button{
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
        }

        #box{
            background-color: grey;
            margin: auto;
            width: 300px;
            padding: 20px;
        }
    </style>

    <div id="box">
        <form method="post">
            <div style="font-size: 20px; maargin: 10px; color: white; ">Sign Up</div>
            <input id="text" type="text" name="username"> 
            <br><br>
            <input id="text" type="password" name="password"> 
            <br><br>

            <input id="button" type="submit" value="Sign up"> 
            <br><br>
            <a href="login.php">Click to Login</a>
            <br><br>

        </form>

    </div>
</body>
</html>