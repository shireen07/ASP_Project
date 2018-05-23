
<!--Common product page header -->

<!--Login needed if user wants to access this page-->

<?php
include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php';
require_once('../core/init.php');

include('../registration/server.php');
//if the user is empty they cannot access this page
//START
if(empty($_SESSION['username'])){
  header('location: ../registration/login.php');
}
//END
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cartbug.com</title>

    <link rel="stylesheet" href="<?php echo SITE_URL;?>/css/productCSS.css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>/css/pageCSS.css">

    <?php include_once BASEURL.'includes/js_css.php'?> 

</head>

<body>

