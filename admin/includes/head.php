
<!--Common product page header -->

<!--Login needed if user wants to access this page-->
<!--Admin head-->

<?php 
//include('/../../registration/server.php');
include $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/registration/server.php';
//if the user is empty they cannot access this page
//START
if(empty($_SESSION['username'])){
  header('location: /ASP_Project/registration/login.php');
}
//END

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Administrator</title>

    <link rel="stylesheet" href="../css/AdminProductCSS.css">
    <link rel="stylesheet" href="../css/AdminPageCSS.css">

    <!--Bootstrap CDN- for CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>   
    <!--FontAwesome for Icons-->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Snowburst+One' rel='stylesheet' type='text/css'>

   <!--JQ and AJAX -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">

</head>

<body>
<div class="parallax" id="parallaxImg"></div>
<div class="container-fluid" id="dressContainer">