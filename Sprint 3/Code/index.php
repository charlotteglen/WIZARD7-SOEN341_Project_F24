<!-- login page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
     <!-- link reference for icons -->
    <link rel="stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
     <!-- link reference for css -->
      <link rel="stylesheet" href = "style.css">
     <!-- font -->
     <link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    </head>

<body>
<!-- wrapper div-->
 <div class = "wrapper" >
    <!-- Title: Peer Assessment -->
    <div class = "bg-img"></div>
    <div class = "bg"></div>
    <div class = "title" id = "title">
        <h1 class = "h1"> Peer Assessment </h1>
        <h2 class = "h2"> sign or create an account </h2>

        <!-- sign up and register buttons-->
        <div class="links">
            <button class = "button" id="signInButton">Sign In</button>
            <button class = "button" id="signUpButton">Sign Up</button>
        </div>
   </div>

    <!-- Sign Up -->
    <div class="container container-SignUp" id="signup" style="display:none;">
      <h1 class="form-title">Sign Up</h1>
      <form method="post" action="register.php">

        <!-- student or teacher -->
        <div class="role">
            <p>Are you a student or teacher?</p>
            
                <select name="roles" id="roles">
                <option value="student">Student</option>
                <option value="teacher">Teacher</option></select>
        </div>

        <!-- sign up user inputs -->
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">First Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Last Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="userName" id="userName" placeholder="User Name" required>
            <label for="userName">User Name</label>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="studentid" id="studentid" placeholder="Student Id" required>
            <label for="studentid">Enter Student ID</label>
        </div>
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>

       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
    </div>

    <!-- Sign in -->
    <div class = "container container-SignIn" id="signIn">
        <h1 class = "welcome"> Welcome Back </h1>
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="register.php">

          <!-- sign in user inputs -->
          <div class="input-group">
              <i class="fas fa-user"></i>
              <input type="text" name="userName" id="userName" placeholder="User Name" required>
              <label for="userName">User Name</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
      </div>

 </div> <!-- closes wrapper div -->

    <!-- reference js -->
    <script src="script.js"></script>

</body>
</html>
