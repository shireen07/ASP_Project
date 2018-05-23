
<!--BSIC PRODUCT PAGE - SEPERATE ELEMENTS LIKE HEADER, FOOTER, BODY ETC ARE INCLUDED FROM DIFFERENT FILES-->

<?php
//database connection file - initial file
//we are using 2 databases: 'db' is for user_registration database and 'edb' is for products database
require_once('../core/init.php');

//Include files that have seperate elements of the page like header, navbar, main content, footer etc
include('../includes/head.php');

//populate dropdown from database table
include('../includes/navigation.php');

include('../includes/headerFull.php'); //includes the img after the nav bar. we intend to change images per page

include('../includes/leftbar.php'); //includes the left side bar filters


//SQL statemnt for auto-populating product thumbs
$sql = "SELECT * FROM products WHERE featured = 1 AND categories = 6";
$featured = $edb -> query($sql); //method 'query' runs the $sql statement

?>


<!--************************************** PHP CODE - START ****************************************************************-->

    <!--Main Content - START-->
    <div class="col-md-8">
      <h2 class="text-center" style="font-family:'Snowburst One';font-weight:bolder; color:tomato; font-size:35px;">
          Featured Collections..</h2>
      <!--divide the main content into 4 subcolumns-->
      <div class="row">

      <!--IMPORTANT :: Making the code dynamic by populting the thumbs from database 'edb'-->

           <!--Display Product START-->
           <!--wE START THE LOOP HERE TO DISPLAY PRODUCT THUMBS DYNAMICALLY-->
       <!--IMPORTANT :: Making the code dynamic by populting the thumbs from database 'edb'-->
      <?php while($featured && $product = mysqli_fetch_assoc($featured)) :  ?>

           <div class="col-sm-3 text-center" id="main_content_col">
             <img src="<?php echo $product['image'];?>" alt="<?php echo $product['title']; ?>" id="product_Img_Square" />

             <p id="product_title"> <?php echo $product['title']; ?> </p>

             <p id="price_text" class="list price text-danger">List Price: <s>$ <?php echo $product['list_price']; ?> </s></p>

             <p id="price_text"class="price"><strong>Our Price: $ <?php echo $product['price']; ?> </strong></p>

             <!--pass the prod thumbs id from the id col from products table in onclick fucnt to auto-gen 
             the data being displayed in modal-->
             <button type="button" class="btn btn-sm btn btn-info" id="product_info_btn" 
             onclick="detailsModal(<?php echo $product['id']; ?>)">Product Info</button> <!--deleted attr : data-toggle="modal" data-target="#details-modal" -->
          </div><!--Display Product END -->
       

       <?php endwhile; /*ending the product while loop*/ ?> 

      </div><!--end inner row for main content-->
    </div> <!--Main Content - END-->
   
<!--************************************** PHP CODE - END ****************************************************************-->


<?php

//right side bar
include('../includes/rightbar.php');

//php file that includes the pop up modal which contains product info
//include('../includes/detailsModal.php');

//php file that contains the page footer
include('../includes/footer.php'); //includes the left side bar filters

?>

<!--*********************************************************************************-->




<!--JS function to display the dynamic data into the detailsModal.php-->
<script> /*
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
*/
</script>
