

<!--Footer Container Start-->
<footer class="footer">
    <div class="container-fluid" style=" width:100%; margin: 0px 20px 0px 10px;">
        <div class="row">
        <div class="col-xl-3 footer-one">
        <div class="foot-logo">
              <img src="../images/CartBugLogo.png" style="width:30%; float:left; margin-right:3%;">
              <h4 class="title"> About us</h4>
		      </div> 
            
            <p style="line-height:1.5;">We are a <small style="color:yellow;">Tiny</small> 
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
            <h4 class="title">Quick Links</h4>
            <span class="acount-icon" style="line-height:1.5;">          
            <a href="index.php"><i class="fas fa-user-circle" aria-hidden="true"></i> Your Account</a>
            <a href="index.php"><i class="far fa-file-alt" aria-hidden="true"></i> Reports</a>
            <a href="#"><i class="fas fa-chess-knight" aria-hidden="true"></i> Careers</a>
            <a href="#"><i class="fas fa-globe" aria-hidden="true"></i> Avout Us</a>           
            </span>
        </div>
        <div class="col-xl-3">
            <h4 class="title">User Collections~</h4>
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
            <h4 class="title">Our Payment methods</h4>
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
                <p> <a href="index.php" style="color:royalblue;">Home</a> | 
                    <a href="#" style="color:royalblue;">Privacy</a> |
                    <a href="#" style="color:royalblue;">Terms & Conditions</a> | 
                    <a href="#" style="color:royalblue;">Refund Policy</a> </p>
							</div>					
													
						</div> <!-- End Col -->
					</div>
				</div>
    </div>
</div>	
</footer>
<!--Footer Container End-->
<!---**********************************************************************************************************************-->



<!--JS to populate the Child categories in the Add new Products Admin form in products.php-->
<script>

    //function that is called when size&Qty button is clicked in the add products form
    function updateSizes() {
        var sizeString = '';
        for(var i=1; i <=6; i++){
            //concat onto our size string and only take those inputs that are filled. we dont want the empty inputs
            //size:qty:threshold, size:qty:threshold is the way the array is stored in edb. we want to replicate the same pattern
            if(jQuery('#size'+ i).val() != ''){
                sizeString += jQuery('#size'+i).val() + ':' + jQuery('#qty'+i).val() + ':' + jQuery('#threshold'+i).val() + ',';
            }//end if- is mepty?
        }//end for loop
        //plug the size and qty values entered by admin into the preview area
        jQuery('#sizes').val(sizeString);

    }//end func updateSizes
    

     //func created to get child categories when change occurs in the selector name below
     //Uses an ajax request
     function get_child_options(selected){
         //check for default value set
         if(typeof selected === 'object'){   //if(typeof selected === 'undefined'){
             var selected = '';
         }//end if

         //grab the parent id by using #parent
         var parent_id = jQuery('#parent').val();
         jQuery.ajax({
             url: '/ASP_Project/admin/parsers/child_categories.php',
             type: 'POST',
             data: {parent_id : parent_id, selected : selected}, //creates a data obj and fill it with the parentID value. posting the value to child_cat.php
             success: function(data){
                 jQuery('#child').html(data); //places the html code inside the child id option. it passes the data that we echo off in child_categories.php page
             }, //end success
             error: function(){ alert("We are facing issues with retriving data. Please try again!") } //end error
         });//end ajax request

     }//end func get_child_options


    /*We are listening for the Parent to be selected or changed. once that occurs we fire the change 
    func which fires another func within it */
    jQuery('select[name = "parent"]').change(function(){
        //anonymous func to get the child cat
        get_child_options();
    });

</script>




</body>
</html>

