<?php
require_once('../core/init.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
include('../includes/head.php');

//populate dropdown from database table
include('../includes/navigation.php');
?>
    
<?php
   //if cart is filled then display items. so we grab stuff to create the logic
   if($cart_id != ''){
       //cart is filled
       $cartQ = $edb->query("SELECT * FROM cart WHERE id = '{$cart_id}' ");
       $result = mysqli_fetch_assoc($cartQ);
       //get us a json array that is loaded into the cart table
       $items = json_decode($result['items'], true); //decode the json array to get individual items. 2nd param true forces it to decode as an assco array
       //var_dump($items);
       $i = 1;
       $sub_total = 0;
       $item_count = 0;
   }//end if
?>


<!--****************  MAIN CONTENT OF USER CART PAGE ********************************-->
<h2 class="page-title">My Shopping Cart..</h2><hr>
<div class="row">
    <div class="col-xl-12">

        <!--<div class="row">-->
            <?php if($cart_id == ''): ?>
                <!--if no items in shopping cart then-->
                <div class="bg-warning CartEmptyDiv">
                    <p class="text-center text-danger" style="font-size:15px; font-weight:bold; margin-bottom:300px;">
                        Your Shopping Cart is Currently Empty! :)
                    </p>
                </div>
            <?php else: ?>
               <!--Else display a table filled with your items-->
               <table class="table table-active table-striped table-bordered table-condensed tableSize" style="width:auto;">
                   <thead class="table-dark totals-table-header">
                       <th>#</th><th>Item</th><th>Price</th><th>Quantity</th><th>Size</th><th>Sub-Total</th>
                   </thead>
                   <tbody>
                       <?php 
                          foreach($items as $item){
                              $product_id = $item['id'];
                              $productQ = $edb->query("SELECT * FROM products WHERE id = '{$product_id}' ");
                              $product = mysqli_fetch_assoc($productQ);
                              
                              $sArray = explode(',' , $product['sizes']); //size array
                              foreach($sArray as $sizeString){
                                  $s = explode(':' , $sizeString);
                                  //compare and grab the qty of the size in the array
                                  //first element $s[0] is the size and $s[1] is the qty
                                  if($s[0] == $item['size']){
                                      $available = $s[1]; //how many available
                                  }//end nested if - compare and grab qty
                              }//end nested foreach
                        ?>
                           
                        <!--Row for each item. We broke out of php & will jump right inafter to complete the foreach closing tag-->
                        <tr>
                            <td><?= $i; ?></td><!--Sr.No-->
                            <td><?= $product['title']; ?></td>
                            <td><?= money($product['price']); ?></td>
                            <td>
                                <!--Qty minus btn-->
                                <button class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="right" title="Quantity - 1"
                                        onclick="update_cart('removeone','<?=$product['id'];?>','<?=$item['size'];?>');" >
                                    <i class="fas fa-minus"></i>
                                </button> &nbsp;
                                <!--Qty displayed-->
                                <?= $item['quantity']; ?> &nbsp;
                                <!--Qty plus btn and we want plus btn to exist only if more items are available-->
                                <?php if($item['quantity'] < $available): ?>
                                    <button class="btn btn-sm btn-light" data-toggle="tooltip" data-placement="right" title="Quantity + 1"
                                            onclick="update_cart('addone','<?=$product['id'];?>','<?=$item['size'];?>');">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                <?php else:?>
                                    <!--else if the qty is equal to available items in edb then display msg saying max limit reached-->
                                    <span class="text-danger">Max Limit</span>
                                <?php endif;?>
                            </td>
                            <td>(US) - <?= $item['size']; ?></td>
                            <td><?= money($item['quantity'] * $product['price']); ?></td> <!--subtotal displayed-->
                        </tr>

                       <?php  
                            //increment the $i  which is the Sr.No in the table
                            $i++;

                            //keep track of item counts in the cart so we know how many items are being delivered
                            $item_count += $item['quantity'];
                            //keep a running sub-total each time we go thru the loop
                            $sub_total += ($product['price'] * $item['quantity']);

                          }//end foreach

                          $tax = TAXRATE * $sub_total; //gives us the tax we apply on sub_total items
                          $tax = number_format($tax, 2); //format the val to get 2 decimal places
                          $grand_total = $tax + $sub_total;

                       ?>

                   </tbody>
               </table>

               <!--SEPERATE TABLE TO KEEP TRACK OF OUR TOTALS-->
               <table class="table table-bordered table-active table-condensed tableSize text-right" style="width:auto;">
                   <legend class="page-title">My Totals:</legend>
                   <thead class="table-info text-dark totals-table-header">
                       <th>Total Items</th><th>Sub-Total</th><th>Tax</th><th>Grand Total</th>
                   </thead>
                   <tbody>
                       <tr>
                          <td><?= $item_count; ?></td>
                          <td><?= money($sub_total); ?></td>
                          <td><?= money($tax); ?></td>
                          <td class="table-success" style="font-weight:bold;"><?= money($grand_total); ?></td>
                       </tr>
                   </tbody>

               </table>


               <!--Add a Check Out Button and (MODAL)-->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#checkoutModal" 
                        style="margin:0 auto; display:block; margin-bottom:30px">
                        <i class="fas fa-shopping-cart"></i> Check Out >>
                </button>
                <!-- Check out btn Modal -->
                <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title page-title" id="checkoutModalLabel">Shipping Address</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body form-horizontal">
                            <div class="row">
                                <form action="../thankYou.php" method="post" id="payment-form">
                                    <!--ERROR OR SUCCESS MESSAGE SPAN-->    
                                    <span class="bg-warning text-danger" id="payment-errors"></span>

                                    <!--hidden elements for thankyou page start-->
                                    <input type="hidden" name="tax" value="<?=$tax;?>">
                                    <input type="hidden" name="sub_total" value="<?=$sub_total;?>">
                                    <input type="hidden" name="grand_total" value="<?=$grand_total;?>">
                                    <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
                                    <input type="hidden" name="description" value="<?=$item_count.' item'.(($item_count>1)?'s' : '').' from CartBugs Shoppe';?>">
                                    <!--hidden elements for thankyou page end-->
                                    
                                    <!--STEP 1 OF CHECKOUT-->
                                    <div class="col-md-12" id="step1" style="display:block;">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="full_name">Full Name:</label>
                                                <input class="form-control" type="text" name="full_name" id="full_name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email_addr">Email:</label>
                                                <input class="form-control" type="email" name="email_addr" id="email_addr"/>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="street">Street Address 1:</label>
                                                <input class="form-control" type="text" name="street" id="street" data-stripe="address_line1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="street2">Street Address 2:</label>
                                                <input class="form-control" type="text" name="street2" id="street2" data-stripe="address_line2">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="city">City:</label>
                                                <input class="form-control" type="text" name="city" id="city" data-stripe="address_city">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="state">State:</label>
                                                <input class="form-control" type="text" name="state" id="state" data-stripe="address_state">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="zip_code">Zip Code:</label>
                                                <input class="form-control" type="text" name="zip_code" id="zip_code" data-stripe="address_zip">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="country">Country:</label>
                                                <input class="form-control" type="text" name="country" id="country" data-stripe="address_country">
                                            </div>
                                        </div><!--end step 1 inner row-->
                                    </div><!--end Step 1 container col-md-12-->

                                    <!--STEP 2 OF CHECKOUT-->
                                    <div class="col-md-12" id="step2" style="display:none;">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="name">Name on Card:</label>
                                                <input type="text" id="name" class="form-control" data-stripe="name"> <!--do not put a name field because we have to be PCI compliant. if we put a nam tag then that info goes to our server and we are liable for that information. so we skip adding that attribute when ever we are dealing with card details-->
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="number">Card Number:</label>
                                                <input type="text" id="number" class="form-control" data-stripe="number">
                                            </div>
                                            <div class="form-group col-md-3"></div>
                                            <div class="form-group col-md-2">
                                                <label for="cvc">CVC:</label>
                                                <input type="text" id="cvc" class="form-control" data-stripe="cvc">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="exp-month">Expire Month:</label>
                                                <select id="exp-month" class="form-control" data-stripe="exp_month">
                                                    <option value=""></option>
                                                    <?php for($i=1; $i< 13; $i++):?>
                                                        <option value="<?=$i; ?>"> <?=$i; ?> </option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="exp-year">Expire Year:</label>
                                                <select id="exp-year" class="form-control" data-stripe="exp_year">
                                                    <option value=""></option>
                                                    <?php $yr = date("Y"); /*set current year*/?>
                                                    <?php for($i=0; $i < 11; $i++):?>
                                                        <option value="<?=$yr + $i;?>"> <?=$yr + $i;?> </option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                        </div><!--end step2 inner row-->
                                    </div><!--end Step 2 container col-md-12-->
    
                            </div> <!--end main row-->
                        </div> <!--end modal body-->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" onclick="check_address();" id="next_button">Next >></button>
                            <!--After Step2 we want the button to save and submit so we use a ternary if to show the btn if step2 is complete-->
                            <button type="button" class="btn btn-info" onclick="back_address();" id="back_button" style="display:none;">
                                << Back to Adress
                            </button>
                            <button type="submit" class="btn btn-success" id="checkout_button" style="display:none;">
                                Check Out >>
                            </button>

                                    </form> <!--payment form end-->
                        </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
       <!-- </div> end inner row div-->

    </div> <!--end 12 col first div-->
