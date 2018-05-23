

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

<?php  
     //empty array for mesage display
     $errorsEDB = array();
     $successEDB = array();

    //DELETE USER by Admin
    if(isset($_GET['delete'])){
        $username = $_SESSION['username'];
        $delete_id = sanitize($_GET['delete']);
        $db -> query("DELETE FROM users WHERE id = '$delete_id' ");
        $successEDB[] = "User Deleted Successfully!";
        echo display_success($successEDB);
        //redirecting to users page after 3 sec delay after showing success message
        echo '<script> setTimeout(function(){window.location="users.php"}, 3000); </script>';
    }//end if - delete btn


    //Add new User by Admin
    if(isset($_GET['add'])){
        //if add new user btn clicken then show the form else show the user table
        //first thing get out of php and create a new add user form and then jump into php back
        //set variables used in add form
        $username = ((isset($_POST['username']))? sanitize($_POST['username']) : '');
        $email = ((isset($_POST['email']))? sanitize($_POST['email']) : '');
        $password = ((isset($_POST['password']))? sanitize($_POST['password']) : '');
        $confirm = ((isset($_POST['confirm']))? sanitize($_POST['confirm']) : '');
        $permissions = ((isset($_POST['permissions']))? sanitize($_POST['permissions']) : '');


        //validate add user form
        if($_POST){

            //check to see that email does not already exist in the database
            $emailQuery = $db -> query("SELECT * FROM users WHERE email = '$email' ");
            $emailCount = mysqli_num_rows($emailQuery);
            //if $emailCount is 1 then display error saying that email already exixts in the database else email is valid and can be used to add new user
            if($emailCount != 0){
                $errorsEDB[] = 'This Email already Exists in our Database! Please use a different Email to create a new User!';
            }//end if - email exists or not


            $required = array('username', 'email', 'password', 'confirm', 'permissions'); //ceated an array to check if all these fields are filled and validated
            //check if all fields are filled
            foreach($required as $f){
                if(empty($_POST[$f])){
                    $errorsEDB[] = 'You Must Fill out ALL fields!';
                    break; 
                }//end if- fields empty
            }//end foreach

            //validate email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errorsEDB[] = 'You Must enter a VALID Email!';
            }//end if - validate email


            //check if password is more than 6 charact and aplhanumeric
            //CHECK IF PASSWORD IS MORE THAN 6 CHARACTERS
            if(strlen($password) < 6 || strlen($confirm) < 6){
                $errorsEDB[] = 'Password MUST be atleast 6 characters!!';
            }//end if - password charact chck
            
            //CHECK IF PASSWORD IS ALPHANUMERIC
            if(!preg_match( '/[^A-Za-z0-9]+/', $password) || !preg_match( '/[^A-Za-z0-9]+/', $confirm)){
                $errorsEDB[] = 'Password MUST be Alphanumeric!';
            }//end if - chck for password to be alphanumeric

            
            //comparing password and ConfirmPassowrd
            if($password != $confirm) {
                $errorsEDB[] = 'Your Passwords do NOT match!'; //error message added to errors array.
            }//end if
        

            //Check if any errors are in errorsEDB array and display them. if not then ADD USER TO DATABASE
            if(!empty($errorsEDB)){
                //if any errors occur then display errors
                echo display_errors($errorsEDB);
            }else{
                //Add User to Database
                $hashed = md5($password);//encryption of password if no errors
                $db -> query("INSERT INTO users (`username`, `email`, `password`, `permissions`) 
                                     VALUES ('$username', '$email', '$hashed', '$permissions') ");
                $successEDB[] = "User Added Successfully!";
                echo display_success($successEDB);
                echo '<script> setTimeout(function(){window.location="users.php"}, 3000); </script>';

            }//end if - display errors

        }//end if - post happened
?>

      <!--ADD NEW USER FORM-->
      <h2 class="brands-title">Add New User..</h2><hr>
      <form action="users.php?add=1" method="post">
            <div class="form-group col-md-3 userAddFormCSS">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?=$username;?>">
            </div>
            <div class="form-group col-md-3 userAddFormCSS">
                <label for="email">Email Address:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
            </div>
            <div class="form-group col-md-3 userAddFormCSS">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
            </div>
            <div class="form-group col-md-3 userAddFormCSS">
                <label for="confirm">Confirm Password:</label>
                <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
            </div>
            <div class="form-group col-md-3 userAddFormCSS">
                <label for="permissions">Permissions:</label>
                <select class="form-control" name="permissions" id="permissions">
                    <option value="" <?=(($permissions == '')? ' selected' : ''); ?> ></option>
                    <option value="user" <?=(($permissions == 'user')? ' selected' : ''); ?> >User</option>
                </select>
            </div>
            <div class="form-group">
                <center>
                    <input type="submit" value="Add User" class="btn btn-success" style="font-weight:bolder; font-size:18px;"> &nbsp;
                    <a href="users.php" class="btn btn-danger" style="font-weight:bolder; font-size:18px;">Cancel</a>
                </center>
            </div>
      </form>


<?php
    }else{
        //if add new user btn is not clicken then show the table 

        //grab user info from database $db
        $username = $_SESSION['username']; 
        $user_query = $db -> query("SELECT * FROM users ORDER BY username ");
?>

<!--******************************************** USER TABLE - ADMIN *************************************************-->

        <h2 class="brands-title">Users List..</h2><hr>

        <center><a href="users.php?add=1" id="add_product_btn" class="btn btn-success"><b>Add New User</b></a></center> <hr>

        <!--Archived Table-->
        <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
            <thead class="table-dark">
                <th></th>
                <th>Username</th>
                <th>Email</th>
                <th>Join Date</th>
                <th>Last login</th>
                <th>Permissions</th>
            </thead>
            <tbody>
                <!--dynamically display users from database-->
                <?php while($user = mysqli_fetch_assoc($user_query)): ?>
                    <tr>
                        <td>
                            <?php if($user['username'] != 'Admin'):/*if the user is not admin then give the row a delete buttton*/ ?>
                            <a href="users.php?delete=<?=$user['id'];?>"class="btn btn-xs btn-light" data-toggle="tooltip" data-placement="right" delay="0" title="Delete User">
                                <i class="far fa-trash-alt"></i>
                            </a>
                            <?php endif;?>
                        </td>
                        <td><?=$user['username'];?></td>
                        <td><?=$user['email'];?></td>
                        <td><?=pretty_date($user['join_date']);?></td>
                        <td><?=(($user['last_login'] == '0000-00-00 00:00:00')? 'Never' : pretty_date($user['last_login']));?></td>
                        <td><?=$user['permissions'];?></td>
                    </tr>
                <?php endwhile;?>
            </tbody>
        </table>

<!--************************************************************************************************************-->
<?php
    
    }//end if- add new user. if new user clicked then addForm else show table

    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters

?>
