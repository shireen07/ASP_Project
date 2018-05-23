

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
<!--******************************************* main content *******************************************************-->

      <!--Welcome message on the first slide - START-->
     <!--Login welcome message. Msg pulled from server.php-->
     <div class="loginWelcome_2">
     <?php if (isset($_SESSION['success'])): ?>
           <div class="error success">
               <h3 class="welcometext">
                   <?php 
                      echo $_SESSION['success'];
                      unset($_SESSION['success']);
                   ?>
               </h3>
           </div>
        <?php endif ?>
    </div>
    <!--Welcome message on the first slide - END-->

    
    <!--************  Admin Home ::: DashBoard  ***********************-->

                        <!--Orders to Fill-->
    <?php
        $txnQuery = "SELECT t.id, t.cart_id, t.full_name,t.email, t.description, t.txn_date, t.grand_total, 
                            c.items, c.paid, c.shipped
                            FROM transactions t
                            LEFT JOIN cart c ON t.cart_id = c.id
                            WHERE c.paid = 1 AND c.shipped = 0 
                            ORDER BY t.txn_date"; //can also use INNER JOIN. gives same result
        $txnResults = $edb->query($txnQuery); //now we have our new table so we can loop throu each row to display in td
    ?>

    <div class="col-md-12">
        <h3 class="brands-title">Orders to Ship..</h3>
        <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
            <thead class="table-dark">
                <th></th><th>Name</th><th>Email</th><th>Description</th><th>Total</th> <th>Date</th>
            </thead>
            <tbody>
                <?php while($order = mysqli_fetch_assoc($txnResults)): ?>
                    <tr>
                        <td>
                            <a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-sm btn-info" data-toggle="tooltip" title="Details">
                                <i class="fas fa-info"></i>
                            </a>
                        </td>
                        <td><?=$order['full_name'];?></td>
                        <td><?=$order['email'];?></td>
                        <td><?=$order['description'];?></td>
                        <td><?= money($order['grand_total']);?></td>
                        <td><?= pretty_date($order['txn_date']);?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <br><br>


    <!--****************************************  Admin Reports  ******************************************-->


    <div class="row">

        <!--******************  Sales By Month  ************************-->
        <?php
            //sales by month code
            $thisYr = date("Y");
            $lastYr = $thisYr - 1;
            $thisYrQ = $edb->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '{$thisYr}' ");
            $lastYrQ = $edb->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR(txn_date) = '{$lastYr}' ");
            $current = array();
            $last = array();
            $currentTotal = 0;
            $lastTotal = 0;
            //this year
            while($x = mysqli_fetch_assoc($thisYrQ)){
                $month = date("m", strtotime($x['txn_date']));
                //change month to int
                $month = (int)$month;
                if(!array_key_exists($month, $current)){
                    //if doesnt exist then create and add to array
                    $current[$month] = $x['grand_total']; //loops thru the rows and grabs the month of the row and adds to the current array if not exist
                }else{
                    //does exists then directly add to array
                    $current[$month] += $x['grand_total'];
                }//end if nested 
                $currentTotal += $x['grand_total'];
                $x++; //increment month
            }//end loop 1

            //LAst year
            while($y = mysqli_fetch_assoc($lastYrQ)){
                $month = date("m", strtotime($y['txn_date']));
                //change month to int
                $month = (int)$month;
                if(!array_key_exists($month, $last)){
                    //if doesnt exist then create and add to array
                    $last[$month] = $y['grand_total']; //loops thru the rows and grabs the month of the row and adds to the current array if not exist
                }else{
                    //does exists then directly add to array
                    $last[$month] += $y['grand_total'];
                }//end if nested 
                $lastTotal += $y['grand_total'];
                $y++;
            }//end loop 1
        ?>
        <div class="col-md-4">
            <h3 class="sub-title">Sales Report By Month</h3>
            <table class="table table-active table-striped table-bordered tableSize" style="width:auto;">
                <thead class="table-dark">
                    <th></th>
                    <th><?=$lastYr;?></th>
                    <th><?=$thisYr;?></th>
                </thead>
                <tbody>
                    <?php for($i=1; $i<=12; $i++):
                          //set a datetime variable
                          $dt = DateTime::createFromFormat('!m', $i); //static func            
                    ?>
                        <tr <?=((date("m") == $i)? ' class="table-info"' : '');?>>
                            <td><?=$dt->format('F');?></td>
                            <td><?=((array_key_exists($i, $last))? money($last[$i]) : money(0) );?></td>
                            <td><?=((array_key_exists($i, $current))? money($current[$i]) : money(0) );?></td>
                        </tr>
                    <?php endfor;?>
                    <tr>
                        <td><b>Total:</b></td>
                        <td><b><?=money($lastTotal);?></b></td>
                        <td><b><?=money($currentTotal);?></b></td>
                    </tr>
                </tbody>
            </table>
        </div><!--end sales by month div-->


        
        <!--********************  Brand wise Product Count Report  ****************************-->
        <?php
            $brandCountQ = "SELECT b.id as brandID, b.brand as Brand_name, count(p.id) as Product_Count
                                    FROM products p INNER JOIN brand b ON b.id = p.brand
                                    GROUP BY brandID
                                    ORDER BY brandID IN(SELECT b.brand FROM brand b ORDER BY b.brand ASC)";
            $brandCountR = $edb->query($brandCountQ);
            ?>
        <div class="col-md-4">
            <h3 class="sub-title">Brand-wise Product Count</h3>
            <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
                <thead class="table-dark">
                    <th>Brand ID</th><th>Brand Name</th><th>Products Count</th>
                </thead>
                <tbody>
                    <?php while($brand_count = mysqli_fetch_assoc($brandCountR)): ?>
                        <tr>
                            <td><center><?=$brand_count['brandID'];?></center></td>
                            <td><?=$brand_count['Brand_name'];?></td>
                            <td><center><?=$brand_count['Product_Count'];?></center></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--end brand wise reports div-->



        <!--*********************  Category wise Product Count Report **************************-->
        <?php
            $CatCountQ = "SELECT c.id as CatID, c.category as CatName, count(p.categories) as Product_Count
            FROM products p INNER JOIN categories c ON c.id = p.categories
            GROUP BY CatID
            ORDER BY CatID IN(SELECT c.category FROM categories c ORDER BY c.category ASC)";
            $CatCountR = $edb->query($CatCountQ);
            ?>
        <div class="col-md-4">
            <h3 class="sub-title">Category-wise Product Count</h3>
            <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
                <thead class="table-dark">
                    <th>Child ID</th><th>Category Name</th><th>Products Count</th>
                </thead>
                <tbody>
                    <?php while($cat_count = mysqli_fetch_assoc($CatCountR)): ?>
                        <tr>
                            <td><center><?=$cat_count['CatID'];?></center></td>
                            <td><?=$cat_count['CatName'];?></td>
                            <td><center><?=$cat_count['Product_Count'];?></center></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div><!--end category wise report div-->
        

        
        <!--*************************  Inventory Update Table  ***********************************-->
        <?php
            //grab the database entries for low threshold items. we are keeping a threshold for 2 products to remind admin to fill inventory
            $iQuery = $edb->query("SELECT * FROM products WHERE `deleted` = 0");
            $lowItems = array();
            while($product = mysqli_fetch_assoc($iQuery)){
                $item = array();
                $sizes = sizesToArray($product['sizes']); //we get the size:qty:threshold in an array
                foreach($sizes as $size){
                    //check if qty has come low as threshold then display in table to alert admin
                    if($size['quantity'] <= $size['threshold']){
                        //grab category of each item
                        $cat = get_category($product['categories']); //helper file func gets us our parent and child cat ids and name
                        //add to item array
                        $item = array(
                            'title' => $product['title'],
                            'size' => $size['size'],
                            'quantity' => $size['quantity'],
                            'threshold' => $size['threshold'],
                            'category' => $cat['parent'] .' ~ '. $cat['child']
                        );
                        //add to $lowitems array
                        $lowItems[] = $item;
                    }//end nested if
                
                }//end nested foreach
            }//end while
        ?>

        <div class="col-md-12">
            <h3 class="sub-title">Low Inventory</h3>
            <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
                <thead class="table-dark">
                    <th>Product</th> <th>Category</th><th>Size</th> <th>Quantity</th><th>Threshold</th>
                </thead>
                <tbody>
                    <?php foreach($lowItems as $item): ?>
                        <tr<?= (($item['quantity'] == 0 )? ' class="table-danger"' : '');?>>
                            <td><?=$item['title'];?></td>
                            <td><?=$item['category'];?></td>
                            <td><?=$item['size'];?></td>
                            <td><?=$item['quantity'];?></td>
                            <td><?=$item['threshold'];?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div><!--end low inventory div-->

    </div> <!--end row div-->


<!--******************************************** footer *************************************************************-->

<?php
    //php file that contains the page footer
    include('includes/footer.php'); //includes the left side bar filters

?>