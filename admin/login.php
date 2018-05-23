

<?php  
    //user-registration db file
    include('../registration/server.php'); 

    //database connection file - initial file
    //we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
    require_once('../core/init.php');

    //Include files that have seperate elements of the page like header, navbar, main content, footer etc
    include('includes/head.php');

    //populate dropdown from database table
    include('includes/navigation.php');

    //include('includes/leftbar.php'); //includes the left side bar filters

    //if the user is empty they cannot access this page
    //START
    if(empty($_SESSION['username'])){
    header('location: ../registration/login.php');
    }
//END
?>
<!--************************************************************************************************************-->



<!--************************************************************************************************************-->
<?php

    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters

?>
