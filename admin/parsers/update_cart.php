
<?php
    //include_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php';
    //ACCESS TO OUR DB'S, CART VARS DEFINED, HELPERS, CONFIG, INIT ETC
   require_once $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/core/init.php';
   //require_once('../core/init.php');

   //success message and error message
   $successEDB = array();
   $errorsEDB = array();

   //declare the 3 params supplied to update_cart() in includes/footer
   $mode = sanitize($_POST['mode']);
   $edit_id = sanitize($_POST['edit_id']);
   $edit_size = sanitize($_POST['edit_size']);

   //query
   $cartQ = $edb->query("SELECT * FROM cart WHERE id = '{$cart_id}' ");
   $result = mysqli_fetch_assoc($cartQ);

   $items = json_decode($result['items'] , true); //decode the assocarray we get from the table

   //set up updated items
   $updated_items = array();

   //set up cookies by setting the domain
   $domain = (($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST'] : false);



   //check against the two modes ie 1)removeone for minus sign to reduce qty and 2)addone for plus sign to add a qty to db and FE
   if($mode == 'removeone'){
       //reduce a qty from the cart. Loops thru each item in our cart and compare to check id and size and then reduce qty if they match
       foreach($items as $item){
           if($item['id'] == $edit_id && $item['size'] == $edit_size){
               $item['quantity'] = $item['quantity'] - 1; //reduce one
           }//end nested if for id and size check
           if($item['quantity'] > 0){
               //add updated item to the updated items
               $updated_items[] = $item;
           }//end nested if
       }//end foreach
   }//end if- check against mode - removeone

   if($mode == 'addone'){
       //Add a qty from the cart. Loops thru each item in our cart and compare to check id and size and then Add qty if they match
       foreach($items as $item){
           if($item['id'] == $edit_id && $item['size'] == $edit_size){
               $item['quantity'] = $item['quantity'] + 1; //reduce one
           }//end nested if for id and size check
           $updated_items[] = $item; //add updated item to the updated items
       }//end foreach
   }//end if- check against mode - addone



   //check to make sure carts not empty
   if(!empty($updated_items)){
       //update the edb
       $json_updated = json_encode($updated_items);
       $edb->query("UPDATE cart SET items = '{$json_updated}' WHERE id = '{$cart_id}' ");
       
       //success message
        $successEDB[] = "Your Cart has been Updated!";
        echo display_success($successEDB);
   }//end if - cart not empty



   //if the shopping carts empty then remove from the edb table and update the cookie
   if(empty($updated_items)){
       $edb->query("DELETE FROM cart WHERE id = '{$cart_id}' "); //delete from table
       setcookie(CART_COOKIE,'',1,'/',$domain, false); //unset the cookie
   }//end if - cart empty
?>  