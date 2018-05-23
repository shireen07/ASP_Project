
<?php
//Processing File for NewsLetter
if(isset($_POST['email'])){
    //user clicked submit or pressed enter
    $email = $_POST['email']; //store the val in a var

    //Check 1: Filter email
    if(filter_var($email, FILTER_VALIDATE_EMAIL) && $email != 'admin@cartbugs.com'){
        //email valid then show message and save the email in the subscribers.php file
        $file = file_get_contents(__DIR__.'/subscribers.php', true); //get file
        $file = explode(', ', $file); //explode file which has data and seperate them using commas | we get an indexed array
        //check if email already exists in the file and then show message if does else add email to file
        if(in_array($email, $file)){
            //email exists in file so display error message
            echo "<p class='bg-info text-white'><b>You have already been subscribed!</b></p>";
            echo "<script>setTimeout(location.reload.bind(location), 3000);</script>";
        }else{
            //email not in file so add email to the files array
            $fopen = fopen(__DIR__.'/subscribers.php','a'); //mode a goes to the end of the file to write new data
            fwrite($fopen, $email.', ');
            fclose($fopen);
            echo "<p class='bg-success text-white'><b>Thank You for Subscribing!</b></p>";
            echo "<script>setTimeout(location.reload.bind(location), 3000);</script>";
            
        }//end if nested check 1

    }else{
        //email invalid
        echo "<p class='bg-warning text-danger'><b>Please enter a VALID email id..</b></p>";
    }//end if - check 1

}//end if


?>