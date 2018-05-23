
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

    //if the user is empty they cannot access this page
    //START
    if(empty($_SESSION['username'])){
      header('location: ../registration/login.php');
    }
    //END
?>

<?php
    $successEDB = array(); //for success message
    $errorEDB = array();//for error message

    // complete our Order Processing if Admin clicks on Complete Prcessing btn in the orders page
    if(isset($_GET['complete']) && $_GET['complete'] == 1){
        //btn clicked
        $cart_id = sanitize((int)$_GET['cart_id']);
        //update table to show as order processed and no longer will be visible in the index page table
        $edb->query("UPDATE cart SET shipped = 1 WHERE id='{$cart_id}' ");
        //set a message for order process Success
        $successEDB[] = "Order has been Processed Successfully!";
        echo display_success($successEDB); //location reload done on line 79 so we can check if query gives output or no
        //echo '<script> setTimeout(function(){window.location="index.php"}, 3000); </script>';
    }//end if - complete order


    //To display Order Details before processing
    //grab the txn_id | We are showing the details of individual purchases
    $txn_id = ((isset($_GET['txn_id']))? sanitize((int)$_GET['txn_id']) : ''); //solves the error: Notice: Undefined index: txn_id in C:\xampp\htdocs\
    $txnQuery = $edb->query("SELECT * FROM transactions WHERE `id` = '{$txn_id}' ");
    $txn = mysqli_fetch_assoc($txnQuery); //we get one cart id ergo we get only one query row
    $cart_id = $txn['cart_id'];

    //query for cart
    $cartQ = $edb->query("SELECT * FROM cart WHERE id = '{$cart_id}' ");
    $cart = mysqli_fetch_assoc($cartQ); //we expect only 1 result

    //grab items from the cart. they are json string. seperate them and find the details for each item
    $items = json_decode($cart['items'], true); //gets us the assco array

    //empty arrays
    $idArray = array();
    $products = array(); 
    //var_dump($items);

    if(is_array($items)){
        //loop through items and grab them as array | start with grabing products
        foreach($items as $item){
            $idArray[] = $item['id']; //array with all the purchased items ids
        }//end foreach
    }//check if $items if indeed an array to avoid error PHP Warning: Invalid argument supplied for foreach()

    //get a string of ids instd of an assoc array 
    $ids = implode(',' , $idArray); //echo $ids;
    $productQ = $edb->query("SELECT i.id as 'id' , i.title as 'title' , 
                                    c.id as 'cid' ,  c.category as 'child' ,
                                    p.category as 'parent'
                                    FROM products i
                                    LEFT JOIN categories c ON i.categories = c.id
                                    LEFT JOIN categories p ON c.parent = p.id
                                    WHERE i.id IN ({$ids})");

    //if query has run and data gets empty then goto index.php
    if (!$productQ) {
        echo '<script> setTimeout(function(){window.location="index.php"}, 3000); </script>';
        exit;
    }
    
    //Looping through the products in the table created above using join stmnt
    while($p = mysqli_fetch_assoc($productQ)){
        //build up a new array that we can print on the FE table
        //check each item
        foreach($items as $item){
            if($item['id'] == $p['id']){
                $x = $item; //if they are equal then add the current item to a new variable each time
                continue; //if x is true the continue out of the loop
            }//end nested if
        }//end nested foreach

        $products[] = array_merge($x , $p); //now each array has 7 elements to it from the join above| we get this from the 2 arrays mixed together using merge
        //var_dump($products);

    }//end while
?>

<!--******************************************* main content  for Orders to Ship Section ********************************-->
    
    <h2 class="brands-title"> Order Details..</h2>
    <!--table for products ordered-->
    <table class="table table-info table-striped table-bordered table-condensed tableSize" style="width:auto;">
        <thead class="bg-info">
            <th>Quantity</th>
            <th>Item Title</th>
            <th>Category</th>
            <th>Size</th>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td><?=$product['quantity'];?></td>
                    <td><?=$product['title'];?></td>
                    <td><?=$product['parent']. ' ~ ' .$product['child'];?></td>
                    <td><?=$product['size'];?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    
    <div class="row">
        <!--Pricing Details -->
        <div class="col-md-6">
            <h3 class="sub-title">Pricing Details</h3>
            <table class="table table-dark table-striped table-bordered table-condensed tableSize" style="width:auto;">
                <tbody>
                    <tr>
                        <td>Sub-Total</td>
                        <td><?=money($txn['sub_total']); ?></td>
                    </tr>
                    <tr>
                        <td>Tax applied</td>
                        <td><?=money($txn['tax']); ?></td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td><?=money($txn['grand_total']); ?></td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td><?= pretty_date($txn['txn_date']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
 
        <!--Shipping Details -->
        <div class="col-md-6">
            <h3 class="sub-title">Shipping Details</h3>
               <table class="table table-dark table-striped table-bordered table-condensed tableSize" style="width:auto;">
                   <tbody>
                       <tr><td><b><?= $txn['full_name']; ?></b> <br></td></tr>
                       <tr>
                            <td>
                                <address>
                                    <?= $txn['street']; ?> <br>
                                    <?= (($txn['street2'] != '')? $txn['street2'].'<br>' : ''); ?>
                                    <?= $txn['city'] .', '.$txn['state'].' - '.$txn['zip_code'];?> <br>
                                    <?= $txn['country']; ?>
                                </address>
                            </td>
                       </tr>
                       <tr><td> </td></tr>
                   </tbody>
               </table>
        </div>

        <!--Navigation btns-->
        <div class="col-md-5"></div>
        <div class="col-md-1 float-right">
            <a href="index.php" class="btn btn-lg btn-danger">&nbsp;&nbsp;&nbsp;&nbsp; Cancel &nbsp;&nbsp;&nbsp;&nbsp;</a>
        </div>
        <div class="col-md-1 float-left">
            <a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-lg btn-success">Comeplete Processing</a>
        </div>
        <div class="col-md-5" style="margin-bottom:100px;">

    </div><!--end row div-->


<!--******************************************** footer *************************************************************-->

<?php
    //php file that contains the page footer
    include('includes/footer.php');
?>