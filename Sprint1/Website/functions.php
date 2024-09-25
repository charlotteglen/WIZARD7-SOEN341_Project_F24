<?php

    //TO CHECK IF USER IS LOGGED IN
    function check_login($con){
        //Is there a user id set in the session
        if(isset ($_SESSION['user_id'])){

            //Is it legit? Is it in our database
            $id = $_SESSION['user_id'];

            //We ask the database
            $query = "select * from users where user_id= '$id' limit 1";

            //We need to read from the database
            $result = mysqli_query($con,$query);

            //Is the result positive?Yes?
            if($result && mysqli_num_rows($result) > 0){

                //Put the result we got in user data
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }
        //redirect to login
        header("Location: login.php");
        die;

    }


    //GENERATE RANDOM NUMBER
    function random_num($length){
        $text = "";

        //To make sure length is never less than 5 
        if($length < 5){
            $length= 5;
        }

        //generate number between 4 and the length
        $len = rand(4,$length);

        for($i=0; $i< $len; $i++){
            
            $text .= rand(0,9);
        }
        return $text;
    }
?>