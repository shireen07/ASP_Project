
<!--widget in the RHS filter area of the categories page-->
<h3 class="text-center" id="widget_title">Shopping Cart</h3>
<div>
    <?php if(empty($cart_id)): /*if cart empty show image and message*/?>
        <img src="/ASP_Project/images/ladybug.png" alt="ladybug cart" width="170px">
        <p id="widget_empty_msg">Your Shopping Cart is Empty...!</p>
    <?php else: 
            //else show the items in users cart
            $cartQ = $edb->query("SELECT * FROM cart WHERE id = '{$cart_id}' "); 
            $results = mysqli_fetch_assoc($cartQ);
            $items = json_decode($results['items'], true); //decode the json string we got back in the results and true cz we want an assoc array we can run through a loop to display
            $subtotal = 0; 
    ?>
            <!--display $items using foreach in a table-->
            <table class="table table-condensed" id="cart_widget">
                <tbody>
                    <?php foreach($items as $item):
                        $productQ = $edb->query("SELECT * FROM products WHERE id= '{$item['id']}' ");
                        $product = mysqli_fetch_assoc($productQ);//grab product and for each product we do a row in the table
                    ?>
                        <tr>
                            <td><?=$item['quantity']; ?></td>
                            <td><?=substr($product['title'],0,15);?></td> <!--substr limits the amt of charac we display here we are saying 0 to 15 charac-->
                            <td><?=money($item['quantity'] * $product['price']); ?></td> <!--subtotal-->
                        </tr>
                    <?php 
                        //increment $subtotal each time before ending the loop finally
                        $subtotal += ($item['quantity'] * $product['price']);
                        endforeach;
                    ?>
                        <!--Row for Grand total-->
                        <tr class="text-info">
                            <td></td>
                            <td><b>Sub Total :</b></td>
                            <td><b><?= money($subtotal); ?></b></td> <!--we incremented the subtotal each time when an item displayed in the forloop-->
                        </tr>
                </tbody>
            </table>

            <!--Add a link to the Cart php page so user can pay-->
            <a href="/ASP_Project/php/cart.php" class="btn btn-sm btn-outline-dark float-right">View Cart</a>
            <div class="clearfix"></div>

    <?php endif; ?>
</div>
