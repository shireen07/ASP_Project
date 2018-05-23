<?php
   //ACCESS TO OUR DB'S, CART VARS DEFINED, HELPERS, CONFIG, INIT ETC
   require_once $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/core/init.php';
   //require_once('../core/init.php');

   //grab the posted data from the cart.php shipping address modal
   $name = sanitize($_POST['full_name']);
   $email_addr = sanitize($_POST['email_addr']);
   $street = sanitize($_POST['street']);
   $street2 = sanitize($_POST['street2']);
   $city = sanitize($_POST['city']);
   $state = sanitize($_POST['state']);
   $zip_code = sanitize($_POST['zip_code']);
   $country = sanitize($_POST['country']);

   //var_dump($name,$email_addr,$city,$state);

   //set up errors array
   $errors = array();

   //set up required feilds - assoc array (key is the name given to the field in the form => value is the display name of the label)
   $required = array(
       'full_name'=>'Full Name',
       'email_addr'=>'Email',
       'street'=>'Street Address',
       'city'=>'City',
       'state'=>'State',
       'zip_code'=>'Zip Code',
       'country'=>'Country',
   );

   //check if all required feilds are filled out else display error 
                       //$f is for feild and $d is for display
   foreach($required as $f => $d){
       if(empty($_POST[$f]) || $_POST[$f] == ''){
           $errors[] = $d." is Required!"; //each display name $d will be printed as 'is required'
           //break; //so we show just one error at a time
       }//end if - check empty or not
   }//end foreach


   //check if email is valid - using std php library func
   if(!filter_var($email_addr, FILTER_VALIDATE_EMAIL)){
       //EMAIL NOT PROPER
       $errors[] = "Please enter a VALID email!";
   }//end if - email valid


   //display errors in span if errors array is filled
   if(!empty($errors)){
       echo display_errors($errors);
   }else{
       //No errors so proceed to next step
       echo 'passed';
   }//end if - errors array is filled