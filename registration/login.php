
<!--User Login Page-->

<?php include('server.php');

//database connection file - initial file
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    require_once('../core/init.php');
?>



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
      <h2>Login</h2>
   </div>

   <form method="post" action="login.php">

      <!--display validation errors in this section-->
      <?php include('errors.php'); ?>

       <div class="input-group">
           <label>Username</label>
           <input type="text" name="username">
       </div>

       <div class="input-group">
           <label>Password</label>
           <input type="password" name="password">
       </div>

       <div class="input-group">
          <button type="submit" name="login" class="btn">Login</button>
       </div>

       <p id="registerMsg">Not a member yet? <a href="register.php">Sing Up!</a></p>

       <!--Website Logo: Link to get to Landing Page - START-->
       <a href="../landingPage.php" id="logoCSS">
          <img src="../images/CartBugLogo.png" alt="logo" width="27%">    Return Home..
       </a>
       <!--Website Logo: Link to get to Landing Page - END-->

   </form>

</body>

</html>