
<!---->
<!--New User registration Page-->

<?php
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php';
include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cartbug.com User Registration</title>

    <!--Stylesheet used for registration css-->
    <link rel="stylesheet" href="../css/registration.css">

    <?php include_once BASEURL.'includes/js_css.php'?>
</head>

<body>
   <div class="header">
      <h2>Register</h2>
   </div>

   <form method="post" action="register.php">

       <!--display validation errors in this section-->
       <?php include('errors.php'); ?>

       <div class="input-group">
           <label>Username</label>
           <input type="text" name="username" value="<?php echo $username ?>">
       </div>

       <div class="input-group">
           <label>Email</label>
           <input type="text" name="email" value='<?php echo $email ?>'>
       </div>

       <div class="input-group">
           <label>Password</label>
           <input type="password" name="password_1" 
                  data-toggle="tooltip" data-placement="bottom" trigger="hover focus" title="Password must be Alphanumeric and atleast 6 characters">
       </div>

       <div class="input-group">
           <label>Confirm Password</label>
           <input type="password" name="password_2" 
           data-toggle="tooltip" data-placement="bottom" trigger="hover focus" title="Password must be Alphanumeric and atleast 6 characters"><br>
       </div>

       <div class="input-group">
          <button type="submit" name="register" class="btn">Register</button>
       </div>

       <p id="registerMsg">Already a member? <a href="login.php">Sing In!</a></p>

       <!--Website Logo: Link to get to Landing Page - START-->
       <a href="../landingPage.php" id="logoCSS">
          <img src="../images/CartBugLogo.png" alt="logo" width="27%">    Return Home..
       </a>
       <!--Website Logo: Link to get to Landing Page - END-->

   </form>


</body>

</html>