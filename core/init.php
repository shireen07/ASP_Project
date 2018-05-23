
<?php
//<!--Connecting to the database | include this page in any file we may need to access database -->
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database

 $edb = mysqli_connect('localhost', 'root', '', 'cartbugs_shoppe');  //localhost - 127.0.0.1
 $db = mysqli_connect('localhost', 'root', '', 'user_registration');

 //make the database globl
 $GLOBALS['edb'] = $edb;

 //fail-safe: if there are issues loading the db we want to kill the application
if (mysqli_connect_errno()) {
    //function to check if there is a conn error returned true ergo execute the code
    echo 'Database Connection FAILED: Errors occured are= ' . mysqli_connect_error();
    //die kills the page
    die();
}//end if


//creating a constant
//define('BASEURL', '/ASP_Project/' ); //name of the const and its localhost path

//including a helpers file so we can create and use functions that we often use. BASEURL is defined in config.php
require_once $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/config.php';
require_once BASEURL.'helpers/helpers.php'; 
require BASEURL.'vendor/autoload.php'; //AUTOLOADS CLASSES WE ARE USING FOR STRIPE FOR CHECOUT


//create a cart_id if it exists
$cart_id = '';
if(isset($_COOKIE[CART_COOKIE])){
    /*IF COOKIE IS SET THEN SET CART ID THEN IT CHECKS IF COOKIE EXIST AND SET TO CART ID coz all we store in the 
    cookie is cart_id which is corresponding to id in cart table in $edb database */
    $cart_id = sanitize($_COOKIE[CART_COOKIE]); //we dont want ppl to mess with our cookies
}//end if