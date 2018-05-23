
<!--BSIC PRODUCT PAGE - SEPERATE ELEMENTS LIKE HEADER, FOOTER, BODY ETC ARE INCLUDED FROM DIFFERENT FILES-->

<?php
//database connection file - initial file
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
require_once('../core/init.php');
include('../registration/server.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
include('includes/head.php');

//populate dropdown from database table
include('includes/navigation.php');

//include('../includes/headerFull.php'); //includes the img after the nav bar. we intend to change images per page
?>

<?php
    //grab password
    $errors = array();
    // $hashed = $user_data['password'];
    $old_password = ((isset($_POST['old_password']))? sanitize($_POST['old_password']) : '');
    $old_password = trim($old_password);
    $password = ((isset($_POST['password']))? sanitize($_POST['password']) : '');
    $password = trim($password);
    $confirm = ((isset($_POST['confirm']))? sanitize($_POST['confirm']) : '');
    $confirm = trim($confirm);
    $new_hashed = md5($password);
    $username = $_SESSION['username']; 

    if($_POST){
        if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
            array_push($errors, "All fields must be filled!");
        }//end if for empty

        //comparing password and ConfirmPassowrd
        if($password != $confirm) {
            array_push($errors, "New Passwords do <strong>NOT</strong> match!"); //error message added to errors array.
        }//end if

        //CHECK IF PASSWORD IS MORE THAN 6 CHARACTERS
        if(strlen($password) < 6 || strlen($confirm) < 6){
            array_push($errors, "Password MUST be more than 6 characters!");
        }//end if - password charact chck
        
        //CHECK IF PASSWORD IS ALPHANUMERIC
        if(!preg_match( '/[^A-Za-z0-9]+/', $password) || !preg_match( '/[^A-Za-z0-9]+/', $confirm)){
            array_push($errors, "Password MUST be Alphanumeric!");
        }//end if - chck for password to be alphanumeric
        
        //check for errors empty and change password
        if(empty($errors)){
            $db -> query("UPDATE users SET password = '$new_hashed' WHERE username = '$username' ");
            echo '<script>window.location.href = "index.php";</script>';
            $_SESSION['success'] = "Hello <strong>$username</strong>! Your password has been Updated!";
        }//end if            

    }//end main if
?>


<!--************************************** PHP CODE - START ****************************************************************-->
<div class="header">
      <h2>Change Password</h2>
   </div>
   <form method="post" action="changePassword_admin.php" class="form-content">

        <!--display validation errors in this section-->
        <?php include('../registration/errors.php'); ?>

        <div class="input-group">
            <label>Old Password</label>
            <input type="password" name="old_password" id="old_password" value='<?php echo $old_password; ?>'>
        </div>

        <div class="input-group">
            <label>New Password</label>
            <input type="password" name="password" id="password" value=""
                data-toggle="tooltip" data-placement="bottom" trigger="hover focus" title="Password must be Alphanumeric and atleast 6 characters">
        </div>

        <div class="input-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm" id="confirm" value="<?=$confirm;?>"
            data-toggle="tooltip" data-placement="bottom" trigger="hover focus" title="Password must be Alphanumeric and atleast 6 characters"><br>
        </div>
        

        <div class="input-group">
           <button type="submit" name="changePassword" class="btn btnchange">Change Password</button>
           <a href="homePage.php" class="btn btnchange btn-danger">Cancel</a>
        </div>
</form>
<!--************************************** PHP CODE - END ****************************************************************-->


<?php
//php file that contains the page footer
include('includes/footer.php'); //includes the left side bar filters

?>
