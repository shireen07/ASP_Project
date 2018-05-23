
<?php
   //ACCESS TO OUR DB'S, CART VARS DEFINED, HELPERS, CONFIG, INIT ETC
   require_once $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/core/init.php';
   //require_once('../core/init.php');

   //success message and error message
   $successEDB = array();
   $errorsEDB = array();

   //grab all variables from our post data from detailsModal page
   $product_id =  isset($_POST['product_id'])? sanitize($_POST['product_id']):'';
   $size = isset($_POST['size'])? sanitize($_POST['size']):''; 
   $available = isset($_POST['available'])? sanitize($_POST['available']):''; 
   $quantity = isset($_POST['quantity'])? sanitize($_POST['quantity']):'';

   //empty array
   $item = array();
   //add to the array another array and create a multidimensional array for each item
   $item[] = array(
       'id'=>$product_id,
       'size'=>$size,
       'quantity'=>$quantity, 
   );

   /* STEP SOLVES ISSUES WITH COOKIES
   for security reasons browsers wont accept domains like local host so we create our custom variable so 
   we can set/access a cookie. So we create a ternary if - so we can do a check if its a localhost or not
   so if its not localhost we add a period because older broswers need to begin with a dot and concat with the http_host
   else we return false
    */
   $domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST'] : false;
   $domain='';
   //$domain = (($_SERVER['DOCUMENT_ROOT'] != 'localhost')? $_SERVER['DOCUMENT_ROOT']:'false');

   //SQL QUERY TO GET product id from the json array declared above
   $query = $edb->query("SELECT * FROM products WHERE `id` = '{$product_id}'");
   $product = mysqli_fetch_assoc($query);
   /* //success message called in the success section ajax func fired in the footer func add_to_cart()
   echo '<script>
            var msg ="";
            msg += "<p class="text-center bg-success text-white"><b>Items added to the Cart!</b></p>";
            jQuery("#displayMessage").html(msg);
        </script>'; */


   //check if to seet if CART_COOKIE exists
   if($cart_id != ''){
       //already cart set and update cart to add a new product to it
       //grab the cart
       $cartQ = $edb->query("SELECT * FROM cart WHERE id = '{$cart_id}' ");
       $cart = mysqli_fetch_assoc($cartQ);
       $previous_items = json_decode($cart['items'], true); //json encoded col so json decode it. 2nd param true returns an assoc array
       //Check 1: the items we are adding already exixts in the edb so we make the items 0 first
       $item_match = 0;
       $new_items = array();
       foreach($previous_items as $pitem){
           //check for first item in array is same as $previous_items id
           if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
               //values match so update cell
               $pitem['quantity'] = $pitem['quantity'] + $item[0]['quantity'];
               //nested check to add only whats available in the shopping cart | //if you have added the same size same item to the cart again then it just updates the qty 
               if($pitem['quantity'] > $available){
                   $pitem['quantity'] = $available; // so if we try to get more than whats available it will just reset to whats available
               }//end if for nested check

               $item_match = 1;
           }//end if

           $new_items[] = $pitem; //if you have added the same size same item to the cart again then it just updates the qty 
       }//end foreach - check 1

       //check 2: if size and id doesnt match then its a new item then just update the cell to add a new item to the table cell
       if($item_match != 1){
           //add new item to table cell
           $new_items = array_merge($item , $previous_items); //adds new items before the old items in the table so we can display it the same way in the cart FE page
       }//end if - check 2

       //now we have new items either set up in the new items arraay or the qty updated So next is json encode the items and update table
       $items_json = json_encode($new_items); 
       $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
       $edb->query("UPDATE cart SET items = '{$items_json}', expire_date = '{$cart_expire}' WHERE id = '{$cart_id}' ");
       //unset a cookie - just set the cookie again
       setcookie(CART_COOKIE,'', 1, "/", $domain, false); //set the cookie so it expires
       setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false); //set a new cookie
   
   }else{
       //cart_cookie doesnt exists so create a new cart to database and set cookie
       $items_json = json_encode($item);
       //grab the cart expire which is stored in edb. THIS IS NOT THE CART_COOKIE_EXPIRE
       //it takes todays datetime and plus 30 days to it and format and save in edb cafrt table
       $cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
       $edb->query("INSERT INTO cart (items,expire_date) 
                             VALUES ('{$items_json}','{$cart_expire}')");
       //set the cart id
       $cart_id = $edb->insert_id; //returns the last inserted id
       //$cart_id = $edb->lastInsertId();

       /*set the cookie using prebult func :~
        setcookie(name of the cokie,value of the cookie,expire date, path is just the root for us, 
                        domain which will be either be false or our http_host, and for security we turn it off so false
                        which will let us set and access cookies on localhost) */
       setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false);
   }//end ifelse - cart cookie exists or not
?>