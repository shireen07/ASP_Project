

<!--Footer Container Start-->
<footer class="footer">
    <div class="container-fluid" style=" width:100%; margin: 0px 10px 0px 10px;">
        <div class="row">
        <div class="col-xl-3 footer-one">
        <div class="foot-logo">
              <img src="../images/CartBugLogo.png" style=" width:30%; float:left; margin-right:3%;">
              <h4 class="title" style="font-size:22px;"> About us</h4>
		      </div> 
            
            <p style="line-height:1.5;">We are a <small style="color:yellow; font-size:15px;">Tiny</small> 
                                       Company but our work is <strong>ABSOLUTELY HUGE.<br/></strong>
                                      We partner with Brands to deliver World-class digital Shopping experience</p>
            <ul class="social-icon">
            <a href="https://www.facebook.com/" class="social"><i class="fab fa-facebook-square" aria-hidden="true"></i></a>
            <a href="https://twitter.com/" class="social"><i class="fab fa-twitter" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/" class="social"><i class="fab fa-instagram" aria-hidden="true"></i></a>
            <a href="https://www.youtube.com/" class="social"><i class="fab fa-youtube" aria-hidden="true"></i></a>
            <a href="https://www.google.com/" class="social"><i class="fab fa-google" aria-hidden="true"></i></a>
            <a href="https://dribbble.com/" class="social"><i class="fab fa-dribbble" aria-hidden="true"></i></a>
            </ul>
        </div>
        <div class="col-xl-3">
            <h4 class="title" style="font-size:22px;">Quick Links</h4>
            <span class="acount-icon" style="line-height:1.5;">          
            <a href="<?php echo SITE_URL;?>/php/homePage.php"><i class="fas fa-user-circle" aria-hidden="true"></i> Your Account</a>
            <a href="<?php echo SITE_URL;?>/php/expertAdvice.php"><i class="far fa-file-alt" aria-hidden="true"></i> Newsletter Signup</a>
            <a href="#"><i class="fas fa-chess-knight" aria-hidden="true"></i> Careers</a>
            <a href="#"><i class="fas fa-globe" aria-hidden="true"></i> Avout Us</a>           
            </span>
        </div>
        <div class="col-xl-3">
            <h4 class="title" style="font-size:22px;">Collections~</h4>
            <div class="category" style="line-height:1.5;">
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=6">Women's Apparels</a>
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=14">Skin Care</a>
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=18">Fragrances</a>
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=9">Formal Wear</a>
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=20">Candles</a>
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=8">Jeans</a>
                <a href="<?php echo SITE_URL;?>/php/category.php?cat=21">Gifts</a>           
            </div>
        </div>
        <div class="col-xl-3">
            <h4 class="title">Payment</h4>
            <p style="line-height:1.5;">Build loyalty and benefits from years of innovation.<br> We accept the following payment modes</p>
            <ul class="payment">
                <li><a href="https://portal.discover.com/customersvcs/universalLogin/ac_main"><i class="fab fa-cc-discover" aria-hidden="true"></i></a></li>
                <li><a href="https://www.paypal.com/signin?country.x=US&locale.x=en_US"><i class="fab fa-paypal" aria-hidden="true"></i></a></li>            
                <li><a href="https://usa.visa.com/"><i class="fab fa-cc-visa" aria-hidden="true"></i></a></li>
                <li><a href="https://pay.amazon.com/us"><i class="fab fa-amazon-pay" aria-hidden="true"></i></a></li>
            </ul>
            </div>
        </div>
        <hr style="border:none; height:1px;background-color:white; width:100%;">
        <div class="footer-bottom">
        <div class="container">
					<div class="row">
						<div class="col-sm-6 ">
							<div class="copyright-text">
								<p>CopyRight © 2018 Digital All Rights Reserved</p>
							</div>
						</div> <!-- End Col -->
						<div class="col-sm-6">
						    <div class="copyright-text pull-right">
                <p> <a href="homePage.php" style="color:royalblue;">Home</a> | 
                    <a href="#" style="color:royalblue;">Privacy</a> |
                    <a href="#">Terms & Conditions</a> | 
                    <a href="#">Refund Policy</a> </p>
							</div>					
													
						</div> <!-- End Col -->
					</div>
				</div>
    </div>
</div>	
</footer>
<!--Footer Container End-->




<!--JS function to display the dynamic data into the detailsModal.php-->
<script>
   function detailsModal(id){
       //creating a onject variable with a JSON string
       var data = {"id" : id};
       //creating a AJAX Http request to call the data from the prod thumbs id and displying it dynamically in the modal
       $.ajax ({
           //baseurl is the main proj folder defined in init.php and we are concatinating the php page path to it
           url : '/ASP_Project/includes/detailsModal.php',
           type: 'POST',
           data : data, //data is given the variable data declared above
           success: function(data){
               //append all the data you get from the detailsModal page to the bottom of the body
               jQuery('body').append(data);
               jQuery('#details-modal').modal('toggle') //#details-modal is the id for the entire modal container
           },
           error : function(){
               alert("We are facing issues with retriving data. Please try again!")
           }
       });
   }//end func detailsModal




   //<!--JS FOR UPDATE CART FUNCTION-->
   function update_cart(mode, edit_id, edit_size){
       var data = {"mode": mode, "edit_id": edit_id, "edit_size": edit_size}; //json object
       //ajax call
       $.ajax({
           url: '/ASP_Project/admin/parsers/update_cart.php',
           type: 'POST',
           data: data,
           success: function(){
               location.reload();
               //setTimeout(location.reload.bind(location), 1500); //success message when item added to cart
           },//end success
           error: function(){
               //anonymous func
               alert("Something went wrong with Your update Request! Please try again!");
           }//end error
       });
   }//end func for update cart




   //<!--JS for Add to Cart function-->
   function add_to_cart(){
       jQuery('#modal_errors').html("");
       //grab values from modal form
       var size = jQuery('#size').val();
       var quantity = jQuery('#quantity').val();
       //create 2 var for error and availablility items
       var available = jQuery('#available').val();
       var error = '';
       /*grab the form and use a JQ function - serialize() - it generated a storable representation of th value ie takes 
       /the values of the form and seriablize them into get param etc so we can pass them later */
       var data = jQuery('#add_product_form').serialize();
       
       //checks. if pass then fire an ajax request to add carts else display errors in modal
       //check for all fields filled:
       if(size == '' || quantity == '' || quantity == 0){
           error += '<p class="text-danger text-center"><b>You MUST select a size & quantity!</b></p>';
           jQuery('#modal_errors').html(error);
           return;
       }else if(quantity > available){
           error += '<p class="text-danger text-center"><b>There is/are only '+ available +' item(s) available in Size: '+ size +'..!</b></p>';
           jQuery('#modal_errors').html(error);
           return;
       }else{
           
           //no errors so process it
           $.ajax({
               //fire an ajax request to process the cart
               url: '/ASP_Project/admin/parsers/add_cart.php',
               type: 'POST',
               data: data,
               success: function(){
                   //reload the page for the cookie to be accessible
                    var msg = "";
                    error += '<p class="text-center bg-success text-white"><b>Item is added to the Cart!</b></p>';
                    jQuery("#modal_errors").html(error);
                    //location.reload();
                    setTimeout(location.reload.bind(location), 1500); //success message when item added to cart
               },//end success
               error: function(){
                   //anonymous func for error
                   alert("Something went wrong with the Request! Please try again!");
               }//end error
           });//end ajax req

       }//end if - check all fields filled
   }//end func add_to cart

</script>



</body>
</html>

