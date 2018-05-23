<?php
    /*FINAL USER PAGE. THIS PAGE HANDLES THE PAYMENT TO STRIPE AND DISPLAYS A THANK YOU RECEIPT TO THE USER. IT ADDS A NEW TRANSACTION
    RECORD TO THE TRANSACTIONS TABLE IN THE DATABASE*/

    require_once $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/core/init.php' ;

    //charging the test customer
    //set your secret key | and green stripe is calling the stripe folder vendor the
    \Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

    //get the credit card details submitted by the form in cart.php
    $token = $_POST['stripeToken'];
    
    //var_dump($token);

    //Get the rest of our post data from the form | may of these are hidden elements in the payment form
    $full_name = sanitize($_POST['full_name']);
    $email_addr = sanitize($_POST['email_addr']);
    $street = sanitize($_POST['street']);
    $street2 = sanitize($_POST['street2']);
    $city = sanitize($_POST['city']);
    $state = sanitize($_POST['state']);
    $zip_code = sanitize($_POST['zip_code']);
    $country = sanitize($_POST['country']);
    $tax = sanitize($_POST['tax']);
    $sub_total = sanitize($_POST['sub_total']);
    $grand_total = sanitize($_POST['grand_total']);
    $cart_id = sanitize($_POST['cart_id']);
    $description = sanitize($_POST['description']);
    //stripe wants all the amounts charged to them in cents hence this line so grand total with 2 decimal points times 100 cents
    $charge_amount = number_format((int)$grand_total, 2) * 100;
    //aray for metadata - this is sent to stripe | stripe allows you to save meta data till 20 key value pairs
    $metadata = array(
        "cart_id" => $cart_id,
        "tax" => $tax,
        "sub_total" => $sub_total,
    );

    //var_dump($full_name, $cart_id, $charge_amount, $email_addr, $street);

    //create the charge on stripes Servers - this will charge the test users card
    try{
        $charge = \Stripe\Charge::create(array(
            "amount" => $charge_amount, //amount in cents, again
            "currency" => CURRENCY,
            "source" => $token,
            "description" => $description,
            "receipt_email" => $email_addr, //does it only on LIVE mode. no email sent on TEST mode of STRIPE
            "metadata" => $metadata
            )
        );


        //ADJUST INVENTORY - REDUCE THE SPECIFIC ITEM PURCHASE BY 1 FROM THE PRODUCTS TABLE
        $itemQ = $edb->query("SELECT * FROM cart WHERE id = '{$cart_id}' ");
        $iresults = mysqli_fetch_assoc($itemQ);
        $items = json_decode($iresults['items'], true);
        foreach($items as $item){
            $newSizes = array();
            $item_id = $item['id'];
            $productQ = $edb->query("SELECT sizes FROM products WHERE id = '{$item_id}' ");
            $product = mysqli_fetch_assoc($productQ);
            $sizes = sizesToArray($product['sizes']);
            foreach($sizes as $size){
                //check if product sizes are same to item sizes then we can adjust the inventory by deleteing the qty purchased
                if($size['size'] == $item['size']){
                    $q = $size['quantity'] - $item['quantity'];//new qty = total in db - purchased qty
                    $newSizes[] = array('size' => $size['size'] , 'quantity' => $q, 'threshold' => $size['threshold']);
                }else{
                    //sizes dont match but we still wana add to our old sizes to array
                    $newSizes[] = array('size' => $size['size'] , 'quantity' => $size['quantity'], 'threshold' => $size['threshold']);
                }//end if - nested under foreach nested
            }//end nested foreach
           
            //now we have rebuilt all sizes.create new sizes string to be appended to edb producst table using sizesToString func
            $sizeString = sizesToString($newSizes);
            $edb->query("UPDATE products SET sizes = '{$sizeString}' WHERE id = '{$item_id}' ");              
        }//end foreach - adjust inventory - updates the database


        
        //UPDATE CART - if charge is successful then paid column in cart edb should change from 0 to 1
        $edb->query("UPDATE cart SET paid = 1 WHERE id = '{$cart_id}' ");
        

        //update the transaction table in edb
        $edb->query("INSERT INTO transactions (`charge_id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, 
                    `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`) 
                            VALUES ('$charge->id' , '$cart_id' , '$full_name' , '$email_addr' , '$street' , '$street2' ,
                             '$city' , '$state' , '$zip_code', '$country' , '$sub_total' ,'$tax', '$grand_total',
                             '$description' , '$charge->object' )");


        
        //set our domain
        $domain = (($_SERVER['HTTP_HOST'] != 'localhost')? '.'.$_SERVER['HTTP_HOST'] : false); 
        //setcookie to destroy and then recreate the cookie
        setcookie(CART_COOKIE,'',1,'/',$domain, false); //unset the cookie


    /******************************* CREATE REPLICA OF INCLUDES/HEAD.PHP ****************************************/

?>

        <!--Common product page header -->
        <!--Login needed if user wants to access this page-->
        <?php
        include $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/registration/server.php';
        //if the user is empty they cannot access this page
        //START
        if(empty($_SESSION['username'])){
        header('location: /ASP_Project/registration/login.php');
        }
        //END
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no, shrink-to-fit=no">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">

            <title>Cartbug.com</title>

            <link rel="stylesheet" href="<?php echo SITE_URL;?>/css/productCSS.css">
            <link rel="stylesheet" href="<?php echo SITE_URL;?>/css/pageCSS.css">

            <?php include_once BASEURL.'includes/js_css.php'?>
        </head>
        <body>


<?php


    /******************************* CALL UPON INCLUDES/NAVIGATION.PHP ****************************************/

        //include $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/includes/head.php';
        include $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/includes/navigation.php';


        
    /******************************* CREATE A PRODUCT PURCHASE THANK YOU RECEIPT AND PRINT BTN ************************/



        //print a thankyou message to the screen below
?>
          <h1 class="text-center text-success">Thank You For Your Purchases!</h1><br><br>

          <div id="DivIdToPrint" style="display: block; margin:0 auto;width:700px; border:2px solid teal; border-radius:20px;padding:15px;">
            <p class="text-primary" style="font-size:20px; font-weight:bolder; line-height:1.2;">Your Card has been successfully charged 
            for <?=money($grand_total);?> USD. <br>
            Print this page as a receipt</p>
            <p>Your Receipt Number is: <strong><?=$cart_id;?></strong></p>
            <p>Your Order will be shipped to the address below:</p>
            <address style="line-height:1.5;">
                <strong><?=$full_name;?></strong><br>
                <?=$street;?><br>
                <?=(($street2 != '')? $street2.'<br>' : '');?>
                <?=$city . ', ' . $state .' - '. $zip_code;?><br>
                <?=$country;?><br>
            </address>          
          </div><br><br>

          <center><input class="btn btn-info"  type='button' id='btn' value='Print' onclick='printDiv();'></center><br><br>

          <!--JQ to print-->
          <script>
          function printDiv(){
                var divToPrint=document.getElementById('DivIdToPrint');
                var newWin=window.open('','Print-Window');
                newWin.document.open();
                newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                newWin.document.close();
                setTimeout(function(){newWin.close();},10);
                }
          </script>


<?php


    /******************************* INCLUDE THE FILE INCLUES/FOOTER.PHP AND RESET THE COOKIE **************************/


        include $_SERVER['DOCUMENT_ROOT'].'/ASP_Project/includes/footer.php';

        //set a new cookie
        setcookie(CART_COOKIE, $cart_id, CART_COOKIE_EXPIRE, '/', $domain, false); //set a new cookie


    } catch(\Stripe\Error\Card $e){
        //this card has been declined
        echo $e;
    }//end try-catch



?>