</div> <!--end row div-->


<!--*********************  JQ CODE FOR CHECKOUT PROCESS ******************************-->

<script>
    //Step 2 of the Checkout process. Create a back to Step 1 button
    function back_address(){
        jQuery('#payment-errors').html("");//clear out if any errors were shown on Step 2 modal screen
        //revert back all the css change we did using the check_address() so we can revert back to showing the Step 1 modal
        jQuery('#step1').css("display","block");
        jQuery('#step2').css("display","none");
        jQuery('#checkoutModalLabel').html("Shipping Address"); //change the modal title
        jQuery('#next_button').css("display","block");
        jQuery('#back_button').css("display","none");
        jQuery('#checkout_button').css("display","none");

    }//end func back_address


    //function to verify if the shipping address info is valid
    function check_address(){
        var data = { //created an json object
                    'full_name' : jQuery('#full_name').val(),
                    'email_addr' : jQuery('#email_addr').val(),
                    'street' : jQuery('#street').val(),
                    'street2' : jQuery('#street2').val(),
                    'city' : jQuery('#city').val(),
                    'state' : jQuery('#state').val(),
                    'zip_code' : jQuery('#zip_code').val(),
                    'country' : jQuery('#country').val(),
                    };
        //make an ajax call
        $.ajax({
            url: '/ASP_Project/admin/parsers/check_address.php',
            type: 'POST',
            data: data, 
            success : function(data){
                console.log(data);
                //data param here is not the same as data declared above. its the data thats coming from your addr check parser file
                //check 1
                if(data != 'passed'){
                    //we found errors
                    jQuery('#payment-errors').html(data);
                }//end if Check 1

                //Check 2
                if(data.trim()  == 'passed'){
                    //validation passed
                    jQuery('#payment-errors').html("");//clear out if any errors were shown
                    //when next btn is clicked make the step 2 visible and step 1 invisible and show the other 2 btns
                    jQuery('#step1').css("display","none");
                    jQuery('#step2').css("display","block");
                    jQuery('#checkoutModalLabel').html("Card Details"); //change the modal title
                    jQuery('#next_button').css("display","none");
                    jQuery('#back_button').css("display","inline-block");
                    jQuery('#checkout_button').css("display","inline-block");
                }//end if - check 2

            },//end success
            error : function(){
                alert("Something went Wrong with Your Request! Please try again!");
            } //end error
        });//end ajax call

    }//end func check_address


    //CHECK OUT PROCESS
    //STEP 1: DECLARE THE STRIPE VAR AND ELEMENT 
    Stripe.setPublishableKey('<?= STRIPE_PUBLIC; ?>'); //we do not disclose out private key


    
    //STEP 3: if token created then send it to the server
    function stripeResponseHandler(status, response){
        var $form = $('#payment-form');

        if(response.error){
            //show the errors on the form
            $form.find('#payment-errors').text(response.error.message);
            $form.find('button').prop('disabled', false); // Re-enable submission
        }else{
            //response contains id and card, which contains additional card details
            var token = response.id;
            //insert the token into the form so it gets submittedto the server
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            //and submit form
            $form.get(0).submit();
        }
    };//end func stripeResponseHandler


    //STEP 2:create a single use token for the STRIPE transaction
    // Create a token or display an error when the form is submitted.
    jQuery(function($){
        $('#payment-form').submit(function(event){
            var $form = $(this);

            //diable the submit button to prevent repeated calls
            $form.find('button').prop('disabled', true);

           //create a new token so it grans the form info and handles the info
            Stripe.card.createToken($form, stripeResponseHandler);
            /*Stripe.card.createToken({
                number: $('#card-number').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#card-expiry-month').val(),
                exp_year: $('#card-expiry-year').val()
                }, stripeResponseHandler); */

            //prevent the form from submitting with default action
            return false;
        });
    });

</script>


<!--***********************  FOOTER SECTION START ************************************-->

<?php
//php file that contains the page footer
include('../includes/footer.php'); //includes the left side bar filters
?>