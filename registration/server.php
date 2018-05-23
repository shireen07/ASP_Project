<?php 

//session_start();

/*problem: Multiple sessions were trying to be opened as the include file in the includes/head.php also had the user 
registration code. ie if the user is not logged in they cant access that page. We solved this by using the following code.
it says if the session is already not existing then open a new session. else continue the old one.*/
//START
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//END


//global variables
$username = "";
$email = "";
$errors = array();

//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
//connecting to the database - user_registration
$db = mysqli_connect('localhost', 'root', '', 'user_registration');

//when the register button is clicked i.e new account being created..
if(isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $username = trim($username);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $email = trim($email);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_1 = trim($password_1);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $password_2 = trim($password_2);

    $emailExist = $db->query("SELECT `email` FROM users WHERE `email` = '$email' ");
    
    //ensuring that form fields are filled properly:
    if(empty($username) || $username == "admin" || $username == "Admin" || $username == "aDMIN" || $username == "aDmIn" || $username == "ADMIN" ) {
       array_push($errors, "<strong>Valid</strong> Username is Required!"); //error message added to errors array.
    }//end if

    //check if email already exists in db then display error. username can be repeated but email needs to be diff
    if(mysqli_num_rows($emailExist) != 0){
        array_push($errors, "Email already Exists. Please try a different one!"); //error message added to errors array.
    }//end if

    if(empty($email)) {
        array_push($errors, "<strong>Valid</strong> Email is Required!"); //error message added to errors array.
     }//end if 

     if(empty($password_1)) {
        array_push($errors, "Password is Required!"); //error message added to errors array.
     }//end if

     //comparing password and ConfirmPassowrd
     if($password_1 != $password_2) {
        array_push($errors, "Passwords do <strong>NOT</strong> match! please try again!"); //error message added to errors array.
     }//end if


     //CHECK IF PASSWORD IS MORE THAN 6 CHARACTERS
     if(strlen($password_1) < 6 || strlen($password_2) < 6){
        array_push($errors, "Password MUST be more than 6 characters!");
     }//end if - password charact chck
     
     //CHECK IF PASSWORD IS ALPHANUMERIC
     if(!preg_match( '/[^A-Za-z0-9]+/', $password_1) || !preg_match( '/[^A-Za-z0-9]+/', $password_2)){
        array_push($errors, "Password MUST be Alphanumeric!");
     }//end if - chck for password to be alphanumeric
        

    //If no errors then save user to database..
    if(count($errors) == 0) {
        $password = md5($password_1); //encrypting passwrd before storing it in the database.
        //$password = password_hash($password_1, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password, permissions) VALUES ('$username', '$email', '$password', 'user')";
        mysqli_query($db, $sql);

        //Log user in and redirect them to homepage
        $username = ucwords(strtolower($username)); //make the camel case first so the welcome msg in nav bar as well as on carousel have username in camelcase
        $_SESSION['username'] = $username;
        //$_SESSION['success'] = "You are now logged in!";
        $_SESSION['success'] = "Hello <strong>$username</strong>! You are now logged in.";
        //header('location: ../php/homePage.php'); //redirected to homepage
        
        //camel case
        $username = ucwords(strtolower($username));

        if($username == "Admin"){
            header('location: ../admin/index.php'); //redirected to admin index page which is admin home 
        }else{
            header('location: ../php/homePage.php'); //redirected to homepage 
        };//end ifelse to check ig its admin

    }//end if

}//end if


//log in the user from Login.php page
if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']); //escapes special characters in a string for use in an SQL statement
    $username = trim($username); //because sometimes ppl add space after a word
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $password = trim($password);

    //ensuring that form fields are filled properly:
    if(empty($username)) {
       array_push($errors, "Username is Required!"); //error message added to errors array.
    }//end if

    if(empty($password)) {
        array_push($errors, "Password is Required!"); //error message added to errors array.
     }else{

     }//end if 

     if(count($errors) == 0){
         $passwordOriginal = $password;
        $password = md5($password); //encrypt passwrd before comparing to the passwrd saved in the database
        //$password = password_hash($password, PASSWORD_DEFAULT);
        $query = $db -> query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
        $user = mysqli_fetch_assoc($query);
        $user_id = $user['id'];
        $userCount = mysqli_num_rows($query);


        //validate if user exists
        if($userCount == 1){
            //camel case
            $username = ucwords(strtolower($username));

            //log the user into the homepage
            $_SESSION['username'] = $username;
            //welcome message when user first logs in
            $_SESSION['success'] = "Hello <strong>$username</strong>! You are now logged in.";
            
            if($username == "Admin" || $username == "admin"){
                header('location: ../admin/index.php'); //redirected to admin index page which is admin home 
            }else{
                header('location: ../php/homePage.php'); //redirected to homepage 
            };//end ifelse to check ig its admin

            //update last_login col for user
            //global $db;
            $date = date("Y-m-d H:i:s");
            $db -> query("UPDATE users SET `last_login` = '$date' WHERE `id` = '$user_id' ");


        }elseif ($userCount == 0){
            array_push($errors, "Wrong username/password Combination!");
        }//end if - user count

                //if session set the get user data log 
                if(isset($_SESSION['username'])){
                    $query = $db -> query("SELECT * FROM users WHERE id = '$user_id' ");
                    $user_data = mysqli_fetch_assoc($query);
                    $fn = explode(' ' , $user_data['username']);
                    $user_data['username'] = fn[0];
                }//end if - user log
                    
     }//end if - errors

}//end if



//Logout code
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location: ../registration/login.php');
}//end if


//change password


?>