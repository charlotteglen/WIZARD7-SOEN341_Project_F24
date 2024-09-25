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
        
        //read from the database
        //check is username is in the database
        $query = "select * from users where username= '$username' limit 1";

        //read from the query
        $result = mysqli_query($con, $query);

        //check if everything is fine(password)
        if($result){
            if($result && mysqli_num_rows($result) > 0){

                //Put the result we got in user data
                $user_data = mysqli_fetch_assoc($result);
                
                //check if password in user data is the same as the password we entered
                if($user_data['password']=== $password){
                    
                     //Assign SESSION so they can stay in index page
                     $_SESSION['user_id']=$user_data['user_id'];

                     //Redirect the user to index page when they are done logging in
                     header("Location: index.php");
                     die;
                }
            }
        }
        echo "Wrong Username or Password!";

    }else{
        echo "Wrong Username or Password!";
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <div style="font-size: 20px; maargin: 10px; color: white; ">Login</div>
            <input id="text" type="text" name="username"> 
            <br><br>
            <input id="text" type="password" name="password"> 
            <br><br>

            <input id="button" type="submit" value="Login"> 
            <br><br>
            <a href="signup.php">Click to Sign Up</a>
            <br><br>

        </form>

    </div>
</body>
</html>